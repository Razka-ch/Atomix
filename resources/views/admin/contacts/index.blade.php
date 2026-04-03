<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact Management - Atomix Books</title>
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-[#f4f7f6] min-h-screen md:h-screen md:overflow-hidden font-sans text-gray-800 flex flex-col md:flex-row">
    @include('admin.partials.sidebar', ['activeMenu' => 'contacts'])

    <div class="flex-1 min-w-0 flex flex-col md:ml-64 md:h-screen md:overflow-hidden">

        <div class="hidden md:flex shrink-0 justify-between items-center bg-white p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Contact Management</h2>
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama ?? 'Admin') }}&background=0D8ABC&color=fff"
                    alt="User Avatar" class="w-9 h-9 rounded-full object-cover">
                <span class="text-sm font-medium text-gray-700">{{ Auth::user()->nama ?? 'Admin' }} <i
                        class="fa-solid fa-chevron-down text-xs ml-1 text-gray-400"></i></span>
            </div>
        </div>

        <div class="md:hidden p-4 pb-0 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Contact Management</h2>
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama ?? 'Admin') }}&background=0D8ABC&color=fff"
                alt="User Avatar" class="w-8 h-8 rounded-full object-cover">
        </div>

        <div class="flex-1 overflow-y-auto">
            <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 relative">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Total Contacts
                            </p>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalContacts }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-green-50 text-green-500 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">New Message</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $newMessages }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-yellow-50 text-yellow-500 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M2.94 6.412A2 2 0 002 8.108V16a2 2 0 002 2h12a2 2 0 002-2V8.108a2 2 0 00-.94-1.696l-6-3.75a2 2 0 00-2.12 0l-6 3.75zm2.615 2.423a1 1 0 10-1.11 1.664l5 3.333a1 1 0 001.11 0l5-3.333a1 1 0 00-1.11-1.664L10 11.798 5.555 8.835z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Message read
                            </p>
                            <p class="text-2xl font-bold text-gray-800">{{ $readMessages }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6 flex flex-col sm:flex-row gap-4 justify-between items-center">

                    <form method="GET" action="{{ route('admin.contacts.index') }}"
                        class="flex w-full flex-col sm:flex-row gap-4 items-center">
                        <div class="relative w-full sm:w-1/2">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search name, email, or subject... (Press Enter)"
                                class="w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        </div>

                        <div class="w-full sm:w-auto flex flex-wrap items-center gap-2">
                            @if (request('search') || (request('status') && request('status') !== 'all'))
                                <a href="{{ route('admin.contacts.index') }}"
                                    class="text-sm text-red-500 hover:underline mr-2">Clear Filter</a>
                            @endif
                            <select name="status" onchange="this.form.submit()"
                                class="w-full sm:w-48 px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white cursor-pointer">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status
                                </option>
                                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                                <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read
                                </option>
                            </select>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('admin.contacts.clear') }}"
                        onsubmit="return confirm('Hapus semua riwayat contact?')">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-red-50 text-red-600 text-sm hover:bg-red-100">
                            Hapus Riwayat
                        </button>
                    </form>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#2a3441] text-white text-sm">
                                    <th class="px-6 py-4 font-medium">Subject</th>
                                    <th class="px-6 py-4 font-medium">Name</th>
                                    <th class="px-6 py-4 font-medium">Email</th>
                                    <th class="px-6 py-4 font-medium">Message</th>
                                    <th class="px-6 py-4 font-medium text-center">Status</th>
                                    <th class="px-6 py-4 font-medium text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100">
                                @forelse ($contacts as $contact)
                                    <tr id="row-{{ $contact->id }}"
                                        class="hover:bg-gray-50 transition {{ $contact->status == 'new' ? 'bg-blue-50/20' : '' }}">
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-gray-800">{{ $contact->subject }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">
                                                {{ $contact->created_at->diffForHumans() }}</p>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-700">{{ $contact->name }}</td>
                                        <td class="px-6 py-4 text-gray-500">{{ $contact->email }}</td>
                                        <td class="px-6 py-4 text-gray-500 truncate max-w-xs">
                                            {{ Str::limit($contact->message, 30) }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span id="badge-{{ $contact->id }}"
                                                class="{{ $contact->status == 'new' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }} px-3 py-1 rounded-full text-xs font-semibold tracking-wide">
                                                {{ ucfirst($contact->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-3">

                                                <button type="button"
                                                    class="text-blue-500 hover:text-blue-700 transition"
                                                    title="View Details" data-id="{{ $contact->id }}"
                                                    data-subject="{{ $contact->subject }}"
                                                    data-name="{{ $contact->name }}"
                                                    data-email="{{ $contact->email }}"
                                                    data-message="{{ $contact->message }}"
                                                    data-date="{{ $contact->created_at->format('d M Y, H:i') }}"
                                                    data-status="{{ $contact->status }}"
                                                    onclick="openContactModal(this)">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg>
                                                </button>

                                                <form action="{{ route('admin.contacts.destroy', $contact->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus pesan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-500 hover:text-red-700 transition"
                                                        title="Delete">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-gray-500 font-medium">
                                            Data
                                            tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 border-t border-gray-100 bg-white">
                        {{ $contacts->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div id="contactModal"
            class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">

                <div class="bg-[#2a3441] px-6 py-4 flex justify-between items-center text-white">
                    <h3 class="font-bold text-lg" id="modalSubject">Subject Placeholder</h3>
                    <button onclick="closeContactModal()" class="text-gray-300 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="px-6 py-6 text-sm text-gray-700 space-y-4">
                    <div class="grid grid-cols-2 gap-4 border-b border-gray-100 pb-4">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase">From (Name)</p>
                            <p class="font-semibold text-gray-800" id="modalName">Name Placeholder</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase">Email Address</p>
                            <p class="font-semibold text-gray-800" id="modalEmail">Email Placeholder</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase mb-1">Date Received</p>
                        <p class="font-semibold text-gray-800" id="modalDate">Date Placeholder</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase mb-2">Full Message</p>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-gray-800 whitespace-pre-wrap leading-relaxed"
                            id="modalMessage">
                            Message Placeholder
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 text-right border-t border-gray-100">
                    <button onclick="closeContactModal()"
                        class="bg-[#3b82f6] hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold transition shadow">
                        OK, Close
                    </button>
                </div>
            </div>
        </div>

    </div>
    <script>
        // ==========================================
        // SCRIPT SIDEBAR (BARU DITAMBAHKAN)
        // ==========================================
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

        // ==========================================
        // SCRIPT AJAX & MODAL LU (TIDAK DIUBAH)
        // ==========================================
        function openContactModal(button) {
            // 1. Ambil data dari atribut tombol
            let id = button.getAttribute('data-id');
            let subject = button.getAttribute('data-subject');
            let name = button.getAttribute('data-name');
            let email = button.getAttribute('data-email');
            let message = button.getAttribute('data-message');
            let date = button.getAttribute('data-date');
            let status = button.getAttribute('data-status');

            // 2. Isi konten Modal
            document.getElementById('modalSubject').innerText = subject;
            document.getElementById('modalName').innerText = name;
            document.getElementById('modalEmail').innerText = email;
            document.getElementById('modalMessage').innerText = message;
            document.getElementById('modalDate').innerText = date;

            // 3. Tampilkan Modal
            document.getElementById('contactModal').classList.remove('hidden');

            // 4. Jika statusnya masih 'new', eksekusi AJAX untuk update ke 'read'
            if (status === 'new') {
                fetch(`/admin/contacts/${id}/read`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Secara diam-diam (tanpa refresh), ubah status tombol agar tidak fetch lagi jika diklik ulang
                            button.setAttribute('data-status', 'read');

                            // Hapus background biru dari baris tabel
                            document.getElementById(`row-${id}`).classList.remove('bg-blue-50/20');

                            // Ubah tampilan Badge dari New ke Read
                            let badge = document.getElementById(`badge-${id}`);
                            badge.className =
                                'bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold tracking-wide';
                            badge.innerText = 'Read';

                            // Opsional: Kurangi angka "New Message" dan tambah "Read Message" di card atas secara otomatis (Visual Only)
                            // (Untuk kesederhanaan, stats card atas akan terupdate sempurna saat halaman direfresh/filter nanti)
                        }
                    })
                    .catch(error => console.error('Error marking as read:', error));
            }
        }

        function closeContactModal() {
            document.getElementById('contactModal').classList.add('hidden');
        }
    </script>

</body>

</html>
