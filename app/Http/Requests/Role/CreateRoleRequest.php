<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:255|unique:roles,code',
            'name' => 'required|string|max:255|unique:roles,name',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Kode role wajib diisi.',
            'code.unique' => 'Kode role sudah ada.',
            'code.max' => 'Kode role tidak boleh lebih dari 255 karakter.',
            'name.required' => 'Nama role wajib diisi.',
            'name.unique' => 'Nama role sudah ada.',
            'name.max' => 'Nama role tidak boleh lebih dari 255 karakter.',
        ];
    }
}
