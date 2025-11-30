<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        return $this->attemptLogin($request, route('admin.dashboard'));
    }

    public function register()
    {
        $this->ensureRegistrationEnabled();

        return view('auth.register');
    }

    public function store(Request $request)
    {
        $this->ensureRegistrationEnabled();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:120', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'terms' => ['accepted'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function adminLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function adminAuthenticate(Request $request)
    {
        return $this->attemptLogin($request, route('admin.dashboard'));
    }

    protected function attemptLogin(Request $request, string $redirectRoute)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginValue = $credentials['login'];
        $password = $credentials['password'];
        $remember = $request->boolean('remember');

        $fieldsToTry = filter_var($loginValue, FILTER_VALIDATE_EMAIL)
            ? ['email']
            : ['username', 'email'];

        foreach ($fieldsToTry as $field) {
            if (Auth::attempt([$field => $loginValue, 'password' => $password], $remember)) {
                $request->session()->regenerate();
                $request->session()->regenerateToken();

                return redirect($redirectRoute);
            }
        }

        throw ValidationException::withMessages([
            'login' => 'Nama pengguna atau kata sandi yang Anda masukkan tidak sesuai.',
        ]);
    }

    public function showChangePassword()
    {
        return view('admin.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        // Verifikasi password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak sesuai.',
            ])->withInput();
        }

        // Update password baru
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.change-password')->with('status', 'Password berhasil diubah.');
    }

    protected function ensureRegistrationEnabled(): void
    {
        if (!config('cms.allow_public_registration')) {
            abort(404);
        }
    }
}

