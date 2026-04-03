<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book - Atomix Books</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 flex flex-col md:flex-row min-h-screen md:h-screen md:overflow-hidden">
    @include('admin.partials.sidebar', ['activeMenu' => 'books'])

    <div class="flex-1 min-w-0 flex flex-col md:ml-64 md:h-screen md:overflow-hidden">
        <div class="hidden md:flex shrink-0 justify-between items-center bg-white p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Edit Book</h2>
            <a href="{{ route('admin.books.index') }}" class="text-gray-500 hover:text-gray-800 transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Back to Library
            </a>
        </div>

        <div class="flex-1 overflow-y-auto p-4 md:p-6">
            <div class="max-w-3xl mx-auto">
                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 text-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.books.update', $buku->id) }}" method="POST" enctype="multipart/form-data"
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    @csrf
                    @method('PUT')

                    <div class="p-6 md:p-8 space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Book Title</label>
                            <input type="text" name="judul_buku" value="{{ old('judul_buku', $buku->judul_buku) }}"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                                required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Author</label>
                                <input type="text" name="pengarang" value="{{ old('pengarang', $buku->pengarang) }}"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Publisher</label>
                                <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                                    required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Year</label>
                                <input type="number" name="tahun_terbit"
                                    value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                                <select name="kategori"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition bg-white"
                                    required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->name }}"
                                            {{ old('kategori', $buku->kategori) === $category->name ? 'selected' : '' }}>
                                            {{ $category->name }} ({{ $category->genre_group }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Book Access</label>
                                <select name="access_type"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition bg-white"
                                    required>
                                    <option value="free"
                                        {{ old('access_type', $buku->access_type) === 'free' ? 'selected' : '' }}>Buku
                                        Gratis</option>
                                    <option value="member"
                                        {{ old('access_type', $buku->access_type) === 'member' ? 'selected' : '' }}>
                                        Buku Membership</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Update Cover</label>
                                <input type="file" name="cover"
                                    class="w-full px-4 py-2 border border-gray-200 rounded-lg" accept="image/*">
                                @if ($buku->cover)
                                    <p class="text-xs text-gray-500 mt-2">Cover saat ini: {{ $buku->cover }}</p>
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Update PDF</label>
                                <input type="file" name="pdf_file"
                                    class="w-full px-4 py-2 border border-gray-200 rounded-lg" accept="application/pdf">
                                @if ($buku->pdf_file)
                                    <p class="text-xs text-gray-500 mt-2">PDF saat ini: {{ $buku->pdf_file }}</p>
                                @endif
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Singkat</label>
                            <textarea name="deskripsi_singkat" rows="4"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">{{ old('deskripsi_singkat', $buku->deskripsi_singkat) }}</textarea>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-8 py-4 flex items-center justify-end gap-3 border-t">
                        <a href="{{ route('admin.books.index') }}"
                            class="text-sm font-semibold text-gray-600 hover:text-gray-800">Cancel</a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-bold shadow-md transition">
                            Save Changes
                        </button>
                    </div>
                </form>
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
