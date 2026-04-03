<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments - Admin</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 flex flex-col md:flex-row min-h-screen md:h-screen md:overflow-hidden">
    @include('admin.partials.sidebar', ['activeMenu' => 'payments'])

    <div class="flex-1 min-w-0 flex flex-col md:ml-64 md:h-screen md:overflow-hidden">
        <div class="hidden md:flex shrink-0 justify-between items-center bg-white p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Payment Confirmation</h2>
        </div>

        <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-5">
            @if (session('success'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}</div>
            @endif

            <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col lg:flex-row gap-3 lg:items-center">
                <form method="GET" action="{{ route('admin.pembayaran.index') }}"
                    class="flex flex-1 flex-col lg:flex-row gap-3 lg:items-center">
                    <div class="flex-1 relative">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            placeholder="Search name, WA, or transaction ID..."
                            class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <select name="status" class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm bg-white">
                        <option value="">Semua Status</option>
                        <option value="lunas" {{ ($status ?? '') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="gagal" {{ ($status ?? '') === 'gagal' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <button type="submit"
                        class="px-4 py-2.5 rounded-lg bg-slate-800 text-white text-sm">Filter</button>
                    <a href="{{ route('admin.pembayaran.index') }}"
                        class="px-4 py-2.5 rounded-lg border border-gray-200 text-gray-600 text-sm text-center">Reset</a>
                </form>
                <form method="POST" action="{{ route('admin.pembayaran.clear') }}"
                    onsubmit="return confirm('Hapus semua riwayat pembayaran?')">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2.5 rounded-lg bg-red-50 text-red-600 text-sm hover:bg-red-100">Hapus
                        Riwayat</button>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-4 py-3 text-left">User</th>
                                <th class="px-4 py-3 text-left">Email / WA</th>
                                <th class="px-4 py-3 text-left">Nominal</th>
                                <th class="px-4 py-3 text-left">Transaction ID</th>
                                <th class="px-4 py-3 text-left">Proof</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($payments as $payment)
                                <tr>
                                    <td class="px-4 py-3">{{ $payment->user->nama ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $payment->email }}<br><span
                                            class="text-xs text-gray-500">{{ $payment->no_whatsapp }}</span></td>
                                    <td class="px-4 py-3">Rp {{ number_format($payment->nominal, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">{{ $payment->transaction_id }}</td>
                                    <td class="px-4 py-3">
                                        <a href="{{ asset('storage/' . $payment->bukti_pembayaran) }}" target="_blank"
                                            class="text-blue-600 hover:underline">Lihat Bukti</a>
                                    </td>
                                    <td class="px-4 py-3 capitalize">{{ $payment->status }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            @if ($payment->status === 'pending')
                                                <form method="POST"
                                                    action="{{ route('admin.pembayaran.approve', $payment->id) }}">
                                                    @csrf
                                                    <button
                                                        class="px-3 py-1.5 rounded-lg bg-emerald-600 text-white text-xs">Approve</button>
                                                </form>

                                                <form method="POST"
                                                    action="{{ route('admin.pembayaran.reject', $payment->id) }}"
                                                    class="flex items-center gap-2">
                                                    @csrf
                                                    <input type="text" name="rejection_reason" required
                                                        placeholder="Alasan tolak"
                                                        class="w-36 px-2 py-1.5 rounded border border-gray-300 text-xs">
                                                    <button
                                                        class="px-3 py-1.5 rounded-lg bg-red-600 text-white text-xs">Reject</button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-xs">Sudah diproses</span>
                                            @endif

                                            <form method="POST"
                                                action="{{ route('admin.pembayaran.hide', $payment->id) }}"
                                                onsubmit="return confirm('Sembunyikan dari daftar admin?')">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 text-xs hover:bg-red-100">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">Belum ada pembayaran.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">{{ $payments->links() }}</div>
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
    </script>
</body>

</html>
