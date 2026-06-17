<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ActivityLogger;
use App\Services\MfaCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MfaController extends Controller
{
    public function __construct(private readonly MfaCodeService $mfaCodeService)
    {
    }

    public function challenge(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('mfa:user_id')) {
            return redirect()->route('login');
        }

        return view('auth.mfa-challenge');
    }

    public function verify(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:32'],
        ]);

        $user = User::find($request->session()->get('mfa:user_id'));

        if (! $user) {
            return redirect()->route('login');
        }

        $verified = preg_match('/^\d{6}$/', $validated['code'])
            ? $this->mfaCodeService->verify($user, $validated['code'])
            : $this->mfaCodeService->verifyRecoveryCode($user, $validated['code']);

        if (! $verified) {
            return back()->withErrors(['code' => 'Kode MFA atau recovery code tidak valid.']);
        }

        $remember = (bool) $request->session()->pull('mfa:remember', false);
        $request->session()->forget('mfa:user_id');
        $this->mfaCodeService->clear($user);

        Auth::login($user, $remember);
        $request->session()->regenerate();
        $this->writeLoginHistory($request);
        ActivityLogger::log('Login menggunakan MFA');

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function resend(Request $request): RedirectResponse
    {
        $user = User::find($request->session()->get('mfa:user_id'));

        if (! $user) {
            return redirect()->route('login');
        }

        $this->mfaCodeService->send($user);

        return back()->with('status', 'Kode MFA baru telah dikirim.');
    }

    public function enable(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $request->user()->forceFill([
            'mfa_enabled' => true,
            'mfa_confirmed_at' => now(),
        ])->save();
        $codes = $this->mfaCodeService->generateRecoveryCodes($request->user());
        ActivityLogger::log('Mengaktifkan MFA pribadi');

        return back()
            ->with('success', 'MFA berhasil diaktifkan. Simpan recovery codes di tempat aman.')
            ->with('mfa_recovery_codes', $codes);
    }

    public function disable(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $request->user()->forceFill([
            'mfa_enabled' => false,
            'mfa_code_hash' => null,
            'mfa_expires_at' => null,
            'mfa_confirmed_at' => null,
            'mfa_recovery_codes' => null,
        ])->save();
        ActivityLogger::log('Menonaktifkan MFA pribadi');

        return back()->with('success', 'MFA berhasil dinonaktifkan.');
    }

    public function regenerateRecoveryCodes(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        abort_unless($request->user()->mfa_enabled, 403);

        $codes = $this->mfaCodeService->generateRecoveryCodes($request->user());
        ActivityLogger::log('Membuat ulang recovery codes MFA pribadi');

        return back()
            ->with('success', 'Recovery codes baru berhasil dibuat. Kode lama tidak dapat digunakan lagi.')
            ->with('mfa_recovery_codes', $codes);
    }

    private function writeLoginHistory(Request $request): void
    {
        \App\Models\LoginHistory::create([
            'user_id' => Auth::id(),
            'ip_address' => $request->ip(),
            'device' => Str::limit((string) $request->userAgent(), 255, ''),
            'browser' => Str::limit((string) $request->userAgent(), 255, ''),
            'login_at' => now(),
        ]);
    }
}
