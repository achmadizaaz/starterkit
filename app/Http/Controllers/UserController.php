<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use App\Services\ActivityLogger;

class UserController extends Controller
{
    protected $user, $fileService;

    public function __construct(User $user, FileService $fileService)
    {
        $this->user = $user;
        $this->fileService = $fileService;
    }

    public function index(Request $request)
    {
        return view('user.index', [
            'users' => $this->user->with('roles')->paginate(10),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function show(string $username)
    {
        return view('user.show', [
            'user' => $this->user
                ->with(['roles', 'profile', 'loginHistories'])
                ->where('username', $username)
                ->firstOrFail(),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }


    public function store(CreateUserRequest $request)
    {
        $this->ensureRoleCanBeAssigned($request, $request->input('role'));

        $avatarPath = null;

        if ($request->hasFile('avatar')) {
            $avatarPath = $this->fileService->upload($request->file('avatar'), 'avatars', 'public');
        }

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email'    => $request->email,
            'status'   => $request->boolean('status'),
            'avatar'   => $avatarPath,
        ]);

        if ($request->boolean('email_verified')) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        $user->syncRoles([$request->role]);
        ActivityLogger::log('Menambahkan user '.$user->username);

        return back()->with('success', 'User telah ditambahkan!');
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->user->findOrFail($id);
        $emailChanged = $user->email !== $request->email;

        $this->ensureUserCanBeManaged($request, $user);
        $this->ensureRoleCanBeAssigned($request, $request->input('role'));

        if ($user->is($request->user()) && (
            $request->boolean('status') !== (bool) $user->status
            || (string) $request->input('role') !== (string) $user->roles->first()?->id
            || $request->filled('password')
        )) {
            throw ValidationException::withMessages([
                'user' => 'Role, status, dan password akun yang sedang digunakan tidak dapat diubah dari modul User.',
            ]);
        }

        $avatarPath = $user->avatar;

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                $this->fileService->delete($user->avatar, 'public');
            }
            $avatarPath = $this->fileService->upload($request->file('avatar'), 'avatars', 'public');
        }

        $updateData = [
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'status'   => $request->boolean('status'),
            'avatar'   => $avatarPath,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);
        $user->forceFill([
            'email_verified_at' => $request->boolean('email_verified')
                ? ($emailChanged || ! $user->email_verified_at ? now() : $user->email_verified_at)
                : null,
        ])->save();
        $user->syncRoles([$request->role]);
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $request->input('phone'),
                'gender' => $request->input('gender'),
                'birth_date' => $request->input('birth_date'),
                'country' => $request->input('country'),
                'address' => $request->input('address'),
                'website' => $request->input('website'),
                'social_media' => collect($request->input('social_media', []))
                    ->filter(fn ($value) => filled($value))
                    ->all() ?: null,
            ]
        );
        ActivityLogger::log('Memperbarui user '.$user->username);

        if ($request->input('redirect_to') === 'detail') {
            return redirect()
                ->route('user.show', $user->username)
                ->with('success', 'User telah diperbarui!');
        }

        return back()->with('success', 'User telah diperbarui!');
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ]);

        $user = $this->user->findOrFail($id);
        $this->ensureUserCanBeManaged($request, $user);

        if ($user->is($request->user())) {
            throw ValidationException::withMessages([
                'password' => 'Gunakan halaman profil untuk mengganti password akun sendiri.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);
        ActivityLogger::log('Mengubah kata sandi user '.$user->username);

        return back()->with('success', 'Kata sandi user telah diperbarui!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'boolean'],
        ]);

        $user = $this->user->findOrFail($id);
        $this->ensureUserCanBeManaged($request, $user);

        if ($user->is($request->user())) {
            throw ValidationException::withMessages([
                'status' => 'Anda tidak dapat mengubah status akun yang sedang digunakan.',
            ]);
        }

        $user->update([
            'status' => $request->boolean('status'),
        ]);
        ActivityLogger::log('Mengubah status user '.$user->username.' menjadi '.($user->status ? 'Active' : 'Inactive'));

        return back()->with('success', 'Status user telah diperbarui!');
    }

    public function destroy($id)
    {
        $user = $this->user->findOrFail($id);
        $this->ensureUserCanBeManaged(request(), $user);

        if ($user->is(request()->user())) {
            throw ValidationException::withMessages([
                'user' => 'Anda tidak dapat menghapus akun yang sedang digunakan.',
            ]);
        }

        if ($user->avatar) {
            $this->fileService->delete($user->avatar, 'public');
        }

        $user->delete();
        ActivityLogger::log('Menghapus user '.$user->username);

        return back()->with('success', 'User telah dihapus!');
    }

    private function ensureUserCanBeManaged(Request $request, User $user): void
    {
        if ($user->hasRole('Super Administrator')) {
            throw ValidationException::withMessages([
                'user' => 'Akun Super Administrator tidak dapat dikelola dari modul User.',
            ]);
        }
    }

    private function ensureRoleCanBeAssigned(Request $request, mixed $roleId): void
    {
        $role = Role::findOrFail($roleId);

        if ($role->code === 'super-administrator' && ! $request->user()->hasRole('Super Administrator')) {
            throw ValidationException::withMessages([
                'role' => 'Hanya Super Administrator yang dapat memberikan role Super Administrator.',
            ]);
        }
    }
}
