<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookDownload extends Model
{
  protected $fillable = [
    'user_id',
    'buku_id',
    'downloaded_at',
  ];

  protected $casts = [
    'downloaded_at' => 'datetime',
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
