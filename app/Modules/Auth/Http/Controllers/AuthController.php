<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Models\User;
use App\Modules\Auth\Events\UserTerdaftar;
use App\Modules\Auth\Http\Requests\LoginRequest;
use App\Modules\Auth\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Satu controller melayani dua jalur:
 *  - Web  : login berbasis session (guard sanctum memakai session untuk request web)
 *  - API  : login berbasis token Sanctum (Bearer) pada route /api/*
 */
class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth::login');
    }

    public function showRegister()
    {
        return view('auth::register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => User::ROLE_PESERTA,
        ]);

        // Komunikasi lintas modul lewat Domain Event
        event(new UserTerdaftar($user->id, $user->name, $request->kampus));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Registrasi berhasil.',
                'user' => $this->payload($user),
                'token' => $user->createToken('api')->plainTextToken,
            ], 201);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('katalog.index')->with('success', 'Registrasi berhasil. Selamat datang, '.$user->name.'!');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if ($request->expectsJson()) {
            $user = User::where('email', $credentials['email'])->first();

            if (! $user || ! Hash::check($credentials['password'], $user->password)) {
                throw ValidationException::withMessages(['email' => 'Email atau password salah.']);
            }

            return response()->json([
                'message' => 'Login berhasil.',
                'user' => $this->payload($user),
                'token' => $user->createToken('api')->plainTextToken,
            ]);
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages(['email' => 'Email atau password salah.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('katalog.index'))->with('success', 'Berhasil masuk.');
    }

    public function logout(Request $request)
    {
        if ($request->expectsJson()) {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Logout berhasil.']);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda sudah keluar.');
    }

    public function me(Request $request)
    {
        return response()->json($this->payload($request->user()));
    }

    private function payload(User $user): array
    {
        return ['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'role' => $user->role];
    }
}
