<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>VIP Books - Atomix Books</title>
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="bg-[#f0f2f6] text-slate-800 font-sans">
    <nav class="fixed top-0 left-0 w-full z-50 bg-slate-800/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
            <h1 class="text-white font-bold text-lg sm:text-xl tracking-wide">ATOMIX BOOKS</h1>

            <div class="hidden md:flex items-center space-x-6 text-white text-sm font-medium">
                <a href="{{ route('home') }}" class="hover:text-slate-300 transition">HOME</a>
                <a href="{{ route('about') }}" class="hover:text-slate-300 transition">ABOUT</a>
                <a href="{{ route('books') }}" class="hover:text-slate-300 transition">BOOKS</a>
                <a href="{{ route('contacts') }}" class="hover:text-slate-300 transition">CONTACTS</a>
            </div>

            <div class="hidden md:block">
                @auth
                    @php
                        $user = Auth::user();
                        $avatarUrl = $user->profile_photo ? asset('storage/' . $user->profile_photo) : null;
                        $initials = collect(preg_split('/\s+/', trim($user->nama)))
                            ->filter()
                            ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                            ->take(2)
                            ->implode('');
                    @endphp
                    <div class="relative" id="profileWrapper">
                        <button id="profileBtn" class="flex items-center gap-2 text-white hover:text-slate-300 transition">
                            <span class="text-sm font-medium">{{ $user->nama }}</span>
                            @if ($avatarUrl)
                                <img src="{{ $avatarUrl }}"
                                    class="w-9 h-9 rounded-full object-cover border-2 border-white/40" alt="Profile">
                            @else
                                <span
                                    class="w-9 h-9 rounded-full border-2 border-white/40 bg-slate-600 text-white text-xs font-bold flex items-center justify-center">{{ $initials }}</span>
                            @endif
                        </button>

                        <div id="profileDropdown"
                            class="hidden absolute right-0 top-14 w-72 bg-slate-100 rounded-2xl shadow-2xl z-50 overflow-hidden">
                            <div class="flex flex-col items-center py-6 px-6">
                                @if ($avatarUrl)
                                    <img src="{{ $avatarUrl }}"
                                        class="w-20 h-20 rounded-full object-cover mb-3 border-2 border-slate-200"
                                        alt="Profile">
                                @else
                                    <span
                                        class="w-20 h-20 rounded-full object-cover mb-3 border-2 border-slate-200 bg-slate-600 text-white text-2xl font-bold flex items-center justify-center">{{ $initials }}</span>
                                @endif
                                <p class="font-bold text-slate-800 text-base">{{ $user->nama }}</p>

                                @if ($user->role === 'member')
                                    <p class="text-yellow-500 text-xs font-semibold tracking-wide mt-1">MEMBERSHIP</p>
                                    @if (!empty($user->membership_ends_at))
                                        <p class="text-[11px] text-slate-500 mt-1">
                                            Sisa waktu:
                                            <span class="membershipCountdown"
                                                data-end="{{ $user->membership_ends_at->toDateString() }}T23:59:59">Menghitung...</span>
                                        </p>
                                    @endif
                                @elseif($user->role === 'user')
                                    <p class="text-slate-500 text-xs font-semibold tracking-wide mt-1">USER</p>
                                @else
                                    <p class="text-blue-500 text-xs font-semibold tracking-wide mt-1">ADMIN</p>
                                @endif
                            </div>

                            <div class="border-t border-slate-300">
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center justify-between px-6 py-3 text-slate-700 hover:bg-slate-200 transition text-sm font-semibold border-b border-slate-300">
                                    <span>MANAGE PROFILE</span>
                                    <i class="fa-solid fa-gear text-slate-400"></i>
                                </a>
                                <a href="#" data-favorites-open
                                    class="flex items-center justify-between px-6 py-3 text-slate-700 hover:bg-slate-200 transition text-sm font-semibold border-b border-slate-300">
                                    <span>MY BOOKS</span>
                                    <i class="fa-solid fa-download text-slate-400"></i>
                                </a>
                                @if ($user->role === 'user')
                                    <a href="{{ route('user.daftar-member') }}"
                                        class="flex items-center justify-between px-6 py-3 text-slate-700 hover:bg-slate-200 transition text-sm font-semibold border-b border-slate-300">
                                        <span>MEMBERSHIP</span>
                                        <i class="fa-solid fa-crown text-slate-400"></i>
                                    </a>
                                @endif
                                <a href="{{ route('user.payments') }}"
                                    class="flex items-center justify-between px-6 py-3 text-slate-700 hover:bg-slate-200 transition text-sm font-semibold">
                                    <span>TRANSACTION</span>
                                    <i class="fa-solid fa-receipt text-slate-400"></i>
                                </a>
                            </div>

                            <div class="px-6 py-4">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-red-700 hover:bg-red-800 text-white font-bold py-2 rounded-lg transition duration-300">
                                        LOG OUT
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="/login"
                        class="px-4 py-2 rounded-lg border border-white text-white hover:bg-white hover:text-slate-800 transition">
                        SIGN IN
                    </a>
                @endauth
            </div>

            <button id="menuBtn" class="md:hidden text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <div id="mobileMenu" class="hidden md:hidden bg-slate-800/95 px-6 pb-4 text-white">
            <a href="{{ route('home') }}" class="block py-2 border-b border-slate-600">HOME</a>
            <a href="{{ route('about') }}" class="block py-2 border-b border-slate-600">ABOUT</a>
            <a href="{{ route('books') }}" class="block py-2 border-b border-slate-600">BOOKS</a>
            <a href="{{ route('contacts') }}" class="block py-2 border-b border-slate-600">CONTACTS</a>
            @auth
                <div class="pt-2 border-t border-slate-600 mt-2">
                    <p class="text-slate-300 text-sm py-2">{{ Auth::user()->nama }}</p>
                    <a href="{{ route('profile.edit') }}" class="block py-2 border-b border-slate-600 text-sm">MANAGE
                        PROFILE</a>
                    <a href="#" data-favorites-open class="block py-2 border-b border-slate-600 text-sm">MY BOOKS</a>
                    @if (Auth::user()->role === 'user')
                        <a href="{{ route('user.daftar-member') }}"
                            class="block py-2 border-b border-slate-600 text-sm">MEMBERSHIP</a>
                    @endif
                    <a href="{{ route('user.payments') }}"
                        class="block py-2 border-b border-slate-600 text-sm">TRANSACTION</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left py-2 text-red-400 hover:text-red-300 transition text-sm">
                            LOG OUT
                        </button>
                    </form>
                </div>
            @else
                <a href="/login" class="block py-2 border-t border-slate-600 mt-2">SIGN IN</a>
            @endauth
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 pt-28 pb-10 overflow-hidden">
        <div class="text-center mb-8">
            <h1 data-aos="fade-down" data-aos-duration="1000" class="text-3xl md:text-4xl font-black text-slate-800">Premium Book Collection</h1>
            <p data-aos="fade-up" data-aos-delay="100" class="text-slate-500 mt-2">Discover our VIP books and preview before download.</p>
            <div data-aos="fade-up" data-aos-delay="200" class="mt-4 flex justify-center gap-3">
                <a href="{{ route('books') }}"
                    class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 transition">Kembali ke
                    Books</a>
                @if (!(auth()->check() && auth()->user()?->isMembershipActive()))
                    <a href="{{ route('user.daftar-member') }}"
                        class="px-4 py-2 rounded-lg bg-yellow-400 text-slate-900 font-semibold hover:bg-yellow-300 transition shadow-sm hover:shadow">Upgrade
                        Membership</a>
                @endif
            </div>
            <form data-aos="fade-up" data-aos-delay="300" method="GET" action="{{ route('books.vip') }}"
                class="mt-5 flex flex-nowrap justify-center gap-2 text-xs overflow-x-auto whitespace-nowrap pb-2">
                @foreach ($categories as $categoryItem)
                    <button type="submit" name="category" value="{{ $categoryItem->name }}"
                        class="px-3 py-1 rounded-full border transition shrink-0 {{ ($category ?? '') === $categoryItem->name ? 'bg-slate-800 text-white border-slate-800' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                        {{ $categoryItem->name }}
                    </button>
                @endforeach
                @if (!empty($category))
                    <a href="{{ route('books.vip') }}"
                        class="px-3 py-1 rounded-full border border-slate-300 text-slate-600 hover:bg-slate-50 shrink-0 transition">Reset</a>
                @endif
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse ($vipBukus as $book)
                <button data-aos="fade-up" data-aos-duration="800" data-aos-delay="{{ ($loop->index % 4) * 100 }}" onclick="openBookModal({{ $book->id }})"
                    class="text-left bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-lg transition">
                    <div class="h-60 bg-slate-100 overflow-hidden relative">
                        @if ($book->cover)
                            <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->judul_buku }}"
                                class="w-full h-full object-cover hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400"><i
                                    class="fa-solid fa-book text-4xl"></i></div>
                        @endif
                        <div class="absolute top-2 right-2 bg-purple-600/90 backdrop-blur text-white text-[10px] font-bold px-2 py-1 rounded">VIP</div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold line-clamp-1">{{ $book->judul_buku }}</h3>
                        <p class="text-sm text-slate-500 line-clamp-1">{{ $book->pengarang }}</p>
                        <div class="mt-2 flex items-center justify-between text-sm">
                            <span class="text-amber-500"><i class="fa-solid fa-star"></i>
                                {{ number_format((float) ($book->ratings_avg_rating ?? 0), 1) }}</span>
                            <span class="text-purple-700 font-semibold bg-purple-100 px-2 py-0.5 rounded text-xs">VIP</span>
                        </div>
                    </div>
                </button>
            @empty
                <p data-aos="fade-up" class="text-sm text-slate-500 col-span-full text-center py-10">Belum ada buku VIP.</p>
            @endforelse
        </div>

        <div data-aos="fade-up" class="mt-8">{{ $vipBukus->links() }}</div>
    </main>

    <footer class="bg-slate-800 text-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div data-aos="fade-up" data-aos-duration="800">
                    <h2 class="text-3xl font-extrabold mb-6">ATOMIX BOOKS</h2>
                    <p class="text-slate-300 leading-relaxed">
                        Copyright © {{ date('Y') }} by ATOMIX, Inc. <br>
                        All rights reserved.
                    </p>
                </div>

                <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                    <h3 class="text-xl font-semibold mb-6">Contact us</h3>
                    <p class="text-slate-300 leading-relaxed">
                        82 Babakan Tiga Street,<br>
                        Ciwidey, Ciwidey District,<br>
                        Bandung Regency, West Java 40973, Indonesia
                    </p>
                    <p class="mt-6 text-slate-300">
                        atomix_books@gmail.com
                    </p>
                </div>

                <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <h3 class="text-xl font-semibold mb-6">Account</h3>
                    <ul class="space-y-4 text-slate-300">
                        <li>
                            <a href="/register" class="hover:text-white transition">Create account</a>
                        </li>
                        <li>
                            <a href="/login" class="hover:text-white transition">Sign in</a>
                        </li>
                    </ul>
                </div>

                <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                    <h3 class="text-xl font-semibold mb-6">Social Media</h3>
                    <ul class="space-y-4 text-slate-300">
                        <li>
                            <a href="https://twitter.com/AtomixBooks" target="_blank"
                                class="flex items-center gap-3 hover:text-white transition">
                                <i class="fa-brands fa-twitter text-xl hover:text-sky-400 transition"></i>
                                <span>Atomix Books</span>
                            </a>
                        </li>

                        <li>
                            <a href="https://instagram.com/Atomix_Books" target="_blank"
                                class="flex items-center gap-3 hover:text-white transition">
                                <i class="fa-brands fa-instagram text-xl hover:text-pink-500 transition"></i>
                                <span>Atomix_Books</span>
                            </a>
                        </li>

                        <li>
                            <a href="https://wa.me/6282121540775" target="_blank"
                                class="flex items-center gap-3 hover:text-white transition">
                                <i class="fa-brands fa-whatsapp text-xl hover:text-green-500 transition"></i>
                                <span>62 82121540775</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <div id="favoritesModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-[60] p-4 backdrop-blur-sm">
        <div class="bg-white rounded-3xl max-w-5xl w-full overflow-hidden shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-800">My Favorite Books</h3>
                    <p class="text-sm text-slate-500">Daftar buku favorit kamu.</p>
                </div>
                <button onclick="closeFavorites()" class="text-slate-500 hover:text-slate-800 transition"><i
                        class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            <div class="p-6 max-h-[70vh] overflow-y-auto">
                <div id="favoritesGrid" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                <p id="favoritesEmpty" class="text-sm text-slate-500 text-center py-10 hidden">Belum ada buku favorit.
                </p>
            </div>
        </div>
    </div>

    <div id="bookModal" class="fixed inset-0 bg-black/65 hidden items-center justify-center z-50 p-4 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-3xl max-w-4xl w-full overflow-hidden shadow-2xl border border-slate-200">
            <div class="grid md:grid-cols-2">
                <div class="bg-slate-200/70 h-80 md:h-full relative">
                    <img id="modalCover" src="" alt="cover" class="w-full h-full object-cover hidden">
                    <div id="modalCoverFallback"
                        class="w-full h-full flex items-center justify-center text-slate-400">
                        <i class="fa-solid fa-image text-5xl"></i>
                    </div>
                </div>
                <div class="p-6 md:p-8 max-h-[85vh] overflow-y-auto">
                    <div class="flex items-start justify-between gap-3">
                        <h3 id="modalTitle" class="text-2xl font-black text-slate-800 leading-tight">Judul Buku</h3>
                        <button onclick="closeBookModal()" class="text-slate-500 hover:text-slate-800 transition"><i
                                class="fa-solid fa-xmark text-xl"></i></button>
                    </div>

                    <div class="mt-4 space-y-2 text-sm text-slate-700">
                        <p><span class="font-semibold text-slate-900">Pengarang:</span> <span id="modalAuthor">-</span></p>
                        <p><span class="font-semibold text-slate-900">Tahun Terbit:</span> <span id="modalYear">-</span></p>
                        <p><span class="font-semibold text-slate-900">Kategori:</span> <span id="modalCategory">-</span></p>
                    </div>

                    <div class="mt-4 rounded-xl bg-slate-50 border border-slate-200 p-4 text-sm text-slate-600 leading-relaxed">
                        <p id="modalDescription">-</p>
                    </div>

                    <div class="mt-4 flex items-center gap-3 text-sm">
                        <span class="text-amber-500 font-semibold text-base"><i class="fa-solid fa-star"></i> <span
                                id="modalRatingAvg">0.0</span></span>
                        <span class="text-slate-500">(<span id="modalRatingCount">0</span> rating)</span>
                    </div>

                    <div class="mt-6 space-y-3">
                        <a id="modalDownloadBtn" href="#"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 transition text-white text-sm font-semibold hidden w-full justify-center sm:w-auto">
                            <i class="fa-solid fa-download"></i> Download PDF
                        </a>

                        <button id="modalReadBtn" type="button"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-slate-800 hover:bg-slate-900 transition text-white text-sm font-semibold hidden w-full justify-center sm:w-auto">
                            <i class="fa-solid fa-book-open"></i> Baca Online
                        </button>

                        <button id="modalFavoriteBtn" type="button"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 transition text-sm font-semibold hidden w-full justify-center sm:w-auto">
                            <i class="fa-solid fa-heart text-red-500"></i> <span id="modalFavoriteText">Tambah Favorit</span>
                        </button>

                        <div id="modalLockedWrap" class="hidden bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <button
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-200 text-slate-500 text-sm font-semibold cursor-not-allowed pointer-events-none w-full justify-center sm:w-auto"
                                disabled>
                                <i class="fa-solid fa-lock"></i> Download PDF
                            </button>
                            <p class="text-xs text-slate-500 mt-2"><i class="fa-solid fa-circle-info text-amber-500"></i> Member only. Upgrade untuk membuka akses VIP.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="readModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-[70] p-2 md:p-6 backdrop-blur-sm">
        <div class="bg-white rounded-2xl w-full max-w-5xl overflow-hidden shadow-2xl border border-slate-200 flex flex-col h-full md:h-[90vh]">
            <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100 bg-slate-50">
                <h4 class="font-bold text-slate-800"><i class="fa-solid fa-book-open text-blue-600 mr-2"></i> Baca Online</h4>
                <button onclick="closeReadModal()" class="text-slate-500 hover:text-red-500 transition px-2 py-1 rounded-md hover:bg-red-50"><i
                        class="fa-solid fa-xmark text-lg"></i> Tutup</button>
            </div>
            <iframe id="readFrame" src="" class="w-full flex-1" title="Baca buku"></iframe>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Inisialisasi AOS
        AOS.init({
            once: true,
            offset: 50,
        });

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let activeFavoriteUrl = null;
        let activeReadUrl = null;

        async function openBookModal(id) {
            const response = await fetch(`/books/${id}`);
            const data = await response.json();

            document.getElementById('modalTitle').textContent = data.judul_buku;
            document.getElementById('modalAuthor').textContent = data.pengarang;
            document.getElementById('modalYear').textContent = data.tahun_terbit;
            document.getElementById('modalCategory').textContent = data.kategori;
            document.getElementById('modalDescription').textContent = data.deskripsi_singkat || '-';
            document.getElementById('modalRatingAvg').textContent = data.rating_avg;
            document.getElementById('modalRatingCount').textContent = data.rating_count;

            const cover = document.getElementById('modalCover');
            const fallback = document.getElementById('modalCoverFallback');
            if (data.cover) {
                cover.src = data.cover;
                cover.classList.remove('hidden');
                fallback.classList.add('hidden');
            } else {
                cover.classList.add('hidden');
                fallback.classList.remove('hidden');
            }

            const downloadBtn = document.getElementById('modalDownloadBtn');
            const readBtn = document.getElementById('modalReadBtn');
            const favoriteBtn = document.getElementById('modalFavoriteBtn');
            const favoriteText = document.getElementById('modalFavoriteText');
            const lockWrap = document.getElementById('modalLockedWrap');
            
            if (data.can_download) {
                downloadBtn.href = data.download_url;
                downloadBtn.classList.remove('hidden');
                lockWrap.classList.add('hidden');
            } else {
                downloadBtn.classList.add('hidden');
                if (data.access_type === 'member') {
                    lockWrap.classList.remove('hidden');
                } else {
                    lockWrap.classList.add('hidden');
                }
            }

            if (data.can_read && data.read_url) {
                activeReadUrl = data.read_url;
                readBtn.classList.remove('hidden');
            } else {
                activeReadUrl = null;
                readBtn.classList.add('hidden');
            }

            if (data.can_favorite) {
                activeFavoriteUrl = data.favorite_url;
                favoriteBtn.classList.remove('hidden');
                favoriteText.textContent = data.is_favorite ? 'Hapus Favorit' : 'Tambah Favorit';
                
                const heartIcon = favoriteBtn.querySelector('.fa-heart');
                if(data.is_favorite) {
                    heartIcon.classList.remove('fa-regular');
                    heartIcon.classList.add('fa-solid');
                } else {
                    heartIcon.classList.remove('fa-solid');
                    heartIcon.classList.add('fa-regular');
                }
            } else {
                activeFavoriteUrl = null;
                favoriteBtn.classList.add('hidden');
            }

            const modal = document.getElementById('bookModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modal.classList.remove('opacity-0');
            }, 10);
        }

        document.getElementById('modalReadBtn').addEventListener('click', () => {
            if (!activeReadUrl) return;
            const frame = document.getElementById('readFrame');
            frame.src = activeReadUrl;
            const modal = document.getElementById('readModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        document.getElementById('modalFavoriteBtn').addEventListener('click', async () => {
            if (!activeFavoriteUrl) return;

            const response = await fetch(activeFavoriteUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();
            if (!response.ok) return;

            const favoriteText = document.getElementById('modalFavoriteText');
            const favoriteBtn = document.getElementById('modalFavoriteBtn');
            const heartIcon = favoriteBtn.querySelector('.fa-heart');
            
            favoriteText.textContent = data.is_favorite ? 'Hapus Favorit' : 'Tambah Favorit';
            
            if(data.is_favorite) {
                heartIcon.classList.remove('fa-regular');
                heartIcon.classList.add('fa-solid');
                heartIcon.classList.add('scale-125');
                setTimeout(() => heartIcon.classList.remove('scale-125'), 200);
            } else {
                heartIcon.classList.remove('fa-solid');
                heartIcon.classList.add('fa-regular');
            }
        });

        function closeBookModal() {
            const modal = document.getElementById('bookModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function closeReadModal() {
            const modal = document.getElementById('readModal');
            const frame = document.getElementById('readFrame');
            frame.src = '';
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

    <script>
        const btn = document.getElementById('menuBtn');
        const menu = document.getElementById('mobileMenu');
        if (btn && menu) {
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        }

        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        if (profileBtn) {
            profileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
            });
            document.addEventListener('click', (e) => {
                if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        }

        const favoritesModal = document.getElementById('favoritesModal');
        const favoritesGrid = document.getElementById('favoritesGrid');
        const favoritesEmpty = document.getElementById('favoritesEmpty');

        function closeFavorites() {
            favoritesModal.classList.add('hidden');
            favoritesModal.classList.remove('flex');
        }

        async function openFavorites() {
            favoritesGrid.innerHTML = '';
            favoritesEmpty.classList.add('hidden');

            const response = await fetch('/my-books/favorites');
            const data = await response.json();

            if (!data.data || data.data.length === 0) {
                favoritesEmpty.classList.remove('hidden');
            } else {
                data.data.forEach((book) => {
                    const card = document.createElement('div');
                    card.className =
                        'bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm text-left relative group';

                    const cover = book.cover ?
                        `<img src="${book.cover}" alt="${book.judul_buku}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">` :
                        `<div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100"><i class="fa-solid fa-book text-3xl"></i></div>`;

                    const badge = book.access_type === 'member' ? 
                        '<div class="absolute top-2 right-2 bg-purple-600/90 backdrop-blur text-white text-[9px] font-bold px-1.5 py-0.5 rounded z-10">VIP</div>' : 
                        '<div class="absolute top-2 right-2 bg-emerald-500/90 backdrop-blur text-white text-[9px] font-bold px-1.5 py-0.5 rounded z-10">FREE</div>';

                    card.innerHTML = `
                        ${badge}
                        <div class="h-40 bg-slate-100 overflow-hidden">${cover}</div>
                        <div class="p-3">
                            <p class="font-semibold text-sm line-clamp-1">${book.judul_buku}</p>
                            <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">${book.pengarang}</p>
                            <div class="mt-2 flex items-center justify-between text-xs">
                                <span class="text-amber-500 font-medium"><i class=\"fa-solid fa-star\"></i> ${Number(book.rating).toFixed(1)}</span>
                            </div>
                        </div>
                    `;

                    favoritesGrid.appendChild(card);
                });
            }

            favoritesModal.classList.remove('hidden');
            favoritesModal.classList.add('flex');
        }

        document.querySelectorAll('[data-favorites-open]').forEach((trigger) => {
            trigger.addEventListener('click', (event) => {
                event.preventDefault();
                openFavorites();
            });
        });

        document.querySelectorAll('.membershipCountdown').forEach((node) => {
            const endDate = new Date(node.dataset.end).getTime();

            const renderCountdown = () => {
                const distance = endDate - Date.now();

                if (distance <= 0) {
                    node.textContent = 'Expired';
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                node.textContent = `${days}D-${hours}H-${minutes}M-${seconds}S`;
            };

            renderCountdown();
            setInterval(renderCountdown, 1000);
        });
    </script>
</body>

</html>