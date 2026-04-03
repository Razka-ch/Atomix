<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\BookFavorite;

class Buku extends Model
{
    protected $fillable = [
        'judul_buku',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'kategori',
        'access_type',
        'stok',
        'cover',
        'pdf_file',
        'deskripsi_singkat',
        'admin_id'
    ];

    // Relasi Buku ini dikelola oleh siapa (Admin)
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Relasi Buku ke Pembayaran (1 Buku bisa dibeli/disewa berkali-kali)
    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'buku_id');
    }

    public function downloads(): HasMany
    {
        return $this->hasMany(BookDownload::class, 'buku_id');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(BookRating::class, 'buku_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(BookFavorite::class, 'buku_id');
    }
}
