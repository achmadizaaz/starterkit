<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\User;
use App\Models\UserProfile;
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

        $request->validate([
            'username' => ['required', 'unique:users,username,', 'string', 'min:5', 'regex:/^\S*$/'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // User Profile
            'phone' => 'nullable|numeric|digits_between:5,15',
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'boolean'],
        ]);

        $options = Option::whereIn('name', ['default-role', 'default-is-active'])->get()->keyBy('name');

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => isset($options['default-is-active']->value),
        ]);


        // Update or create additional information user
        UserProfile::updateOrInsert(
            ['user_id'  => $user->id],
            [// Update profile user
            // General
            'phone'     => $request->phone,
            'address'   => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,

            'updated_at'=> now(),]
        );

        
        // Assign role user
        if(isset($options['default-role']->value)){
            $user->syncRoles($options['default-role']->value);
        }
        
        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
