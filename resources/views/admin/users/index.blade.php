<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Users Management - Atomix Books</title>
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-[#f4f6f8] min-h-screen md:h-screen md:overflow-hidden font-sans text-gray-800 flex flex-col md:flex-row">
    @include('admin.partials.sidebar', ['activeMenu' => 'users'])

    <div class="flex-1 min-w-0 flex flex-col md:ml-64 md:h-screen md:overflow-hidden">

        <div class="hidden md:flex shrink-0 justify-between items-center bg-white p-6 border-b border-gray-200">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Users</h2>
                <p class="text-sm text-gray-500 mt-1">Manage and view all registered users</p>
            </div>
            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('admin.users.index') }}" class="relative flex items-center">
                    <i
                        class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search users..."
                        class="w-64 pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                        class="ml-2 px-4 py-2.5 rounded-lg bg-slate-800 text-white text-sm">Filter</button>
                </form>
                <button class="w-10 h-10 border border-gray-200 rounded-lg text-gray-500 hover:bg-gray-50 transition"
                    aria-label="Filter users">
                    <i class="fa-solid fa-filter"></i>
                </button>
            </div>
        </div>

        <div class="md:hidden p-4 pb-0">
            <h2 class="text-2xl font-bold text-gray-900">Users</h2>
            <p class="text-xs text-gray-500 mt-1">Manage and view all registered users</p>
            <form method="GET" action="{{ route('admin.users.index') }}" class="relative mt-3 flex items-center">
                <i
                    class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search users..."
                    class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                    class="ml-2 px-4 py-2.5 rounded-lg bg-slate-800 text-white text-sm">Filter</button>
            </form>
        </div>

        <div class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8 space-y-6">

            @if (session('success'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-start justify-between">
                    <div>
                        <div
                            class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center mb-4">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <p class="text-xs text-gray-500 mb-1">Total Users</p>
                        <p class="text-4xl font-bold text-gray-900">{{ number_format($totalUsers) }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-start justify-between">
                    <div>
                        <div
                            class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <p class="text-xs text-gray-500 mb-1">New This Month</p>
                        <p class="text-4xl font-bold text-gray-900">{{ number_format($newThisMonth) }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-start justify-between">
                    <div>
                        <div
                            class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center mb-4">
                            <i class="fa-solid fa-calendar-week"></i>
                        </div>
                        <p class="text-xs text-gray-500 mb-1">This Week</p>
                        <p class="text-4xl font-bold text-gray-900">{{ number_format($thisWeekCount) }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-start justify-between">
                    <div>
                        <div
                            class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center mb-4">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <p class="text-xs text-gray-500 mb-1">Growth Rate</p>
                        <p class="text-4xl font-bold {{ $growthRate >= 0 ? 'text-gray-900' : 'text-red-600' }}">
                            {{ $growthRate >= 0 ? '+' : '' }}{{ $growthRate }}%
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="px-6 py-4 font-medium text-left">User</th>
                                <th class="px-6 py-4 font-medium text-left">Email</th>
                                <th class="px-6 py-4 font-medium text-left">Joined</th>
                                <th class="px-6 py-4 font-medium text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($users as $listedUser)
                                @php
                                    $avatarUrl = $listedUser->profile_photo
                                        ? asset('storage/' . $listedUser->profile_photo)
                                        : null;
                                    $initials = collect(preg_split('/\s+/', trim($listedUser->nama)))
                                        ->filter()
                                        ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                                        ->take(2)
                                        ->implode('');
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if ($avatarUrl)
                                                <img src="{{ $avatarUrl }}" alt="{{ $listedUser->nama }}"
                                                    class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                            @else
                                                <span
                                                    class="w-10 h-10 rounded-full bg-slate-600 text-white text-xs font-bold flex items-center justify-center border border-gray-200">{{ $initials }}</span>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $listedUser->nama }}</p>
                                                <p class="text-xs text-gray-500 capitalize">{{ $listedUser->role }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">{{ $listedUser->email }}</td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $listedUser->created_at?->format('M d, Y') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center">
                                            <form action="{{ route('admin.users.destroy', $listedUser) }}"
                                                method="POST" onsubmit="return confirm('Hapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-500 hover:text-red-700 transition"
                                                    title="Delete user"
                                                    {{ auth()->id() === $listedUser->id ? 'disabled' : '' }}>
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">Belum ada data
                                        user.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div
                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-6 py-4 border-t border-gray-100 bg-white">
                    <p class="text-xs text-gray-500">
                        Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of
                        {{ number_format($users->total()) }} users
                    </p>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        document.getElementById('menuToggle').addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        document.getElementById('menuClose').addEventListener('click', closeSidebar);

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    </script>

</body>

</html>
