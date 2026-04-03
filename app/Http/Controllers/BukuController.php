<?php

namespace App\Http\Controllers;

use App\Models\BookDownload;
use App\Models\BookFavorite;
use App\Models\BookRating;
use App\Models\Buku;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    public function catalog()
    {
        $category = request('category');

        $vipQuery = Buku::withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->where('access_type', 'member');

        $freeQuery = Buku::withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->where('access_type', 'free');

        if (!empty($category)) {
            $vipQuery->where('kategori', $category);
            $freeQuery->where('kategori', $category);
        }

        $vipBukus = $vipQuery->latest()->take(8)->get();
        $freeBukus = $freeQuery->latest()->paginate(20)->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('books', compact('vipBukus', 'freeBukus', 'categories', 'category'));
    }

    public function vipCatalog()
    {
        $category = request('category');

        $vipQuery = Buku::withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->where('access_type', 'member');

        if (!empty($category)) {
            $vipQuery->where('kategori', $category);
        }

        $vipBukus = $vipQuery->latest()->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('books_member', compact('vipBukus', 'categories', 'category'));
    }

    public function freeCatalog()
    {
        $category = request('category');

        $freeQuery = Buku::withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->where('access_type', 'free');

        if (!empty($category)) {
            $freeQuery->where('kategori', $category);
        }

        $freeBukus = $freeQuery->latest()->paginate(20)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('books_free', compact('freeBukus', 'categories', 'category'));
    }

    public function show(Buku $buku)
    {
        /** @var \App\Models\User|null $authUser */
        $authUser = Auth::user();
        $averageRating = (float) ($buku->ratings()->avg('rating') ?? 0);
        $ratingCount = (int) $buku->ratings()->count();
        $isDownloaded = $authUser ? BookDownload::where('user_id', $authUser->id)->where('buku_id', $buku->id)->exists() : false;
        $userRating = $authUser ? BookRating::where('user_id', $authUser->id)->where('buku_id', $buku->id)->value('rating') : null;
        $isFavorite = $authUser ? BookFavorite::where('user_id', $authUser->id)->where('buku_id', $buku->id)->exists() : false;
        $isMemberOnly = $buku->access_type === 'member';
        $isMemberActive = $authUser?->isMembershipActive() ?? false;
        $canAccessBook = $isMemberOnly ? $isMemberActive : true;
        $generatedDescription = $buku->deskripsi_singkat ?: 'Karya dari ' . $buku->pengarang . ' terbitan ' . $buku->penerbit . ' pada tahun ' . $buku->tahun_terbit . '.';

        return response()->json([
            'id' => $buku->id,
            'judul_buku' => $buku->judul_buku,
            'pengarang' => $buku->pengarang,
            'tahun_terbit' => $buku->tahun_terbit,
            'kategori' => $buku->kategori,
            'access_type' => $buku->access_type,
            'deskripsi_singkat' => $generatedDescription,
            'cover' => $buku->cover ? asset('storage/' . $buku->cover) : null,
            'can_download' => $canAccessBook && !empty($buku->pdf_file),
            'download_url' => route('books.download', $buku),
            'can_read' => $canAccessBook && !empty($buku->pdf_file),
            'read_url' => $buku->pdf_file ? asset('storage/' . $buku->pdf_file) : null,
            'rating_avg' => round($averageRating, 1),
            'rating_count' => $ratingCount,
            'can_rate' => $authUser?->isMembershipActive() && $isDownloaded,
            'user_rating' => $userRating,
            'rate_url' => route('member.books.rate', $buku),
            'can_favorite' => (bool) $authUser && $canAccessBook,
            'is_favorite' => $isFavorite,
            'favorite_url' => route('books.favorite', $buku),
        ]);
    }

    public function rate(Request $request, Buku $buku)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user || !$user->isMembershipActive()) {
            return response()->json(['message' => 'Hanya member aktif yang dapat memberi rating.'], 403);
        }

        $alreadyDownloaded = BookDownload::where('user_id', $user->id)
            ->where('buku_id', $buku->id)
            ->exists();

        if (!$alreadyDownloaded) {
            return response()->json(['message' => 'Rating hanya untuk member yang sudah mendownload buku ini.'], 422);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        BookRating::updateOrCreate(
            ['user_id' => $user->id, 'buku_id' => $buku->id],
            ['rating' => $validated['rating']]
        );

        return response()->json([
            'message' => 'Rating berhasil disimpan.',
            'rating_avg' => round((float) ($buku->ratings()->avg('rating') ?? 0), 1),
            'rating_count' => (int) $buku->ratings()->count(),
        ]);
    }

    public function download(Buku $buku)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user) {
            return back()->with('error', 'Silakan login untuk mengunduh buku.');
        }

        if ($buku->access_type === 'member' && !$user->isMembershipActive()) {
            return back()->with('error', 'Fitur unduh hanya untuk member aktif.');
        }

        if (!$buku->pdf_file || !Storage::disk('public')->exists($buku->pdf_file)) {
            return back()->with('error', 'File buku belum tersedia.');
        }

        if ($buku->access_type === 'member') {
            $todayDownloadCount = BookDownload::where('user_id', $user->id)
                ->whereDate('downloaded_at', now()->toDateString())
                ->count();

            if ($todayDownloadCount >= 2) {
                return back()->with('error', 'Anda sudah mendownload lebih dari batas harian (2 buku per hari).');
            }
        }

        BookDownload::create([
            'user_id' => $user->id,
            'buku_id' => $buku->id,
            'downloaded_at' => now(),
        ]);

        return response()->download(storage_path('app/public/' . $buku->pdf_file), $buku->judul_buku . '.pdf');
    }

    public function index()
    {
        $search = request('search');
        $category = request('category');

        $query = Buku::query();

        if (!empty($search)) {
            $query->where(function ($sub) use ($search) {
                $sub->where('judul_buku', 'like', "%{$search}%")
                    ->orWhere('pengarang', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        if (!empty($category)) {
            $query->where('kategori', $category);
        }

        $bukus = $query->latest()->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.books.index', compact('bukus', 'categories', 'search', 'category'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_buku'   => 'required|string|max:255',
            'pengarang'    => 'required|string',
            'penerbit'     => 'required|string',
            'tahun_terbit' => 'required|digits:4|integer',
            'kategori'     => 'required|string',
            'access_type'  => 'required|in:free,member',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pdf_file'     => 'nullable|mimes:pdf|max:10240',
            'deskripsi_singkat' => 'nullable|string|max:1200',
        ]);

        $data = $request->all();
        $data['admin_id'] = Auth::id();
        $data['stok'] = $data['stok'] ?? 0;

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $data['pdf_file'] = $request->file('pdf_file')->store('book-pdf', 'public');
        }

        Buku::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $book)
    {
        $categories = Category::orderBy('name')->get();
        $buku = $book;

        return view('admin.books.edit', compact('buku', 'categories'));
    }

    public function update(Request $request, Buku $book)
    {
        $buku = $book;

        $request->validate([
            'judul_buku'   => 'required|string|max:255',
            'pengarang'    => 'required|string',
            'penerbit'     => 'required|string',
            'tahun_terbit' => 'required|digits:4',
            'kategori'     => 'required|string',
            'access_type'  => 'required|in:free,member',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pdf_file'     => 'nullable|mimes:pdf|max:10240',
            'deskripsi_singkat' => 'nullable|string|max:1200',
        ]);

        $data = $request->all();
        $data['stok'] = $data['stok'] ?? $buku->stok ?? 0;

        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            if ($buku->pdf_file) {
                Storage::disk('public')->delete($buku->pdf_file);
            }
            $data['pdf_file'] = $request->file('pdf_file')->store('book-pdf', 'public');
        }

        $buku->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $book)
    {
        $buku = $book;

        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        if ($buku->pdf_file) {
            Storage::disk('public')->delete($buku->pdf_file);
        }

        $buku->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }

    public function toggleFavorite(Buku $buku)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Silakan login untuk menambahkan favorit.'], 401);
        }

        if ($buku->access_type === 'member' && !$user->isMembershipActive()) {
            return response()->json(['message' => 'Hanya member aktif yang bisa menambahkan buku ini ke favorit.'], 403);
        }

        $favorite = BookFavorite::where('user_id', $user->id)->where('buku_id', $buku->id)->first();

        if ($favorite) {
            $favorite->delete();

            return response()->json([
                'message' => 'Buku dihapus dari favorit.',
                'is_favorite' => false,
            ]);
        }

        BookFavorite::create([
            'user_id' => $user->id,
            'buku_id' => $buku->id,
        ]);

        return response()->json([
            'message' => 'Buku ditambahkan ke favorit.',
            'is_favorite' => true,
        ]);
    }

    public function favorites()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json(['data' => []]);
        }

        $favoriteBooks = Buku::withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->whereHas('favorites', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->get()
            ->map(function (Buku $book) {
                return [
                    'id' => $book->id,
                    'judul_buku' => $book->judul_buku,
                    'pengarang' => $book->pengarang,
                    'rating' => number_format((float) ($book->ratings_avg_rating ?? 0), 1),
                    'cover' => $book->cover ? asset('storage/' . $book->cover) : null,
                    'access_type' => $book->access_type,
                ];
            });

        return response()->json(['data' => $favoriteBooks]);
    }
}
