<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Menampilkan halaman Contact dengan data dinamis
    // Menampilkan halaman dengan fitur Search & Filter
    public function index(Request $request)
    {
        // Siapkan Query Builder dasar
        $query = Contact::query();

        // 1. Logika Pencarian (Search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        // 2. Logika Filter Status (All, New, Read)
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Hitung statistik (tetap menghitung dari seluruh data, bukan data yang difilter)
        $totalContacts = Contact::count();
        $newMessages = Contact::where('status', 'new')->count();
        $readMessages = Contact::where('status', 'read')->count();

        // Ambil data terbaru, paginasi 5, dan bawa parameter pencariannya (withQueryString)
        $contacts = $query->latest()->paginate(5)->withQueryString();

        return view('admin.contacts.index', compact('contacts', 'totalContacts', 'newMessages', 'readMessages'));
    }

    // Mengubah status pesan menjadi "Read" (Mendukung AJAX)
    public function markAsRead(Contact $contact)
    {
        if ($contact->status === 'new') {
            $contact->update(['status' => 'read']);
        }

        // Jika request datang dari JavaScript (saat tombol mata diklik)
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Pesan ditandai sudah dibaca.');
    }

    // Menghapus pesan
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back()->with('success', 'Pesan berhasil dihapus.');
    }

    public function clearAll()
    {
        Contact::query()->delete();

        return back()->with('success', 'Semua pesan kontak berhasil dihapus.');
    }
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // 2. Simpan ke database (status otomatis 'new' berdasarkan migration)
        Contact::create($validated);

        // 3. Kembalikan ke halaman contacts dengan pesan sukses
        return back()->with('success', 'Terima kasih! Pesan/komplain Anda berhasil dikirim dan akan segera kami proses.');
    }
}
