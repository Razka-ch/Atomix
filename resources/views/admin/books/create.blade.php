<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book - Atomix Books</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 flex flex-col md:flex-row min-h-screen md:h-screen md:overflow-hidden">

    @include('admin.partials.sidebar', ['activeMenu' => 'books'])

    <div class="flex-1 min-w-0 flex flex-col md:ml-64 md:h-screen md:overflow-hidden">

        <div class="hidden md:flex shrink-0 justify-between items-center bg-white p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Add New Book</h2>
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

                <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data"
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    @csrf

                    <div class="p-6 md:p-8 space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Book Title</label>
                            <input type="text" name="judul_buku" value="{{ old('judul_buku') }}"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                                placeholder="e.g. The Great Gatsby" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Author</label>
                                <input type="text" name="pengarang" value="{{ old('pengarang') }}"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Publisher</label>
                                <input type="text" name="penerbit" value="{{ old('penerbit') }}"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                                    required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Year</label>
                                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                                <select name="kategori"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition bg-white"
                                    required>
                                    <option value="">Pilih kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->name }}"
                                            {{ old('kategori') === $category->name ? 'selected' : '' }}>
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
                                    <option value="">Pilih akses</option>
                                    <option value="free" {{ old('access_type') === 'free' ? 'selected' : '' }}>Buku
                                        Gratis</option>
                                    <option value="member" {{ old('access_type') === 'member' ? 'selected' : '' }}>
                                        Buku Membership</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Book Cover</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition cursor-pointer relative">
                                <div class="space-y-1 text-center">
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <span class="text-blue-600 font-medium mr-1">Upload a file</span>
                                        <span>or drag and drop</span>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 2MB</p>
                                </div>
                                <input type="file" name="cover"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Book PDF</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition cursor-pointer relative">
                                <div class="space-y-1 text-center">
                                    <i class="fa-solid fa-file-pdf text-3xl text-gray-400 mb-2"></i>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <span class="text-blue-600 font-medium mr-1">Upload PDF</span>
                                        <span>(optional)</span>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF up to 10MB</p>
                                </div>
                                <input type="file" name="pdf_file" accept="application/pdf"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Singkat</label>
                            <textarea name="deskripsi_singkat" rows="4" placeholder="Ringkasan singkat buku untuk popup"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">{{ old('deskripsi_singkat') }}</textarea>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-8 py-4 flex items-center justify-end gap-3 border-t">
                        <a href="{{ route('admin.books.index') }}"
                            class="text-sm font-semibold text-gray-600 hover:text-gray-800">Cancel</a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-bold shadow-md transition">
                            Save Book
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
