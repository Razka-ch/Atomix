<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
  public function index()
  {
    if (Auth::check()) {
      $role = Auth::user()->role;
      if ($role === 'admin') {
        return redirect('/admin/dashboard');
      }
      return redirect('/home');
    }

    $popularBooks = Buku::withCount('ratings')
      ->withAvg('ratings', 'rating')
      ->orderByDesc('ratings_count')
      ->orderByDesc('ratings_avg_rating')
      ->take(3)
      ->get();

    return view('landing.page', compact('popularBooks'));
  }
}
