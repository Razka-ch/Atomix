<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Atomix Books</title>
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-white">

    <section class="relative min-h-screen bg-cover bg-center overflow-hidden"
        style="background-image: url('{{ asset('img/perpustakaan cta.jpg') }}');">

        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>

        <div class="relative z-10 px-4 sm:px-6 md:px-10 pt-6 sm:pt-8">
            <div data-aos="fade-down" data-aos-duration="1000"
                class="flex justify-between items-center 
                        bg-white/10 backdrop-blur-md 
                        border border-white/20
                        px-4 sm:px-6 md:px-8 py-3 sm:py-4 rounded-full shadow-xl">

                <h1 class="text-white text-lg sm:text-xl md:text-2xl font-bold tracking-wide">
                    ATOMIX BOOKS
                </h1>

                <a href="/register"
                    class="border border-white px-4 sm:px-6 py-1.5 sm:py-2 rounded-full 
                          text-sm sm:text-base text-white font-semibold 
                          hover:bg-white hover:text-black 
                          transition duration-300">
                    REGISTER
                </a>
            </div>
        </div>

        <div
            class="relative z-10 flex flex-col items-center justify-center 
                    text-center h-[85vh] px-4 sm:px-6">

            <h2 data-aos="fade-down" data-aos-duration="1000" data-aos-delay="100" class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-semibold mb-3 sm:mb-4 tracking-widest">
                WELCOME TO
            </h2>

            <h1 data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="300" class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-extrabold mb-4 sm:mb-6 leading-tight">
                ATOMIX BOOKS — DIGITAL LIBRARY
            </h1>

            <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500" class="max-w-xs sm:max-w-lg md:max-w-2xl text-xs sm:text-sm md:text-base text-gray-200 mb-6 sm:mb-10">
                READ BOOKS, COMPLETE NOVELS ONLY HERE, LET'S START EXPLORING
                ALL THE POPULAR BOOKS ON OUR PLATFORM
            </p>

            <img data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="700" src="{{ asset('img/fe506d26553eed1882eaa93566815651-removebg-preview.png') }}"
                class="w-48 sm:w-64 md:w-72 lg:w-96 drop-shadow-2xl mb-6 sm:mb-10">

            <a data-aos="fade-up" data-aos-duration="1000" data-aos-delay="900" href="/login"
                class="border border-white px-8 sm:px-10 py-2.5 sm:py-3 rounded-full 
                      text-base sm:text-lg font-semibold 
                      hover:bg-white hover:text-black 
                      transition duration-300 shadow-lg">
                START READ
            </a>
        </div>
    </section>


    <section class="bg-black py-16 sm:py-20 md:py-24 px-4 sm:px-6 md:px-10 overflow-hidden">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-center mb-16 sm:mb-24 md:mb-28">

            <img data-aos="fade-right" data-aos-duration="1000" src="{{ asset('img/about-pic2.jpg') }}" class="rounded-xl shadow-2xl w-full">

            <div data-aos="fade-left" data-aos-duration="1000" class="mt-4 md:mt-0">
                <h2 class="text-2xl sm:text-3xl font-bold mb-4 sm:mb-6">
                    REGULAR COLLECTION
                </h2>

                <p class="text-gray-300 leading-relaxed mb-4 sm:mb-6 text-sm sm:text-base">
                    The Regular Collection provides access to a selection of digital books
                    that can be enjoyed anytime, anywhere. Categories include novels and comics,
                    educational books, self-development books, and general reference books.
                </p>

                <ul class="space-y-2 sm:space-y-3 text-gray-300 text-sm sm:text-base">
                    <li>• Access 24/7</li>
                    <li>• Read Online</li>
                </ul>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-center">

            <div data-aos="fade-right" data-aos-duration="1000" class="order-1">
                <h2 class="text-2xl sm:text-3xl font-bold text-yellow-400 mb-4 sm:mb-6">
                    MEMBERSHIP COLLECTION
                </h2>

                <p class="text-gray-300 leading-relaxed mb-4 sm:mb-6 text-sm sm:text-base">
                    The VIP Collection is the best choice for those who want a limitless reading experience.
                    In addition to all access to the Regular Collection, VIP members also enjoy exclusive books,
                    new releases, and premium content not available to regular users.
                </p>

                <ul class="space-y-2 sm:space-y-3 text-gray-300 text-sm sm:text-base">
                    <li>• Download PDF offline</li>
                    <li>• Access to all VIP Books</li>
                </ul>
            </div>

            <div data-aos="fade-left" data-aos-duration="1000" class="relative order-2 mt-4 md:mt-0">
                <img src="{{ asset('img/about-pic2.jpg') }}"
                    class="rounded-xl shadow-2xl border border-yellow-500/40 w-full">

                <div class="absolute inset-0 bg-yellow-500/20 rounded-xl"></div>

                <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                    <div class="text-3xl sm:text-4xl mb-1 sm:mb-2">👑</div>
                    <h3 class="text-xl sm:text-2xl font-bold text-yellow-400">
                        MEMBERSHIP
                    </h3>
                    <p class="text-xs sm:text-sm tracking-widest">
                        EXCLUSIVE ACCESS
                    </p>
                </div>
            </div>

        </div>

    </section>

    <section class="relative py-20 sm:py-24 md:py-32 bg-cover bg-center overflow-hidden"
        style="background-image: url('{{ asset('img/perpustakaan cta.jpg') }}');">

        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>

        <div class="relative z-10 text-center mb-12 sm:mb-16 md:mb-20 px-4">
            <h2 data-aos="fade-up" data-aos-duration="800" class="text-2xl sm:text-3xl md:text-4xl font-bold tracking-widest">
                OUR POPULAR BOOKS
            </h2>
        </div>

        <div
            class="relative z-10 flex flex-col md:flex-row items-center md:items-end justify-center gap-8 sm:gap-10 md:gap-16 px-4 sm:px-6">
            @forelse ($popularBooks as $book)
                @php
                    $rank = $loop->iteration;
                    $isTop = $rank === 1;
                    $cardClasses = $isTop
                        ? 'order-1 md:order-2 p-6 sm:p-8 w-64 sm:w-72 shadow-2xl md:scale-110'
                        : ($rank === 2
                            ? 'order-2 md:order-1 p-5 sm:p-6 w-56 sm:w-64 shadow-xl'
                            : 'order-3 p-5 sm:p-6 w-56 sm:w-64 shadow-xl');
                    $badgeClasses = $isTop
                        ? 'bg-yellow-400 text-black w-10 h-10 md:w-12 md:h-12 text-base md:text-lg'
                        : ($rank === 2
                            ? 'bg-gray-400 text-white w-9 h-9 sm:w-10 sm:h-10 text-sm sm:text-base'
                            : 'bg-red-500 text-white w-9 h-9 sm:w-10 sm:h-10 text-sm sm:text-base');
                @endphp
                <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="{{ $rank * 200 }}"
                    class="relative bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl text-center min-h-[360px] {{ $cardClasses }}">
                    <div
                        class="absolute -top-5 md:-top-6 left-1/2 -translate-x-1/2 font-bold flex items-center justify-center rounded-full shadow-lg {{ $badgeClasses }}">
                        {{ $rank }}
                    </div>

                    @if (!empty($book->cover))
                        <img src="{{ asset('storage/' . $book->cover) }}" class="rounded-xl mb-4 shadow-lg w-full"
                            alt="{{ $book->judul_buku }}">
                    @else
                        <div
                            class="rounded-xl mb-4 shadow-lg w-full h-40 sm:h-44 bg-white/10 flex items-center justify-center text-white/70">
                            <i class="fa-solid fa-book text-3xl"></i>
                        </div>
                    @endif

                    <h3 class="text-lg sm:text-xl font-semibold {{ $isTop ? 'sm:text-2xl' : '' }}">
                        {{ $book->judul_buku }}
                    </h3>
                    <p class="text-gray-300 text-xs sm:text-sm mb-4 {{ $isTop ? 'sm:mb-6' : '' }}">
                        {{ $book->kategori ?? 'General' }}
                    </p>

                    <a href="/login"
                        class="inline-flex items-center justify-center border border-yellow-400 text-yellow-400 px-5 sm:px-6 py-1.5 sm:py-2 rounded-full text-sm sm:text-base hover:bg-yellow-400 hover:text-black transition duration-300">
                        READ
                    </a>
                </div>
            @empty
                <div data-aos="fade-up" class="text-slate-200 text-sm">Belum ada buku populer.</div>
            @endforelse
        </div>

        <div data-aos="zoom-in" data-aos-duration="800" data-aos-delay="400" class="relative z-10 mt-12 flex justify-center px-4">
            <a href="/register"
                class="inline-flex items-center justify-center px-8 py-3 rounded-full bg-yellow-400 text-black font-semibold hover:bg-yellow-300 transition duration-300">
                Create Account
            </a>
        </div>
    </section>

    <footer class="bg-black text-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 sm:gap-10 md:gap-12">

                <div data-aos="fade-up" data-aos-duration="800">
                    <h2 class="text-2xl sm:text-3xl font-extrabold mb-4 sm:mb-6">ATOMIX BOOKS</h2>
                    <p class="text-slate-300 leading-relaxed text-sm sm:text-base">
                        Copyright © {{ date('Y') }} by ATOMIX, Inc. <br>
                        All rights reserved.
                    </p>
                </div>

                <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                    <h3 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6">Contact us</h3>
                    <p class="text-slate-300 leading-relaxed text-sm sm:text-base">
                        82 Babakan Tiga Street,<br>
                        Ciwidey, Ciwidey District,<br>
                        Bandung Regency, West Java 40973, Indonesia
                    </p>
                    <p class="mt-4 sm:mt-6 text-slate-300 text-sm sm:text-base">
                        atomix_books@gmail.com
                    </p>
                </div>

                <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <h3 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6">Account</h3>
                    <ul class="space-y-3 sm:space-y-4 text-slate-300 text-sm sm:text-base">
                        <li>
                            <a href="/register" class="hover:text-white transition">Create account</a>
                        </li>
                        <li>
                            <a href="/login" class="hover:text-white transition">Sign in</a>
                        </li>
                    </ul>
                </div>

                <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                    <h3 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6">Social Media</h3>
                    <ul class="space-y-3 sm:space-y-4 text-slate-300 text-sm sm:text-base">

                        <li>
                            <a href="https://twitter.com/AtomixBooks" target="_blank"
                                class="flex items-center gap-3 hover:text-white transition">
                                <i class="fa-brands fa-twitter text-lg sm:text-xl hover:text-sky-400 transition"></i>
                                <span>Atomix Books</span>
                            </a>
                        </li>

                        <li>
                            <a href="https://instagram.com/Atomix_Books" target="_blank"
                                class="flex items-center gap-3 hover:text-white transition">
                                <i class="fa-brands fa-instagram text-lg sm:text-xl hover:text-pink-500 transition"></i>
                                <span>Atomix_Books</span>
                            </a>
                        </li>

                        <li>
                            <a href="https://wa.me/6282121540775" target="_blank"
                                class="flex items-center gap-3 hover:text-white transition">
                                <i class="fa-brands fa-whatsapp text-lg sm:text-xl hover:text-green-500 transition"></i>
                                <span>62 82121540775</span>
                            </a>
                        </li>

                    </ul>
                </div>

            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi AOS
        AOS.init({
            once: true,
            offset: 50,
        });
    </script>
</body>

</html>