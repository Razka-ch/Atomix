<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Members - Atomix Books</title>
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-[#f4f6f8] text-gray-800 min-h-screen md:h-screen md:overflow-hidden flex flex-col md:flex-row">
    @include('admin.partials.sidebar', ['activeMenu' => 'members'])

    <div class="flex-1 min-w-0 flex flex-col md:ml-64 md:h-screen md:overflow-hidden">
        <div class="hidden md:flex shrink-0 justify-between items-center bg-white p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Members</h2>
        </div>

        <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <p class="text-xs text-gray-500">Total Members</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($totalMembers) }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <p class="text-xs text-gray-500">Active Members</p>
                    <p class="text-3xl font-bold mt-1 text-emerald-600">{{ number_format($activeMembersCount) }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <p class="text-xs text-gray-500">Expiring Soon</p>
                    <p class="text-3xl font-bold mt-1 text-amber-500">{{ number_format($expiringSoonCount) }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <p class="text-xs text-gray-500">Expired</p>
                    <p class="text-3xl font-bold mt-1 text-red-500">{{ number_format($expiredCount) }}</p>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.members.index') }}"
                class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col lg:flex-row gap-3 lg:items-center">
                <input type="text" name="search" value="{{ $search }}"
                    placeholder="Search by name, email, or transaction ID..."
                    class="flex-1 rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                <select name="status" class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm bg-white">
                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="expiring" {{ $status === 'expiring' ? 'selected' : '' }}>Expiring Soon</option>
                </select>
                <select name="view" class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm bg-white">
                    <option value="monthly" {{ $viewType === 'monthly' ? 'selected' : '' }}>Monthly View</option>
                    <option value="yearly" {{ $viewType === 'yearly' ? 'selected' : '' }}>Yearly View</option>
                    <option value="all" {{ $viewType === 'all' ? 'selected' : '' }}>All Plan</option>
                </select>
                <button type="submit" class="px-4 py-2.5 rounded-lg bg-slate-800 text-white text-sm">Filter</button>
            </form>

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="px-4 py-3 text-left">Member</th>
                                <th class="px-4 py-3 text-left">Transaction</th>
                                <th class="px-4 py-3 text-left">Expiry Date</th>
                                <th class="px-4 py-3 text-left">Time Remaining</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Month/Year</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($members as $member)
                                @php
                                    $avatar = $member->profile_photo
                                        ? asset('storage/' . $member->profile_photo)
                                        : 'https://ui-avatars.com/api/?name=' .
                                            urlencode($member->nama) .
                                            '&background=0D8ABC&color=fff';
                                    $daysLeft = (int) now()->diffInDays($member->membership_ends_at, false);
                                @endphp
                                <tr class="member-row"
                                    data-expiry="{{ $member->membership_ends_at?->format('Y-m-d') }}T23:59:59">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $avatar }}" class="w-10 h-10 rounded-full object-cover"
                                                alt="avatar">
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $member->nama }}</p>
                                                <p class="text-xs text-gray-500">{{ $member->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $member->latest_transaction_id }}</td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $member->membership_ends_at?->format('M d, Y') }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="countdown text-emerald-600 font-semibold text-xs">Calculating...</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($daysLeft <= 7)
                                            <span
                                                class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-xs">Expiring
                                                Soon</span>
                                        @else
                                            <span
                                                class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs">Active</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ in_array($member->latest_membership_type, ['year', 'tahunan']) ? 'Year' : 'Month' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada member
                                        aktif.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-100">{{ $members->links() }}</div>
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        document.getElementById('menuToggle')?.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        document.getElementById('menuClose')?.addEventListener('click', closeSidebar);

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        const renderCountdown = () => {
            document.querySelectorAll('.member-row').forEach((row) => {
                const countdownNode = row.querySelector('.countdown');
                const expiryString = row.dataset.expiry;
                if (!expiryString || !countdownNode) return;

                const distance = new Date(expiryString).getTime() - Date.now();
                if (distance <= 0) {
                    countdownNode.textContent = 'Expired';
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                countdownNode.textContent = `${days}D-${hours}H-${minutes}M-${seconds}S`;
            });
        };

        renderCountdown();
        setInterval(renderCountdown, 1000);
    </script>
</body>

</html>
