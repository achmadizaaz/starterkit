<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\User;
use App\Services\AdminNotifier;
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
    public function create(): View|RedirectResponse
    {
        if (! AppSetting::isPublicRegistrationOpen()) {
            return redirect()->route('login')->withErrors([
                'register' => 'Registrasi publik sedang ditutup.',
            ]);
        }

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        if (! AppSetting::isPublicRegistrationOpen()) {
            return redirect()->route('login')->withErrors([
                'register' => 'Registrasi publik sedang ditutup.',
            ]);
        }

        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9._-]+$/', 'unique:'.User::class],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ],
            [
                'username.regex' => 'Username tidak boleh menggunakan spasi dan hanya boleh berisi huruf, angka, titik, garis bawah, atau tanda minus.',
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        AdminNotifier::notify(
            'User baru terdaftar',
            $user->name.' mendaftar menggunakan email '.$user->email.'.',
            'info',
            route('user.show', $user->username, false)
        );

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
