    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>About - Atomix Books</title>
        @vite('resources/css/app.css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body class="font-sans">

        <!-- Navbar -->
        <nav class="fixed top-0 left-0 w-full z-50 bg-slate-800/80 backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">

                <h1 class="text-white font-bold text-lg sm:text-xl tracking-wide">
                    ATOMIX BOOKS
                </h1>

                <div class="hidden md:flex items-center space-x-6 text-white text-sm font-medium">
                    <a href="/" class="hover:text-slate-300 transition">HOME</a>
                    <a href="/about" class="hover:text-slate-300 transition">ABOUT</a>
                    <a href="/books" class="hover:text-slate-300 transition">BOOKS</a>
                    <a href="/contacts" class="hover:text-slate-300 transition">CONTACTS</a>
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
                <a href="/" class="block py-2 border-b border-slate-600">HOME</a>
                <a href="/about" class="block py-2 border-b border-slate-600">ABOUT</a>
                <a href="/books" class="block py-2 border-b border-slate-600">BOOKS</a>
                <a href="/contacts" class="block py-2 border-b border-slate-600">CONTACTS</a>
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
                            <button type="submit" class="text-red-400 hover:text-red-300 text-sm py-2">LOG OUT</button>
                        </form>
                    </div>
                @else
                    <a href="/login" class="block py-2 border-t border-slate-600 mt-2">SIGN IN</a>
                @endauth
            </div>
        </nav>

        <!-- Hero -->
        <section class="relative min-h-screen flex items-center justify-center text-center pt-24">
            <!-- Background -->
            <div class="absolute inset-0">
                <img src="{{ asset('img/abouthero.jpg') }}" class="w-full h-full object-cover" alt="">
                <div class="absolute inset-0 bg-black/60"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 max-w-4xl px-4 sm:px-6">

                <h2 class="text-white text-xl sm:text-3xl md:text-4xl font-semibold tracking-wide mb-2">
                    ABOUT US
                </h2>

                <h1
                    class="text-slate-200 text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-widest mb-36">
                    ATOMIX BOOKS
                </h1>


            </div>
        </section>

        <!-- About Gallery -->
        <section class="bg-slate-200 py-20">
            <div class="max-w-7xl mx-auto px-6 text-center">

                <h2 class="text-2xl md:text-3xl font-bold tracking-wide mb-14">
                    ABOUT US
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 place-items-center">
                    <img src="{{ asset('img/about-pic1.jpg') }}" class="w-72 h-72 object-cover rounded-2xl shadow-lg">

                    <img src="{{ asset('img/about-pic2.jpg') }}" class="w-72 h-72 object-cover rounded-2xl shadow-xl">

                    <img src="{{ asset('img/about-pic3.jpg') }}" class="w-72 h-72 object-cover rounded-2xl shadow-lg">
                </div>

            </div>
        </section>

        <!-- About Description -->
        <section class="bg-slate-200 pb-24">
            <div class="max-w-6xl mx-auto px-6">

                <div class="bg-white   rounded-2xl shadow-lg p-10 md:p-14 text-center">

                    <h3 class="text-xl md:text-2xl font-bold mb-6 tracking-wide">
                        ATOMIX BOOKS
                    </h3>

                    <p class="text-sm md:text-base text-gray-700 leading-relaxed space-y-4 max-w-4xl mx-auto">
                        Atomix Books is a digital library website designed to provide easy, fast, and
                        efficient online access to books and reading resources. This platform offers
                        a modern solution for literacy needs in the digital age, where information
                        can be accessed anytime, anywhere.
                        <br><br>
                        Atomix Books offers a diverse collection of digital books for study, research,
                        and general reading. This website is suitable for students, educators, and the
                        general public who want to broaden their horizons and develop their interest
                        in reading independently.
                        <br><br>
                        Melalui Atomix Books Digital Library Website, perpustakaan tidak lagi dibatasi
                        oleh ruang dan waktu. Platform ini menjadi jembatan antara pengetahuan dan
                        teknologi, serta berperan dalam mendukung perkembangan literasi digital secara
                        berkelanjutan.
                    </p>

                </div>

            </div>
        </section>

        <!-- Vision & Mission -->
        <section class="bg-white py-24">
            <div class="max-w-7xl mx-auto px-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

                    <!-- Vision -->
                    <div class="bg-slate-200 rounded-2xl shadow-lg p-10 md:p-12 text-center">
                        <h3 class="text-2xl font-bold mb-6 tracking-wide">
                            VISION
                        </h3>

                        <p class="text-sm md:text-base text-gray-700 leading-relaxed">
                            To become a modern, innovative, and trusted digital library website that
                            provides technology-based literacy access, and plays an active role in
                            increasing reading interest, the quality of learning, and the equitable
                            distribution of knowledge for society in the digital era. Atomix Books aims
                            to be a platform that can bridge the need for information with ease of access,
                            so that reading and learning activities can be carried out flexibly,
                            efficiently, and sustainably without the limitations of space and time.
                        </p>
                    </div>

                    <!-- Mission -->
                    <div class="bg-slate-200 rounded-2xl shadow-lg p-10 md:p-12 text-center">
                        <h3 class="text-2xl font-bold mb-6 tracking-wide">
                            MISSION
                        </h3>

                        <ul class="text-sm md:text-base text-gray-700 leading-relaxed space-y-4 list-disc list-inside">
                            <li>
                                To provide a stable, secure, and user-friendly digital library platform
                                accessible to all users.
                            </li>
                            <li>
                                To offer a diverse and high-quality collection of digital books that
                                support learning, research, and general reading.
                            </li>
                            <li>
                                To enable easy and flexible access to knowledge anytime and anywhere
                                through digital technology.
                            </li>
                            <li>
                                Promote reading culture and digital literacy in the modern era.
                            </li>
                            <li>
                                Continuously develop and improve digital library features to meet users’
                                needs.
                            </li>
                        </ul>
                    </div>

                </div>

            </div>
        </section>


        <footer class="bg-slate-800 text-white">
            <div class="max-w-7xl mx-auto px-6 py-16">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">

                    <!-- Brand -->
                    <div>
                        <h2 class="text-3xl font-extrabold mb-6">ATOMIX BOOKS</h2>
                        <p class="text-slate-300 leading-relaxed">
                            Copyright © {{ date('Y') }} by ATOMIX, Inc. <br>
                            All rights reserved.
                        </p>
                    </div>

                    <!-- Contact -->
                    <div>
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

                    <!-- Account -->
                    <div>
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

                    <!-- Social Media -->
                    <div>
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


        <div id="favoritesModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-[60] p-4">
            <div class="bg-white rounded-3xl max-w-5xl w-full overflow-hidden shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-800">My Favorite Books</h3>
                        <p class="text-sm text-slate-500">Daftar buku favorit kamu.</p>
                    </div>
                    <button onclick="closeFavorites()" class="text-slate-500 hover:text-slate-800"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="p-6">
                    <div id="favoritesGrid" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                    <p id="favoritesEmpty" class="text-sm text-slate-500 text-center py-10 hidden">Belum ada buku favorit.
                    </p>
                </div>
            </div>
        </div>

        <!-- Mobile menu JS -->
        <script>
            // Mobile menu
            const btn = document.getElementById('menuBtn');
            const menu = document.getElementById('mobileMenu');
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });

            // Profile dropdown
            const profileBtn = document.getElementById('profileBtn');
            const profileDropdown = document.getElementById('profileDropdown');

            if (profileBtn) {
                profileBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    profileDropdown.classList.toggle('hidden');
                });

                // Klik di luar = tutup dropdown
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
                            'bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm text-left';

                        const cover = book.cover ?
                            `<img src="${book.cover}" alt="${book.judul_buku}" class="w-full h-full object-cover">` :
                            `<div class="w-full h-full flex items-center justify-center text-slate-400"><i class="fa-solid fa-book text-3xl"></i></div>`;

                        card.innerHTML = `
                            <div class="h-40 bg-slate-100">${cover}</div>
                            <div class="p-3">
                                <p class="font-semibold text-sm line-clamp-1">${book.judul_buku}</p>
                                <p class="text-xs text-slate-500 line-clamp-1">${book.pengarang}</p>
                                <div class="mt-2 flex items-center justify-between text-xs">
                                    <span class="text-amber-500"><i class=\"fa-solid fa-star\"></i> ${book.rating}</span>
                                    <span class="px-2 py-0.5 rounded ${book.access_type === 'member' ? 'bg-purple-100 text-purple-700' : 'bg-emerald-100 text-emerald-700'}">${book.access_type === 'member' ? 'VIP' : 'FREE'}</span>
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
