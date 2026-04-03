<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookFavorite extends Model
{
  protected $fillable = [
    'user_id',
    'buku_id',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function buku(): BelongsTo
  {
    return $this->belongsTo(Buku::class, 'buku_id');
  }
}
