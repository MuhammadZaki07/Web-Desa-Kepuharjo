<?php

namespace App\Http\Controllers;

use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomLoginController extends Controller
{
    public function index()
    {
        return view('auth.auth');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember-me');


        if (Filament::auth()->attempt($credentials, $remember)) {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                Filament::auth()->logout();
                return back()->withErrors([
                    'email' => 'Akses hanya diperbolehkan untuk admin.',
                ])->withInput();
            }
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }
}
