<div class="md:hidden flex items-center justify-between bg-white border-b px-4 py-3 sticky top-0 z-50 shadow-sm">
    <h1 class="text-lg font-bold text-gray-800 tracking-wide">ATOMIX BOOKS</h1>
    <button id="menuToggle" class="text-gray-600 focus:outline-none">
        <i class="fa-solid fa-bars text-xl"></i>
    </button>
</div>

<div id="sidebar"
    class="fixed md:fixed z-40 top-0 left-0 h-full md:h-screen w-64 bg-white border-r border-gray-200 min-h-screen flex flex-col
            transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">

    <div class="flex items-center justify-between p-6 border-b md:border-none border-gray-100">
        <h1 class="text-xl font-extrabold text-gray-800 tracking-wide">ATOMIX BOOKS</h1>
        <button id="menuClose" class="md:hidden text-gray-500 focus:outline-none">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    @php
        $activeMenu = $activeMenu ?? '';
    @endphp

    <ul class="flex-1 mt-4 flex flex-col gap-1">
        <li>
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ $activeMenu === 'dashboard' ? 'bg-blue-50 border-blue-600 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50 border-transparent' }}">
                <i class="fa-solid fa-chart-line w-5 text-center"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.categories.index') }}"
                class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ $activeMenu === 'categories' ? 'bg-blue-50 border-blue-600 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50 border-transparent' }}">
                <i class="fa-solid fa-list w-5 text-center"></i>
                Categories
            </a>
        </li>
        <li>
            <a href="{{ route('admin.books.index') }}"
                class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ $activeMenu === 'books' ? 'bg-blue-50 border-blue-600 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50 border-transparent' }}">
                <i class="fa-solid fa-book w-5 text-center"></i>
                Books
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users.index') }}"
                class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ $activeMenu === 'users' ? 'bg-blue-50 border-blue-600 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50 border-transparent' }}">
                <i class="fa-solid fa-user w-5 text-center"></i>
                Users
            </a>
        </li>
        <li>
            <a href="{{ route('admin.members.index') }}"
                class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ $activeMenu === 'members' ? 'bg-blue-50 border-blue-600 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50 border-transparent' }}">
                <i class="fa-solid fa-users w-5 text-center"></i>
                Members
            </a>
        </li>
        <li>
            <a href="{{ route('admin.contacts.index') }}"
                class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ $activeMenu === 'contacts' ? 'bg-blue-50 border-blue-600 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50 border-transparent' }}">
                <i class="fa-solid fa-address-book w-5 text-center"></i>
                Contacts
            </a>
        </li>
        <li>
            <a href="{{ route('admin.pembayaran.index') }}"
                class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ $activeMenu === 'payments' ? 'bg-blue-50 border-blue-600 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50 border-transparent' }}">
                <i class="fa-solid fa-credit-card w-5 text-center"></i>
                Payments
            </a>
        </li>
        <li>
            <a href="{{ route('admin.pembayaran.history') }}"
                class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ $activeMenu === 'history' ? 'bg-blue-50 border-blue-600 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50 border-transparent' }}">
                <i class="fa-solid fa-clock-rotate-left w-5 text-center"></i>
                History
            </a>
        </li>
    </ul>

    <div class="p-6">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 bg-red-50 text-red-600 px-4 py-2.5 rounded-lg font-semibold hover:bg-red-100 transition">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>
</div>

<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden" onclick="closeSidebar()"></div>
