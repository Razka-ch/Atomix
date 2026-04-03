<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Category;
use App\Models\Pembayaran;
use App\Models\User;

class DashboardController extends Controller
{
  public function index()
  {
    $monthLabels = collect(range(1, 12))->map(fn($month) => now()->startOfYear()->addMonths($month - 1)->format('M'));

    $usersMonthly = collect(range(1, 12))->map(function ($month) {
      return User::whereYear('created_at', now()->year)
        ->whereMonth('created_at', $month)
        ->count();
    });

    $membersMonthly = collect(range(1, 12))->map(function ($month) {
      return Pembayaran::withTrashed()
        ->where('status', 'lunas')
        ->whereYear('approved_at', now()->year)
        ->whereMonth('approved_at', $month)
        ->count();
    });

    $booksMonthly = collect(range(1, 12))->map(function ($month) {
      return Buku::whereYear('created_at', now()->year)
        ->whereMonth('created_at', $month)
        ->count();
    });

    $categoryLabels = Category::orderBy('name')->pluck('name');
    $categoryData = Category::orderBy('name')->get()->map(function ($category) {
      return Buku::where('kategori', $category->name)->count();
    });

    $approvedPayments = Pembayaran::withTrashed()->where('status', 'lunas');
    $rejectedPayments = Pembayaran::withTrashed()->where('status', 'gagal');

    $moneyProfit = (float) $approvedPayments->sum('nominal');
    $expenseProfit = (float) $rejectedPayments->sum('nominal');
    $memberProfit = (int) User::where('role', 'member')
      ->whereNotNull('membership_ends_at')
      ->whereDate('membership_ends_at', '>=', now()->toDateString())
      ->count();

    $netProfit = $moneyProfit - $expenseProfit;
    $marginProfit = $moneyProfit > 0 ? ($netProfit / $moneyProfit) * 100 : 0;
    $newMember = (int) Pembayaran::withTrashed()
      ->where('status', 'lunas')
      ->whereBetween('approved_at', [now()->startOfMonth(), now()->endOfMonth()])
      ->count();
    $roi = $expenseProfit > 0 ? ($netProfit / $expenseProfit) * 100 : 0;

    return view('admin.dashboard', [
      'lineLabels' => $monthLabels,
      'usersMonthly' => $usersMonthly,
      'membersMonthly' => $membersMonthly,
      'booksMonthly' => $booksMonthly,
      'categoryLabels' => $categoryLabels,
      'categoryData' => $categoryData,
      'moneyProfit' => $moneyProfit,
      'expenseProfit' => $expenseProfit,
      'memberProfit' => $memberProfit,
      'netProfit' => $netProfit,
      'marginProfit' => $marginProfit,
      'newMember' => $newMember,
      'roi' => $roi,
      'totalBooks' => Buku::count(),
      'totalUsers' => User::count(),
      'totalMembers' => $memberProfit,
      'totalContacts' => \App\Models\Contact::count(),

    ]);
  }
}
