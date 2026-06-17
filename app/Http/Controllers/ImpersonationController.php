<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ImpersonationController extends Controller
{
    public function store(Request $request, User $user): RedirectResponse
    {
        $actor = $request->user();

        abort_unless($actor?->hasRole('Super Administrator'), 403);

        if ($actor->is($user)) {
            throw ValidationException::withMessages([
                'user' => 'Anda sudah menggunakan akun tersebut.',
            ]);
        }

        if (! $user->status) {
            throw ValidationException::withMessages([
                'user' => 'Tidak dapat login as ke user inactive.',
            ]);
        }

        $request->session()->put('impersonator_id', $actor->id);
        $request->session()->put('impersonator_name', $actor->name);
        $request->session()->put('impersonator_started_at', now()->toDateTimeString());

        ActivityLogger::log('Login as user '.$user->username);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Anda sedang login sebagai '.$user->name.'.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $impersonatorId = $request->session()->pull('impersonator_id');
        $request->session()->forget(['impersonator_name', 'impersonator_started_at']);

        abort_unless($impersonatorId, 403);

        Auth::loginUsingId($impersonatorId);
        $request->session()->regenerate();

        ActivityLogger::log('Kembali ke akun utama setelah login as');

        return redirect()->route('dashboard')->with('success', 'Anda sudah kembali ke akun utama.');
    }
}
