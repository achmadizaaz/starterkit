<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\LoginHistory;
use App\Services\ActivityLogger;
use App\Services\MfaCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request, MfaCodeService $mfaCodeService): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        if ($user->mfa_enabled) {
            $mfaCodeService->send($user);
            Auth::guard('web')->logout();
            $request->session()->put('mfa:user_id', $user->id);
            $request->session()->put('mfa:remember', $request->boolean('remember'));
            $request->session()->regenerate();

            return redirect()->route('mfa.challenge')->with('status', 'Kode MFA telah dikirim ke email Anda.');
        }

        $request->session()->regenerate();
        LoginHistory::create([
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'device' => Str::limit((string) request()->userAgent(), 255, ''),
            'browser' => Str::limit((string) request()->userAgent(), 255, ''),
            'login_at' => now()
        ]);
        ActivityLogger::log('Login berhasil');

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $userId = Auth::id();

        if ($userId) {
            LoginHistory::where('user_id', $userId)
                ->whereNull('logout_at')
                ->latest('login_at')
                ->first()
                ?->update(['logout_at' => now()]);

            ActivityLogger::log('Logout berhasil');
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
