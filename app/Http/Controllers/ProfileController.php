<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileChangePasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\AdditionalInformation;
use App\Models\Role;
use App\Models\UserProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{

    public function index()
    {
        return view('profile.index', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
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
        $user = Auth::user();
        $pathImage = $user->image;

        if(isset($request->image)){
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = time().'-'.$filenameWithExt;
            $pathImage = $request->file('image')->storeAs('users/images', $fileNameToStore, 'public');

            // Menghapus image user lama
            // Jika user memiliki image sebelumnya
            if(isset($user->image)){
                Storage::disk('public')->delete($user->image);
            }
        }

       
        $user->update([
                'name' => $request->name,
                'image' => $pathImage,
        ]);
       // Update or create additional information user
        UserProfile::updateOrInsert(
            ['user_id'  => $user->id],
            [// Update profile user
            // General
            'phone'     => $request->phone,
            'address'   => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'updated_at'=> now(),]
        );
        return to_route('profile')->with('success', 'Your user data has been successfully updated');
    }

    /**
     * Change password the user's account.
     */

    public function changePassword(ProfileChangePasswordRequest $request)
    {
        if(Hash::check($request->current_password, Auth::user()->password)){
            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $user->save();
            return back()->with('success', 'Katasandi pengguna berhasil diubah');
        }
        
        return back()->with('failed', 'Gagal mengubah katasandi pengguna');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // dd($request);
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
