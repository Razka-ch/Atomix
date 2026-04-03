<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class PembayaranController extends Controller
{
    public function createMembership()
    {
        return view('user.daftar-member');
    }

    public function submitDaftarMember(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'no_whatsapp' => 'required|regex:/^[0-9]{8,15}$/',
            'membership_plan' => 'required|in:month,year',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:10240',
            'notes' => 'nullable|string|max:1000',
            'confirmation' => 'accepted',
            'client_time' => 'nullable|date',
        ], [
            'confirmation.accepted' => 'Silakan centang konfirmasi sebelum mengirim.',
            'no_whatsapp.regex' => 'Nomor WA hanya boleh angka (8-15 digit).',
        ]);

        $proofPath = $request->file('bukti_pembayaran')->store('payment-proofs', 'public');
        $membershipStartAt = !empty($validated['client_time'])
            ? Carbon::parse($validated['client_time'])
            : now();
        [$membershipType, $membershipEndDate, $resolvedNominal] = $this->resolveMembershipByPlan(
            $validated['membership_plan'],
            $membershipStartAt
        );
        $generatedTransactionId = $this->generateUniqueTransactionId();

        Pembayaran::create([
            'user_id' => Auth::id(),
            'email' => $validated['email'],
            'nominal' => $resolvedNominal,
            'no_whatsapp' => $validated['no_whatsapp'],
            'transaction_id' => $generatedTransactionId,
            'bukti_pembayaran' => $proofPath,
            'notes' => $validated['notes'] ?? null,
            'payment_channel' => 'dana/gopay',
            'status' => 'pending',
            'tgl_beli' => $membershipStartAt,
            'membership_type' => $membershipType,
            'membership_starts_at' => $membershipStartAt->toDateString(),
            'membership_ends_at' => $membershipEndDate,
        ]);

        return redirect()->route('user.payments')->with('success', 'Payment details berhasil dikirim ke admin untuk konfirmasi.');
    }

    public function myTransactions()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user && $user->role === 'member' && $user->membership_ends_at && now()->gt($user->membership_ends_at)) {
            $user->update([
                'role' => 'user',
                'membership_started_at' => null,
                'membership_ends_at' => null,
            ]);
            $user->refresh();
        }

        $payments = Pembayaran::where('user_id', Auth::id())
            ->latest()
            ->paginate(8);

        $activeMembershipEndsAt = $user?->membership_ends_at?->toDateString();

        return view('user.transactions', compact('payments', 'activeMembershipEndsAt'));
    }

    public function clearMyTransactions()
    {
        Pembayaran::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Riwayat transaksi kamu berhasil dihapus.');
    }

    public function indexAdmin()
    {
        $search = request('search');
        $status = request('status');

        $query = Pembayaran::with(['user'])
            ->where('admin_payment_hidden', false)
            ->whereNull('deleted_at');

        if (!empty($search)) {
            $query->where(function ($sub) use ($search) {
                $sub->where('transaction_id', 'like', "%{$search}%")
                    ->orWhere('no_whatsapp', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $payments = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pembayaran.index', compact('payments', 'search', 'status'));
    }

    public function approveMembership(Pembayaran $pembayaran)
    {
        DB::transaction(function () use ($pembayaran) {
            $pembayaran->update([
                'status' => 'lunas',
                'approved_at' => now(),
                'rejected_at' => null,
                'reviewed_by' => Auth::id(),
                'rejection_reason' => null,
            ]);

            $user = User::findOrFail($pembayaran->user_id);
            $user->update([
                'role' => 'member',
                'membership_started_at' => $pembayaran->membership_starts_at ?? now()->toDateString(),
                'membership_ends_at' => $pembayaran->membership_ends_at,
            ]);
        });

        return back()->with('success', 'Pembayaran dikonfirmasi. Selamat anda telah menjadi bagian dari kami!');
    }

    public function rejectMembership(Request $request, Pembayaran $pembayaran)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        DB::transaction(function () use ($pembayaran, $validated) {
            $pembayaran->update([
                'status' => 'gagal',
                'rejected_at' => now(),
                'approved_at' => null,
                'reviewed_by' => Auth::id(),
                'rejection_reason' => $validated['rejection_reason'],
            ]);
        });

        return back()->with('error', 'Pembayaran ditolak. User akan melihat alasan penolakan pada riwayat transaksi.');
    }

    public function history()
    {
        $payments = Pembayaran::withTrashed()
            ->with(['user', 'reviewer'])
            ->where('admin_history_hidden', false)
            ->orderByDesc('updated_at')
            ->paginate(12);

        return view('admin.pembayaran.history', compact('payments'));
    }
    public function clearFromHistory(Pembayaran $pembayaran)
    {
        $pembayaran->update(['admin_history_hidden' => true]);
        return back()->with('success', 'History pembayaran disembunyikan dari daftar admin.');
    }
    public function clearHistoryList()
    {
        Pembayaran::withTrashed()->update(['admin_history_hidden' => true]);

        return back()->with('success', 'Daftar history berhasil dikosongkan.');
    }

    public function hideFromPayments(Pembayaran $pembayaran)
    {
        $pembayaran->update(['admin_payment_hidden' => true]);

        return back()->with('success', 'Riwayat pembayaran disembunyikan dari daftar admin.');
    }

    public function clearPaymentsList()
    {
        Pembayaran::query()->update(['admin_payment_hidden' => true]);

        return back()->with('success', 'Daftar pembayaran admin berhasil dikosongkan.');
    }
    private function resolveMembershipByPlan(string $plan, Carbon $startAt): array
    {
        if ($plan === 'year') {
            return ['year', $startAt->copy()->addYear()->toDateString(), 500000];
        }

        return ['month', $startAt->copy()->addMonth()->toDateString(), 100000];
    }

    private function generateUniqueTransactionId(): string
    {
        do {
            $candidate = 'TXN-' . now()->format('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
            $exists = Pembayaran::withTrashed()->where('transaction_id', $candidate)->exists();
        } while ($exists);

        return $candidate;
    }
}
