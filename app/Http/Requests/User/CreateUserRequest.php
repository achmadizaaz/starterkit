<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9._-]+$/', 'unique:users,username'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'password_confirmation' => ['required'],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'status' => 'nullable|boolean',
            'email_verified' => ['nullable', 'boolean'],
            'role' => 'required|exists:roles,id',
        ];
    }

    public function messages(): array
    {
        return [
            'username.regex' => 'Username tidak boleh menggunakan spasi dan hanya boleh berisi huruf, angka, titik, garis bawah, atau tanda minus.',
        ];
    }
}
