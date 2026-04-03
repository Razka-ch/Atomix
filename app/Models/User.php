<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\BookFavorite;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // INI YANG PALING PENTING: Kasih tahu Laravel kolom apa saja yang boleh diisi
    protected $fillable = [
        'nama',
        'email',
        'profile_photo',
        'password',
        'role',
        'membership_started_at',
        'membership_ends_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'membership_started_at' => 'date',
            'membership_ends_at' => 'date',
        ];
    }

    // --- Relasi yang sudah kita buat sebelumnya ---

    public function buku_dikelola(): HasMany
    {
        return $this->hasMany(Buku::class, 'admin_id');
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'user_id');
    }

    public function bookRatings(): HasMany
    {
        return $this->hasMany(BookRating::class, 'user_id');
    }

    public function bookFavorites(): HasMany
    {
        return $this->hasMany(BookFavorite::class, 'user_id');
    }

    public function isMembershipActive(): bool
    {
        return $this->role === 'member' && $this->membership_ends_at !== null && now()->lte($this->membership_ends_at);
    }
}
