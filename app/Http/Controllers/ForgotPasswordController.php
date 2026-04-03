<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ForgotPasswordController extends Controller
{
  public function create()
  {
    return view('Auth.forgot-password');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'email' => 'required|email|exists:users,email',
      'password' => 'required|min:8|confirmed',
    ]);

    $user = User::where('email', $validated['email'])->first();
    $user->update([
      'password' => Hash::make($validated['password']),
    ]);

    return redirect()->route('login')->with('status', 'Password berhasil diganti. Silakan login kembali.');
  }
}
