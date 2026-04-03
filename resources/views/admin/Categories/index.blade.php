<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Atomix Books</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 flex flex-col md:flex-row min-h-screen md:h-screen md:overflow-hidden">
    @include('admin.partials.sidebar', ['activeMenu' => 'categories'])

    <div class="flex-1 min-w-0 flex flex-col md:ml-64 md:h-screen md:overflow-hidden">
        <div class="hidden md:flex shrink-0 justify-between items-center bg-white p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Categories</h2>
            <button onclick="openCreateModal()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition shadow-sm">
                <i class="fa-solid fa-plus text-xs"></i> Add Category
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8 space-y-6">
            @if (session('success'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-600">Category Name</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-600">Genre Group</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-600">Slug</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-600 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($categories as $category)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $category->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $category->genre_group }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $category->slug }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <button type="button"
                                                onclick="openEditModal('{{ $category->id }}', '{{ addslashes($category->name) }}', '{{ addslashes($category->genre_group) }}')"
                                                class="px-3 py-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                method="POST" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">
                                        Belum ada kategori. Klik Add Category untuk menambah.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="createModal" class="fixed inset-0 bg-black/40 z-[60] hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-5">Add Category</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Category Name</label>
                    <input type="text" name="name" required
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Genre Group</label>
                    <select name="genre_group"
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        <option value="Fiction">Fiction</option>
                        <option value="Non-Fiction">Non-Fiction</option>
                    </select>
                </div>
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeCreateModal()"
                        class="px-4 py-2 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 bg-black/40 z-[60] hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-5">Edit Category</h3>
            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Category Name</label>
                    <input id="editName" type="text" name="name" required
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Genre Group</label>
                    <select id="editGenre" name="genre_group"
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        <option value="Fiction">Fiction</option>
                        <option value="Non-Fiction">Non-Fiction</option>
                    </select>
                </div>
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Update</button>
                </div>
            </form>
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

        function openCreateModal() {
            const modal = document.getElementById('createModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeCreateModal() {
            const modal = document.getElementById('createModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openEditModal(id, name, genre) {
            const form = document.getElementById('editForm');
            const modal = document.getElementById('editModal');

            form.action = `/admin/categories/${id}`;
            document.getElementById('editName').value = name;
            document.getElementById('editGenre').value = genre;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</body>

</html>
