<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History - Admin</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 flex flex-col md:flex-row min-h-screen md:h-screen md:overflow-hidden">
    @include('admin.partials.sidebar', ['activeMenu' => 'history'])

    <div class="flex-1 min-w-0 flex flex-col md:ml-64 md:h-screen md:overflow-hidden">
        <div class="hidden md:flex shrink-0 justify-between items-center bg-white p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Payment History</h2>
        </div>

        <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-5">
            @if (session('success'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('success') }}</div>
            @endif

            <div class="flex items-center justify-end">
                <form method="POST" action="{{ route('admin.pembayaran.history.clear') }}"
                    onsubmit="return confirm('Hapus semua riwayat history admin?')">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-red-50 text-red-600 text-sm hover:bg-red-100">Hapus
                        Riwayat</button>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-4 py-3 text-left">Nama</th>
                                <th class="px-4 py-3 text-left">Email</th>
                                <th class="px-4 py-3 text-left">No WA</th>
                                <th class="px-4 py-3 text-left">Bukti</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($payments as $payment)
                                <tr>
                                    <td class="px-4 py-3">{{ $payment->user->nama ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $payment->email }}</td>
                                    <td class="px-4 py-3">{{ $payment->no_whatsapp }}</td>
                                    <td class="px-4 py-3">
                                        <a href="{{ asset('storage/' . $payment->bukti_pembayaran) }}" target="_blank"
                                            class="text-blue-600 hover:underline">Lihat Foto</a>
                                    </td>
                                    <td class="px-4 py-3 capitalize">{{ $payment->status }}</td>
                                    <td class="px-4 py-3">
                                        <form method="POST"
                                            action="{{ route('admin.pembayaran.history.destroy', $payment->id) }}"
                                            onsubmit="return confirm('Hapus dari history admin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 text-xs hover:bg-red-100">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada history
                                        pembayaran.</td>
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
