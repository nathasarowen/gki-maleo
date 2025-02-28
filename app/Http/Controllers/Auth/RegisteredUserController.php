<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input sesuai dengan struktur tabel user di database
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:user,username'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        // Simpan data pengguna ke dalam database dengan password yang di-hash
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'is_admin' => 0,  // Default sebagai user biasa
        ]);

        // Event untuk menandakan bahwa user telah terdaftar
        event(new Registered($user));        

        // Redirect ke halaman login setelah berhasil register
        return redirect()->route('login')->with('status', 'Registration successful. Please log in.');
    }
}
