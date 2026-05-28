<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

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


    public function store(CreateUserRequest $request)
    {
        $avatarPath = null;

        if ($request->hasFile('avatar')) {
            $avatarPath = $this->fileService->upload($request->file('avatar'), 'avatars', 'public');
        }

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email'    => $request->email,
            'status'   => $request->status,
            'avatar'   => $avatarPath,
        ]);

        $user->syncRoles([$request->role]);

        return back()->with('success', 'User telah ditambahkan!');
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->user->findOrFail($id);
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
            'status'   => $request->status,
            'avatar'   => $avatarPath,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);
        $user->syncRoles([$request->role]);

        return back()->with('success', 'User telah diperbarui!');
    }

    public function destroy($id)
    {
        $user = $this->user->findOrFail($id);

        if ($user->avatar) {
            $this->fileService->delete($user->avatar, 'public');
        }

        $user->delete();

        return back()->with('success', 'User telah dihapus!');
    }
}
