<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Atomix Books</title>
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="min-h-screen bg-[#c9d1da]">
    <a href="{{ route('landing') }}"
        class="fixed top-4 right-4 z-10 rounded-full border border-slate-400/70 bg-white/80 px-4 py-2 text-xs font-semibold text-slate-700 shadow-sm backdrop-blur hover:bg-white">
        Kembali ke Landing
    </a>
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

        <section
            class="order-2 lg:order-1 bg-[#c9d1da] px-6 sm:px-10 md:px-16 py-10 sm:py-14 flex flex-col justify-center">
            <div class="max-w-md mx-auto w-full">
                <div class="text-center mb-10 sm:mb-12">
                    <i class="fa-solid fa-book-open text-5xl text-[#223754] mb-4"></i>
                    <h1 class="text-4xl font-serif text-[#1c2431] tracking-wide">ATOMIX BOOKS</h1>
                    <p class="mt-2 text-[#5b6572] text-sm">Welcome back to your reading sanctuary</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-300 text-red-700 text-sm rounded-lg px-4 py-3 mb-5">
                        {{ $errors->first('email') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-[#253247] mb-2">
                            <i class="fa-solid fa-envelope mr-1"></i> E-Mail
                        </label>
                        <input type="email" name="email" required placeholder="reader@library.com"
                            value="{{ old('email') }}"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#2f4667] {{ $errors->has('email') ? 'ring-2 ring-red-300' : '' }}">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#253247] mb-2">
                            <i class="fa-solid fa-lock mr-1"></i> Password
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required
                                placeholder="your.email@example.com"
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 pr-11 text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#2f4667]">
                            <button type="button" onclick="togglePassword('password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500"
                                aria-label="Show password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-sm text-slate-600">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember"
                                class="rounded border-slate-300 text-[#2f4667] focus:ring-[#2f4667]">
                            <span>Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="font-medium hover:text-[#1f2e47]">Forgot
                            password?</a>
                    </div>

                    <button type="submit"
                        class="w-full bg-[#243a59] text-white rounded-lg py-3 font-semibold hover:bg-[#1d2f49] transition">
                        Sign In
                    </button>

                    <p class="lg:hidden text-center text-sm text-slate-600 pt-1">
                        Don't have an account?
                        <a href="/register" class="font-semibold text-[#1f2e47] hover:underline">Sign Up</a>
                    </p>
                </form>
            </div>
        </section>

        <section
            class="order-1 lg:order-2 relative overflow-hidden bg-gradient-to-br from-[#7f8fa6] via-[#364b6a] to-[#1a2b46] text-white px-6 sm:px-10 md:px-14 py-12 sm:py-16 flex items-center justify-center">
            <div
                class="absolute inset-0 bg-[radial-gradient(circle_at_30%_25%,rgba(255,255,255,0.25),transparent_42%),radial-gradient(circle_at_80%_75%,rgba(255,255,255,0.14),transparent_40%)]">
            </div>

            <div class="relative z-10 max-w-md text-center">
                <i class="fa-solid fa-book-bookmark text-7xl sm:text-8xl text-white/75 mb-10"></i>
                <h2 class="text-4xl sm:text-5xl font-serif leading-tight">Join Our Literary Community</h2>
                <p class="mt-6 text-base sm:text-2xl text-white/85 leading-relaxed">
                    Discover thousands of books, connect with fellow readers, and embark on endless literary adventures
                </p>

                <div class="mt-10 space-y-3 text-left max-w-sm mx-auto text-white/90 text-sm sm:text-base">
                    <p><i class="fa-solid fa-circle-check mr-2"></i> Access to 50,000+ digital books</p>
                    <p><i class="fa-solid fa-circle-check mr-2"></i> Personalized reading recommendations</p>
                    <p><i class="fa-solid fa-circle-check mr-2"></i> Join exclusive book clubs & discussions</p>
                </div>

                <p class="mt-10 mb-4 text-white/95 text-lg font-medium">Don't have an account?</p>
                <a href="/register"
                    class="inline-flex items-center justify-center w-full max-w-xs bg-white text-[#1d2d45] py-3 rounded-lg font-semibold shadow-lg hover:bg-slate-100 transition">
                    Sign Up
                </a>

                <div class="mt-12 pt-6 border-t border-white/20 text-white/70 text-sm">
                    <p class="italic">"A room without books is like a body without a soul."</p>
                    <p class="text-xs mt-2">- Marcus Tullius Cicero</p>
                </div>
            </div>
        </section>
    </div>

    <script>
        function togglePassword(inputId) {
            const pass = document.getElementById(inputId);
            pass.type = pass.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>

</html>
