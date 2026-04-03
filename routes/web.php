<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;

// ==========================================
// 1. PUBLIC ROUTES (Belum Login)
// ==========================================
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Auth Pages
Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::get('/register', fn() => view('auth.register'))->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// 2. GENERAL AUTH ROUTES (Bisa diakses semua role yang login)
// ==========================================
Route::middleware(['auth', 'membership.active'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/about', fn() => view('about'))->name('about');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Rute Contacts
    Route::get('/contacts', fn() => view('contacts'))->name('contacts');
    Route::post('/contacts', [\App\Http\Controllers\ContactController::class, 'store'])->name('contacts.store');

    // Books & transaksi membership
    Route::get('/books', [BukuController::class, 'catalog'])->name('books');
    Route::get('/books-vip', [BukuController::class, 'vipCatalog'])->name('books.vip');
    Route::get('/books-free', [BukuController::class, 'freeCatalog'])->name('books.free');
    Route::get('/books/{buku}', [BukuController::class, 'show'])->name('books.show');
    Route::get('/books/{buku}/download', [BukuController::class, 'download'])->name('books.download');
    Route::post('/books/{buku}/favorite', [BukuController::class, 'toggleFavorite'])->name('books.favorite');
    Route::get('/my-books/favorites', [BukuController::class, 'favorites'])->name('books.favorites');

    Route::get('/daftar-member', [PembayaranController::class, 'createMembership'])->name('user.daftar-member');
    Route::post('/daftar-member', [PembayaranController::class, 'submitDaftarMember'])->name('user.submit-member');
    Route::get('/transaksi-saya', [PembayaranController::class, 'myTransactions'])->name('user.payments');
    Route::delete('/transaksi-saya/clear', [PembayaranController::class, 'clearMyTransactions'])->name('user.payments.clear');
});


// ==========================================
// 4. MEMBER ROUTES (Hanya untuk yang sudah bayar/membership)
// ==========================================
Route::middleware(['auth', 'membership.active', 'role:member'])->group(function () {
    // Member bisa unduh buku (dibatasi 2/hari)
    Route::post('/books/{buku}/rate', [BukuController::class, 'rate'])->name('member.books.rate');
});


// ==========================================
// 5. ADMIN ROUTES
// ==========================================
Route::middleware(['auth', 'membership.active', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('books', BukuController::class)->except(['show']);

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    Route::get('/members', [MemberController::class, 'index'])->name('members.index');

    Route::get('/contacts', [\App\Http\Controllers\ContactController::class, 'index'])->name('contacts.index');
    Route::patch('/contacts/{contact}/read', [\App\Http\Controllers\ContactController::class, 'markAsRead'])->name('contacts.read');
    Route::delete('/contacts/{contact}', [\App\Http\Controllers\ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('/contacts/clear', [\App\Http\Controllers\ContactController::class, 'clearAll'])->name('contacts.clear');

    // Kelola Pembayaran & Approval Member
    Route::get('/pembayaran', [PembayaranController::class, 'indexAdmin'])->name('pembayaran.index');
    Route::post('/pembayaran/clear', [PembayaranController::class, 'clearPaymentsList'])->name('pembayaran.clear');
    Route::post('/pembayaran/{pembayaran}/hide', [PembayaranController::class, 'hideFromPayments'])->name('pembayaran.hide');
    Route::post('/pembayaran/{pembayaran}/approve', [PembayaranController::class, 'approveMembership'])->name('pembayaran.approve');
    Route::post('/pembayaran/{pembayaran}/reject', [PembayaranController::class, 'rejectMembership'])->name('pembayaran.reject');

    Route::get('/payment-history', [PembayaranController::class, 'history'])->name('pembayaran.history');
    Route::delete('/payment-history/{pembayaran}', [PembayaranController::class, 'clearFromHistory'])->name('pembayaran.history.destroy');
    Route::post('/payment-history-clear', [PembayaranController::class, 'clearHistoryList'])->name('pembayaran.history.clear');
});
