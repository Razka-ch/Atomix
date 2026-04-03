<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureMembershipActive
{
  public function handle(Request $request, Closure $next): Response
  {
    if (Auth::check()) {
      /** @var \App\Models\User $user */
      $user = Auth::user();

      if ($user->role === 'member' && $user->membership_ends_at && now()->gt($user->membership_ends_at)) {
        $user->update([
          'role' => 'user',
          'membership_started_at' => null,
          'membership_ends_at' => null,
        ]);
      }
    }
// RAZKA MEMEK
    return $next($request);
  }
}
