<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Library</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 flex flex-col md:flex-row min-h-screen md:h-screen md:overflow-hidden">
    @include('admin.partials.sidebar', ['activeMenu' => 'books'])

    <div class="flex-1 min-w-0 flex flex-col md:ml-64 md:h-screen md:overflow-hidden">

        <div class="hidden md:flex shrink-0 justify-between items-center bg-white p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Book Library</h2>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.books.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition shadow-sm">
                    <i class="fa-solid fa-plus text-xs"></i> Add Book
                </a>
                <div class="h-6 w-px bg-gray-200"></div>
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" alt="User Avatar"
                        class="w-9 h-9 rounded-full object-cover">
                    <span class="text-sm font-medium text-gray-700">Admin <i
                            class="fa-solid fa-chevron-down text-xs ml-1 text-gray-400"></i></span>
                </div>
            </div>
        </div>

        <div class="p-4 md:px-6 md:pt-6">
            @if (session('success'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 mt-3">
                    {{ session('error') }}
                </div>
            @endif

            <form method="GET" action="{{ route('admin.books.index') }}"
                class="mt-4 bg-white border border-gray-200 rounded-xl p-4 flex flex-col md:flex-row gap-3 md:items-center">
                <div class="flex-1 relative">
                    <i
                        class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        placeholder="Search title, author, category..."
                        class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <select name="category"
                    class="w-full md:w-56 px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white">
                    <option value="">All Categories</option>
                    @foreach ($categories as $categoryOption)
                        <option value="{{ $categoryOption->name }}"
                            {{ ($category ?? '') === $categoryOption->name ? 'selected' : '' }}>
                            {{ $categoryOption->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="px-4 py-2.5 rounded-lg bg-slate-800 text-white text-sm font-semibold">Filter</button>
                <a href="{{ route('admin.books.index') }}"
                    class="px-4 py-2.5 rounded-lg border border-gray-200 text-gray-600 text-sm text-center">Reset</a>
            </form>
        </div>

        <div class="relative px-4 md:px-6 pb-8">
            <button id="booksPrev"
                class="hidden md:flex absolute left-0 top-1/2 -translate-y-1/2 w-10 h-10 items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 shadow hover:bg-gray-50">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button id="booksNext"
                class="hidden md:flex absolute right-0 top-1/2 -translate-y-1/2 w-10 h-10 items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 shadow hover:bg-gray-50">
                <i class="fa-solid fa-chevron-right"></i>
            </button>

            <div id="booksScroll" class="max-h-[70vh] overflow-y-auto pr-2">
                <div id="booksGrid"
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">

                    @forelse ($bukus as $buku)
                        <div data-book-card
                            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition duration-300">
                            <div class="h-48 sm:h-56 md:h-48 overflow-hidden bg-gray-100">
                                @if ($buku->cover)
                                    <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover"
                                        class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-image text-3xl"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="p-4 flex-grow flex flex-col justify-between">
                                <div>
                                    <h3 class="font-bold text-gray-800 text-base mb-1 line-clamp-1">
                                        {{ $buku->judul_buku }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mb-3 line-clamp-1">{{ $buku->pengarang }}</p>
                                    <span
                                        class="inline-block text-[11px] font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded">
                                        {{ $buku->kategori }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center mt-4">
                                    <p class="text-xs text-gray-400">Published: {{ $buku->tahun_terbit }}</p>
                                    <span
                                        class="text-[11px] font-semibold {{ $buku->access_type === 'member' ? 'text-purple-600 bg-purple-50' : 'text-emerald-600 bg-emerald-50' }} px-2 py-1 rounded">
                                        {{ $buku->access_type === 'member' ? 'Membership' : 'Gratis' }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-4 pt-0 flex gap-2">
                                <a href="{{ route('admin.books.edit', $buku->id) }}"
                                    class="flex-grow flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 rounded-lg text-sm font-medium transition">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i> Edit
                                </a>

                                <form action="{{ route('admin.books.destroy', $buku->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus buku ini?')" class="contents">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-50 hover:bg-red-100 text-red-500 px-3 py-2 rounded-lg transition">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div
                            class="col-span-full py-20 flex flex-col items-center justify-center bg-white rounded-xl border border-dashed border-gray-300">
                            <i class="fa-solid fa-book-open text-gray-200 text-5xl mb-4"></i>
                            <p class="text-gray-500 font-medium">No books found.</p>
                            <p class="text-sm text-gray-400">Start by adding a new book to the library.</p>
                        </div>
                    @endforelse
                </div>
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

        const cards = Array.from(document.querySelectorAll('[data-book-card]'));
        const pageSize = 5;
        let pageIndex = 0;
        const prevBtn = document.getElementById('booksPrev');
        const nextBtn = document.getElementById('booksNext');

        function renderBooksPage() {
            if (cards.length === 0) return;
            const totalPages = Math.ceil(cards.length / pageSize);
            pageIndex = Math.max(0, Math.min(pageIndex, totalPages - 1));

            cards.forEach((card, index) => {
                const start = pageIndex * pageSize;
                const end = start + pageSize;
                if (index >= start && index < end) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });

            if (prevBtn) prevBtn.disabled = pageIndex === 0;
            if (nextBtn) nextBtn.disabled = pageIndex >= totalPages - 1;
        }

        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', () => {
                pageIndex -= 1;
                renderBooksPage();
            });
            nextBtn.addEventListener('click', () => {
                pageIndex += 1;
                renderBooksPage();
            });
        }

        renderBooksPage();
    </script>

</body>

</html>
