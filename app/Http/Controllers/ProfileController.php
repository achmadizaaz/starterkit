<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLog\ActivityLog;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\FileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use App\Services\ActivityLogger;

class ProfileController extends Controller
{
    protected $fileService;

    public function __construct()
    {
        $this->fileService = new FileService();
    }

    /**
     * Display the user's profile form.
     */
    public function show(Request $request): View
    {
       
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                $this->fileService->delete($user->avatar, 'public');
            }

            $validated['avatar'] = $this->fileService->upload($request->file('avatar'), 'avatars', 'public');
        }

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'avatar' => $validated['avatar'] ?? $user->avatar,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $validated['phone'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'birth_date' => $validated['birth_date'] ?? null,
                'country' => $validated['country'] ?? null,
                'address' => $validated['address'] ?? null,
                'website' => $validated['website'] ?? null,
                'social_media' => collect($validated['social_media'] ?? [])
                    ->filter(fn ($value) => filled($value))
                    ->all() ?: null,
            ]
        );
        ActivityLogger::log('Memperbarui profil pribadi');

        return Redirect::route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->hasRole('Super Administrator')) {
            throw ValidationException::withMessages([
                'password' => 'Akun Super Administrator tidak dapat dihapus dari halaman profil.',
            ]);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        Auth::user()->password = Hash::make($request->input('password'));
        Auth::user()->save();
        ActivityLogger::log('Mengubah kata sandi pribadi');
        
        return back()->with('success', 'Katasandi berhasil diubah!');
    }
}
