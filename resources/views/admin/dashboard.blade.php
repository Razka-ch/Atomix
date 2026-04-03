<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Atomix Books</title>
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen md:h-screen md:overflow-hidden flex flex-col md:flex-row">
    @include('admin.partials.sidebar', ['activeMenu' => 'dashboard'])

    <div class="flex-1 min-w-0 flex flex-col md:ml-64 md:h-screen md:overflow-hidden">
        <div class="hidden md:flex shrink-0 justify-between items-center bg-white p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama ?? 'Admin') }}&background=0D8ABC&color=fff"
                    alt="User Avatar" class="w-9 h-9 rounded-full object-cover">
                <span class="text-sm font-medium text-gray-700">{{ Auth::user()->nama ?? 'Admin' }}</span>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-blue-600">
                    <p class="text-gray-500 text-sm">Total Books</p>
                    <h3 class="text-2xl font-bold">{{ number_format($totalBooks) }}</h3>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-green-600">
                    <p class="text-gray-500 text-sm">Total Users</p>
                    <h3 class="text-2xl font-bold">{{ number_format($totalUsers) }}</h3>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-amber-500">
                    <p class="text-gray-500 text-sm">Total Members</p>
                    <h3 class="text-2xl font-bold">{{ number_format($totalMembers) }}</h3>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-cyan-600">
                    <p class="text-gray-500 text-sm">Total Contacts</p>
                    <h3 class="text-2xl font-bold">{{ number_format($totalContacts) }}</h3>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-6 text-base md:text-lg">Perkembangan Bulanan User, Member,
                        Buku</h3>
                    <div class="relative w-full h-72">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-6 text-base md:text-lg">Jumlah Buku per Kategori</h3>
                    <div class="relative w-full h-72">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                <div class="bg-white p-5 rounded-xl border border-gray-100">
                    <p class="text-sm text-gray-500">Money Profit</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-1">Rp
                        {{ number_format($moneyProfit, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white p-5 rounded-xl border border-gray-100">
                    <p class="text-sm text-gray-500">Expense Profit</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">Rp {{ number_format($expenseProfit, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white p-5 rounded-xl border border-gray-100">
                    <p class="text-sm text-gray-500">Member Profit</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($memberProfit) }} Member</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-slate-900 text-white rounded-xl p-4">
                    <p class="text-xs uppercase tracking-wide text-slate-300">Net Profit</p>
                    <p class="text-lg font-bold mt-1">Rp {{ number_format($netProfit, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-4">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Margin Profit</p>
                    <p class="text-lg font-bold mt-1">{{ number_format($marginProfit, 2) }}%</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-4">
                    <p class="text-xs uppercase tracking-wide text-gray-500">New Member</p>
                    <p class="text-lg font-bold mt-1">{{ number_format($newMember) }}</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-4">
                    <p class="text-xs uppercase tracking-wide text-gray-500">ROI</p>
                    <p class="text-lg font-bold mt-1">{{ number_format($roi, 2) }}%</p>
                </div>
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

        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: @json($lineLabels),
                datasets: [{
                        label: 'Users',
                        data: @json($usersMonthly),
                        borderColor: '#3b82f6',
                        backgroundColor: '#3b82f6',
                        tension: 0.3,
                    },
                    {
                        label: 'Members',
                        data: @json($membersMonthly),
                        borderColor: '#f59e0b',
                        backgroundColor: '#f59e0b',
                        tension: 0.3,
                    },
                    {
                        label: 'Books',
                        data: @json($booksMonthly),
                        borderColor: '#10b981',
                        backgroundColor: '#10b981',
                        tension: 0.3,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: @json($categoryLabels),
                datasets: [{
                    data: @json($categoryData),
                    backgroundColor: ['#2563eb', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                },
            }
        });
    </script>
</body>

</html>
