<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register - Atomix Books</title>
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="h-screen overflow-hidden bg-[#c9d1da]">
    <a href="{{ route('landing') }}"
        class="fixed top-4 right-4 z-10 rounded-full border border-slate-400/70 bg-white/80 px-4 py-2 text-xs font-semibold text-slate-700 shadow-sm backdrop-blur hover:bg-white">
        Kembali ke Landing
    </a>
    <div class="h-screen grid grid-cols-1 lg:grid-cols-2">

        <section
            class="bg-[#d0d6dd] px-6 sm:px-10 md:px-16 py-10 sm:py-12 flex flex-col justify-center order-2 lg:order-1 h-full">
            <div class="max-w-md mx-auto w-full">
                <div class="text-center mb-10">
                    <i class="fa-solid fa-book-open text-5xl text-[#223754] mb-4"></i>
                    <h1 class="text-4xl font-serif text-[#1c2431] tracking-wide">ATOMIX BOOKS</h1>
                    <p class="mt-2 text-[#5b6572] text-sm">Welcome back to your reading sanctuary</p>
                </div>

                <h2 class="text-4xl font-serif text-[#1c2431] mb-6">Create Account</h2>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-300 text-red-700 text-sm rounded-lg px-4 py-3 mb-5">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-[#253247] mb-2"><i
                                class="fa-solid fa-user mr-1"></i> Username</label>
                        <input type="text" name="nama" required placeholder="Choose a username"
                            value="{{ old('nama') }}"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#2f4667]">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#253247] mb-2"><i
                                class="fa-solid fa-envelope mr-1"></i> Email Address</label>
                        <input type="email" name="email" required placeholder="your.email@example.com"
                            value="{{ old('email') }}"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#2f4667]">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#253247] mb-2"><i
                                class="fa-solid fa-lock mr-1"></i> Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required
                                placeholder="Create a strong password"
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 pr-11 text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#2f4667]">
                            <button type="button" onclick="togglePassword('password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500"
                                aria-label="Show password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#253247] mb-2"><i
                                class="fa-solid fa-lock mr-1"></i> Confirm Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="confirmPassword" required
                                placeholder="Re-enter your password"
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 pr-11 text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#2f4667]">
                            <button type="button" onclick="togglePassword('confirmPassword')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500"
                                aria-label="Show password confirmation">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full mt-4 bg-[#243a59] text-white rounded-lg py-3 font-semibold hover:bg-[#1d2f49] transition">
                        <i class="fa-solid fa-user-plus mr-2"></i>Create Account
                    </button>

                    <p class="lg:hidden text-center text-sm text-slate-600 pt-1">
                        Already have an account?
                        <a href="/login" class="font-semibold text-[#1f2e47] hover:underline">Sign In</a>
                    </p>
                </form>
            </div>
        </section>

        <section
            class="relative overflow-hidden bg-gradient-to-br from-[#aeb8c4] via-[#566985] to-[#1e3150] text-white px-6 sm:px-10 md:px-14 flex flex-col justify-center items-center order-1 lg:order-2 h-full">
            <div
                class="absolute inset-0 bg-[radial-gradient(circle_at_22%_24%,rgba(255,255,255,0.25),transparent_40%),radial-gradient(circle_at_76%_78%,rgba(255,255,255,0.12),transparent_45%)]">
            </div>

            <div class="relative z-10 max-w-md text-center">
                <i class="fa-solid fa-book-bookmark text-7xl sm:text-8xl text-white/80 mb-10"></i>
                <h2 class="text-4xl sm:text-5xl font-serif leading-tight">Welcome Back to Your Library</h2>
                <p class="mt-6 text-base sm:text-2xl text-white/85 leading-relaxed">
                    Access your personal collection, reading history, and continue your literary journey.
                </p>

                <div class="mt-8 flex flex-wrap justify-center gap-x-6 gap-y-2 text-sm sm:text-base text-white/90">
                    <p><i class="fa-solid fa-circle-check mr-1"></i> 10,000+ Books</p>
                    <p><i class="fa-solid fa-circle-check mr-1"></i> Audio Books</p>
                    <p><i class="fa-solid fa-circle-check mr-1"></i> E-Magazines</p>
                </div>

                <p class="mt-12 mb-4 text-white/95 text-lg font-medium">Already have an account?</p>
                <a href="/login"
                    class="inline-flex items-center justify-center w-full max-w-xs bg-white text-[#1d2d45] py-3 rounded-lg font-semibold shadow-lg hover:bg-slate-100 transition">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i>Sign In
                </a>
            </div>
        </section>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>

</html>