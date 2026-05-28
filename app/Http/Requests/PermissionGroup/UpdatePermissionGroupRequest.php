<?php

namespace App\Http\Requests\PermissionGroup;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:permission_groups,name,' . $this->route('id'),
            'sort_at' => 'required|integer|unique:permission_groups,sort_at,' . $this->route('id'),
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama permission group wajib diisi.',
            'name.unique' => 'Nama permission group sudah ada.',
            'name.max' => 'Nama permission group tidak boleh lebih dari 255 karakter.',
            'sort_at.required' => 'Sort order wajib diisi.',
            'sort_at.integer' => 'Sort order harus berupa angka.',
            'sort_at.unique' => 'Sort order sudah ada.',
        ];
    }
}
