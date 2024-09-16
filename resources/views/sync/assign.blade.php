@extends('layouts.main')

@section('title', 'Assign Permission')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Sync Permission: {{ $currentRole->name }}</h4>
                <div class="page-title-right">
                    <div class="page-title-right">
                        <button type="submit" class="btn btn-primary" form="assignForm">
                            <i class="bi bi-arrow-repeat me-1"></i> Synchronize
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Alert Component-->
        <x-alert type='html'/>
        <!-- end Alert Component -->

        <!-- start page main -->
        
         {{-- Change Role --}}
         @include('sync.select-role')
         {{-- END Change Role --}}
        <form action="{{ route('sync.permissions.store') }}" method="POST" id="assignForm">
            <input type="hidden" name="role" value="{{ $currentRole->id }}">
            @csrf
            <div class="card p-3">
                <table class="table table-striped">
                    <thead>
                        <th>Modul</th>
                        <th>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">
                                    Check All
                                </label>
                            </div>
                        </th>
                        <th>Create</th>
                        <th>Read</th>
                        <th>Update</th>
                        <th>Delete</th>
                        <th>Other</th>
                    </thead>
                    <tbody>
                        {{-- Modul User --}}
                        <tr>
                            <td class="fw-bold">User</td>
                            <td>
                                <input class="form-check-input me-2 checkbox checkAllUser" type="checkbox" id="all-user" onclick="checkAllUser(this)">
                                <label class="form-check-label" for="all-user">
                                    All User
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'create-users')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox user-group" type="checkbox" id="createUser" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('create-users'))>
                                <label class="form-check-label" for="createUser">
                                    Create
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'read-users')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox user-group" type="checkbox" id="readUser"  value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('read-users'))>
                                <label class="form-check-label" for="readUser">
                                    Read
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'update-users')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox user-group" type="checkbox" id="updateUser" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('update-users'))>
                                <label class="form-check-label" for="updateUser">
                                    Update
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'delete-users')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox user-group" type="checkbox" id="deleteUser" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('delete-users'))>
                                <label class="form-check-label" for="deleteUser">
                                    Delete
                                </label>
                            </td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#otherUserModal">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="otherUserModal" tabindex="-1" aria-labelledby="otherUserModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="otherUserModalLabel">Other User</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                @php
                                                    $permission = $permissions->where('name', 'read-trashed-users')->first();
                                                @endphp
                                                <input class="form-check-input me-2 checkbox user-group" type="checkbox" id="trashedUser" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('read-trashed-users'))>
                                                <label class="form-check-label" for="trashedUser">
                                                    Read Trashed
                                                </label>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-6">
                                                    @php
                                                        $permission = $permissions->where('name', 'restore-trashed-users')->first();
                                                    @endphp
                                                    <input class="form-check-input me-2 checkbox user-group" type="checkbox" id="restoreTrashedUser" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('restore-trashed-users'))>
                                                    <label class="form-check-label" for="restoreTrashedUser">
                                                        Restore User
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    @php
                                                        $permission = $permissions->where('name', 'restore-all-trashed-users')->first();
                                                    @endphp
                                                    <input class="form-check-input me-2 checkbox user-group" type="checkbox" id="restoreAllTrashedUser" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('restore-all-trashed-users'))>
                                                    <label class="form-check-label" for="restoreAllTrashedUser">
                                                        Restore All Users
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-6">
                                                    @php
                                                        $permission = $permissions->where('name', 'delete-trashed-users')->first();
                                                    @endphp
                                                    <input class="form-check-input me-2 checkbox user-group" type="checkbox" id="deleteTrashedUser" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('delete-trashed-users'))>
                                                    <label class="form-check-label" for="deleteTrashedUser">
                                                        Delete Permanent
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    @php
                                                        $permission = $permissions->where('name', 'delete-all-trashed-users')->first();
                                                    @endphp
                                                    <input class="form-check-input me-2 checkbox user-group" type="checkbox" id="deleteAllTrashedUser" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('delete-all-trashed-users'))>
                                                    <label class="form-check-label" for="deleteAllTrashedUser">
                                                        Delete All Permanent
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        {{-- End Modul User --}}

                        {{-- Modul Role --}}
                        <tr>
                            <td class="fw-bold">Role</td>
                            <td>
                                <input class="form-check-input me-2 checkbox checkAllRole" type="checkbox" id="all-role" onclick="checkAllRole(this)">
                                <label class="form-check-label" for="all-role">
                                    All Role
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'create-roles')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox role-group" type="checkbox" id="createRole" value="{{ $permission->id }}"  name="permission[]" @checked($currentRole->hasPermissionTo('create-roles'))>
                                <label class="form-check-label" for="createRole">
                                    Create
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'read-roles')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox role-group" type="checkbox" id="readRole"  value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('read-roles'))>
                                <label class="form-check-label" for="readRole">
                                    Read
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'update-roles')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox role-group" type="checkbox" id="updateRole"  value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('update-roles'))>
                                <label class="form-check-label" for="updateRole">
                                    Update
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'delete-roles')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox role-group" type="checkbox" id="deleteRole"  value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('update-roles'))>
                                <label class="form-check-label" for="deleteRole">
                                    Delete
                                </label>
                            </td>
                            <td>
                                -
                            </td>
                        </tr>
                        {{-- End Modul Role --}}

                        
                        {{-- Modul Options --}}
                        <tr>
                            <td class="fw-bold">Options</td>
                            <td>
                                <input class="form-check-input me-2 checkbox checkAllOption" type="checkbox" id="all-option" onclick="checkAllOption(this)">
                                <label class="form-check-label" for="all-option">
                                    All Options
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'create-options')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox option-group" type="checkbox" id="createOption" value="{{ $permission->id }}"  name="permission[]" @checked($currentRole->hasPermissionTo('create-options'))>
                                <label class="form-check-label" for="createOption">
                                    Create
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'read-options')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox option-group" type="checkbox" id="readOption"  value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('read-options'))>
                                <label class="form-check-label" for="readOption">
                                    Read
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'update-options')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox option-group" type="checkbox" id="updateOption"  value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('update-options'))>
                                <label class="form-check-label" for="updateOption">
                                    Update
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'delete-options')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox option-group" type="checkbox" id="deleteOption"  value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('update-options'))>
                                <label class="form-check-label" for="deleteOption">
                                    Delete
                                </label>
                            </td>
                            <td>
                                -
                            </td>
                        </tr>
                        {{-- End Modul Options --}}
                    </tbody>
                </table>
            </div>
        </form>
        <!-- end page main -->
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('assets/js/sync-permission-role/sync.js') }}" defer></script>
@endpush
