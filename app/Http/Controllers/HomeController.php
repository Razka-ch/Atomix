<?php

namespace App\Http\Controllers;

use App\Models\Buku;

class HomeController extends Controller
{
  public function index()
  {
    $popularBooks = Buku::withCount('favorites')
      ->withAvg('ratings', 'rating')
      ->orderByDesc('favorites_count')
      ->orderByDesc('ratings_avg_rating')
      ->take(8)
      ->get();

    return view('home', compact('popularBooks'));
  }
}
