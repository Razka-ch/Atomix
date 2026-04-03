<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $usersQuery = User::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('created_at');

        $users = $usersQuery->paginate(8)->withQueryString();

        $totalUsers = User::count();
        $newThisMonth = User::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();
        $thisWeekCount = User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();

        $currentWeekCount = User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $previousWeekCount = User::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();

        if ($previousWeekCount === 0) {
            $growthRate = $currentWeekCount > 0 ? 100 : 0;
        } else {
            $growthRate = round((($currentWeekCount - $previousWeekCount) / $previousWeekCount) * 100);
        }

        

        return view('admin.users.index', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'newThisMonth' => $newThisMonth,
            'thisWeekCount' => $thisWeekCount,
            'growthRate' => $growthRate,
            'search' => $search,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'nullable|in:admin,member,user',
        ]);

        User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'user',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,member,user',
        ]);

        $user->nama = $validated['nama'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Tidak bisa menghapus akun admin yang sedang login.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}

