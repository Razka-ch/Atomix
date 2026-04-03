<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'buku_id',
        'email',
        'bukti_pembayaran',
        'transaction_id',
        'payment_channel',
        'notes',
        'nominal',
        'status',
        'no_whatsapp',
        'tgl_beli',
        'approved_at',
        'rejected_at',
        'reviewed_by',
        'rejection_reason',
        'admin_history_hidden',
        'membership_type',
        'membership_starts_at',
        'membership_ends_at',
    ];

    protected $casts = [
        'tgl_beli' => 'datetime',
        'admin_history_hidden',
        'admin_payment_hidden',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'membership_starts_at' => 'date',
        'membership_ends_at' => 'date',
    ];

    // Pembayaran ini milik siapa
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Pembayaran ini untuk buku apa (bisa null jika untuk daftar member)
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
