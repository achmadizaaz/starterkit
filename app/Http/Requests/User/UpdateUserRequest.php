<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('id');

        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9._-]+$/', Rule::unique('users', 'username')->ignore($userId)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'password_confirmation' => ['nullable'],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'status' => 'nullable|boolean',
            'email_verified' => ['nullable', 'boolean'],
            'role' => 'required|exists:roles,id',
            'phone' => ['nullable', 'string', 'max:50'],
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'birth_date' => ['nullable', 'date'],
            'country' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:1000'],
            'website' => ['nullable', 'url:http,https', 'max:255'],
            'social_media' => ['nullable', 'array'],
            'social_media.instagram' => ['nullable', 'url:http,https', 'max:255'],
            'social_media.facebook' => ['nullable', 'url:http,https', 'max:255'],
            'social_media.linkedin' => ['nullable', 'url:http,https', 'max:255'],
            'social_media.twitter' => ['nullable', 'url:http,https', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.regex' => 'Username tidak boleh menggunakan spasi dan hanya boleh berisi huruf, angka, titik, garis bawah, atau tanda minus.',
        ];
    }
}
