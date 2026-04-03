<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Profile - Atomix Books</title>
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-[#f3f4f6] text-slate-800 min-h-screen">

    @php
        $user = Auth::user();
        $avatarUrl = $user->profile_photo ? asset('storage/' . $user->profile_photo) : null;
        $initials = collect(preg_split('/\s+/', trim($user->nama)))
            ->filter()
            ->map(fn($part) => strtoupper(substr($part, 0, 1)))
            ->take(2)
            ->implode('');
    @endphp

    <div class="min-h-screen flex flex-col lg:flex-row">
        <aside class="w-full lg:w-72 bg-white border-r border-slate-200">
            <div class="px-6 py-5 border-b border-slate-200">
                <h1 class="text-2xl font-black tracking-tight">ATOMIX BOOKS</h1>
            </div>

            <nav class="px-3 py-4 space-y-2">
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg bg-slate-100 border-l-4 border-blue-500 text-slate-900 font-semibold">
                    <i class="fa-solid fa-user"></i>
                    <span>My Profile</span>
                </a>

                <a href="{{ route('books') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-100 text-slate-700 font-medium transition">
                    <i class="fa-solid fa-book"></i>
                    <span>Books</span>
                </a>

                <a href="{{ url()->previous() }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-100 text-slate-700 font-medium transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Go Back</span>
                </a>

                <div class="border-t border-slate-200 my-3"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 font-semibold transition">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        <main class="flex-1 p-4 sm:p-6 lg:p-10">
            <div class="max-w-4xl mx-auto">
                <header class="mb-6">
                    <h2 class="text-3xl font-extrabold tracking-tight">Manage Profile</h2>
                    <p class="text-slate-500 mt-1">Update your account settings and preferences</p>
                </header>

                @if (session('success'))
                    <div
                        class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <section class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-8 shadow-sm">
                    <form id="profileForm" action="{{ route('profile.update') }}" method="POST"
                        enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="remove_photo" id="removePhotoInput" value="0">

                        <div class="flex flex-col items-center text-center pb-6 border-b border-slate-200">
                            <div class="relative">
                                @if ($avatarUrl)
                                    <img src="{{ $avatarUrl }}" alt="Profile avatar"
                                        class="w-28 h-28 rounded-full border-4 border-blue-200 object-cover shadow">
                                @else
                                    <div
                                        class="w-28 h-28 rounded-full border-4 border-blue-200 shadow bg-slate-600 text-white flex items-center justify-center text-3xl font-bold">
                                        {{ $initials }}
                                    </div>
                                @endif

                                <button type="button" onclick="triggerPhotoPicker()"
                                    class="absolute bottom-1 right-1 w-9 h-9 rounded-full bg-blue-500 text-white shadow flex items-center justify-center"
                                    aria-label="Edit avatar">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </button>
                            </div>

                            <input type="file" name="profile_photo" id="profilePhotoInput" class="hidden"
                                accept="image/png,image/jpeg,image/jpg,image/webp">

                            <h3 class="mt-4 text-2xl font-bold">{{ $user->nama }}</h3>
                            <p class="text-slate-500 text-sm">Profile Photo</p>
                            <p class="text-slate-400 text-xs">PNG, JPG, WEBP up to 5 MB</p>
                            <p id="selectedPhotoName" class="hidden mt-2 text-xs text-blue-600 font-medium"></p>

                            @if ($avatarUrl)
                                <button type="button" onclick="removeCurrentPhoto()"
                                    class="mt-4 inline-flex items-center gap-2 border border-red-500 text-red-600 font-bold px-5 py-1.5 rounded-lg hover:bg-red-50 transition">
                                    <i class="fa-regular fa-trash-can"></i>
                                    REMOVE
                                </button>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                            <div class="relative">
                                <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required
                                    class="w-full rounded-xl border border-slate-300 py-3 pl-11 pr-4 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                            <div class="relative">
                                <i
                                    class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full rounded-xl border border-slate-300 py-3 pl-11 pr-4 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                            <div class="relative">
                                <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="password" name="password" id="password"
                                    placeholder="Leave blank if you don't want to change"
                                    class="w-full rounded-xl border border-slate-300 py-3 pl-11 pr-12 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <button type="button" onclick="togglePassword()"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"
                                    aria-label="Toggle password visibility">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password</label>
                            <div class="relative">
                                <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="password" name="password_confirmation" placeholder="Repeat new password"
                                    class="w-full rounded-xl border border-slate-300 py-3 pl-11 pr-4 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Membership Status</label>
                            <div
                                class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-yellow-100 text-yellow-500 flex items-center justify-center">
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <div>
                                        @if ($user->role === 'member')
                                            <p class="font-semibold">Member <span
                                                    class="text-xs text-emerald-600 font-medium">Premium Plan</span>
                                            </p>
                                            <p class="text-sm text-slate-500">You have access to premium features.</p>
                                        @else
                                            <p class="font-semibold">Regular <span
                                                    class="text-xs text-slate-500 font-medium">Free Plan</span></p>
                                            <p class="text-sm text-slate-500">Access to basic features.</p>
                                        @endif
                                    </div>
                                </div>

                                @if ($user->role !== 'member')
                                    <a href="{{ route('user.daftar-member') }}"
                                        class="inline-flex items-center justify-center rounded-lg bg-blue-500 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-600 transition">Upgrade</a>
                                @endif
                            </div>
                        </div>

                        <div class="pt-2 flex flex-col sm:flex-row gap-3">
                            <button type="submit"
                                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-xl transition">
                                <i class="fa-solid fa-floppy-disk mr-2"></i>Save Changes
                            </button>
                            <a href="{{ route('home') }}"
                                class="sm:w-40 text-center border border-slate-300 hover:bg-slate-100 text-slate-700 font-semibold py-3 rounded-xl transition">Cancel</a>
                        </div>
                    </form>
                </section>

                <section class="mt-4 rounded-xl border border-blue-100 bg-blue-50 px-5 py-4 text-blue-900">
                    <h4 class="font-semibold text-sm mb-1"><i class="fa-solid fa-circle-info mr-2"></i>Account
                        Security</h4>
                    <p class="text-sm text-blue-700">Your password is encrypted and secure. We recommend updating it
                        every 90 days for better account security.</p>
                </section>
            </div>
        </main>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        }

        function triggerPhotoPicker() {
            document.getElementById('profilePhotoInput').click();
        }

        function removeCurrentPhoto() {
            document.getElementById('removePhotoInput').value = '1';
            document.getElementById('profilePhotoInput').value = '';
            document.getElementById('selectedPhotoName').classList.add('hidden');
            document.getElementById('profileForm').submit();
        }

        const profilePhotoInput = document.getElementById('profilePhotoInput');
        if (profilePhotoInput) {
            profilePhotoInput.addEventListener('change', function() {
                const selectedPhotoName = document.getElementById('selectedPhotoName');
                if (this.files && this.files.length > 0) {
                    document.getElementById('removePhotoInput').value = '0';
                    selectedPhotoName.textContent = 'Selected: ' + this.files[0].name;
                    selectedPhotoName.classList.remove('hidden');
                } else {
                    selectedPhotoName.classList.add('hidden');
                }
            });
        }
    </script>

</body>

</html>
