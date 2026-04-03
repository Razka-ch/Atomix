<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
  public function index(Request $request)
  {
    $now = now();

    User::where('role', 'member')
      ->whereNotNull('membership_ends_at')
      ->whereDate('membership_ends_at', '<', $now->toDateString())
      ->update([
        'role' => 'user',
        'membership_started_at' => null,
        'membership_ends_at' => null,
      ]);

    $search = trim((string) $request->query('search', ''));
    $status = (string) $request->query('status', 'all');
    $view = (string) $request->query('view', 'monthly');

    $membersQuery = User::query()
      ->where('role', 'member')
      ->whereNotNull('membership_ends_at')
      ->whereDate('membership_ends_at', '>=', $now->toDateString())
      ->when($search !== '', function ($query) use ($search) {
        $query->where(function ($subQuery) use ($search) {
          $subQuery->where('nama', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhereHas('pembayarans', function ($paymentQuery) use ($search) {
              $paymentQuery->where('transaction_id', 'like', "%{$search}%");
            });
        });
      })
      ->when($status === 'expiring', function ($query) use ($now) {
        $query->whereBetween('membership_ends_at', [$now->toDateString(), $now->copy()->addDays(7)->toDateString()]);
      })
      ->when($view === 'yearly', function ($query) {
        $query->whereHas('pembayarans', function ($paymentQuery) {
          $paymentQuery->where('status', 'lunas')
            ->whereIn('membership_type', ['year', 'tahunan']);
        });
      })
      ->when($view === 'monthly', function ($query) {
        $query->whereHas('pembayarans', function ($paymentQuery) {
          $paymentQuery->where('status', 'lunas')
            ->whereIn('membership_type', ['month', 'bulanan']);
        });
      })
      ->with(['pembayarans' => function ($query) {
        $query->where('status', 'lunas')->latest();
      }])
      ->latest('membership_ends_at');

    $members = $membersQuery->paginate(8)->withQueryString();

    $members->getCollection()->transform(function ($member) {
      $latestPayment = $member->pembayarans->first();
      $member->latest_transaction_id = $latestPayment?->transaction_id ?? '-';
      $member->latest_membership_type = strtolower((string) ($latestPayment?->membership_type ?? 'month'));
      return $member;
    });

    $activeMembersCount = User::where('role', 'member')
      ->whereDate('membership_ends_at', '>=', $now->toDateString())
      ->count();

    $expiringSoonCount = User::where('role', 'member')
      ->whereBetween('membership_ends_at', [$now->toDateString(), $now->copy()->addDays(7)->toDateString()])
      ->count();

    $expiredCount = Pembayaran::where('status', 'lunas')
      ->whereDate('membership_ends_at', '<', $now->toDateString())
      ->count();

    return view('admin.members.index', [
      'members' => $members,
      'search' => $search,
      'status' => $status,
      'viewType' => $view,
      'totalMembers' => User::whereHas('pembayarans', fn($q) => $q->where('status', 'lunas'))->count(),
      'activeMembersCount' => $activeMembersCount,
      'expiringSoonCount' => $expiringSoonCount,
      'expiredCount' => $expiredCount,
    ]);
  }
}
