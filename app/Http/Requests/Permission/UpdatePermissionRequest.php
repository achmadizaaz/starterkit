<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:permissions,name,' . $this->route('id'),
            'permission_group_id' => 'nullable|exists:permission_groups,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama permission wajib diisi.',
            'name.unique' => 'Nama permission sudah ada.',
            'name.max' => 'Nama permission tidak boleh lebih dari 255 karakter.',
            'permission_group_id.exists' => 'Permission group yang dipilih tidak valid.',
        ];
    }
}
