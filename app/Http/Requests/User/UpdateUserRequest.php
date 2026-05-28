<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => 'required|string',
            'username' => ['required', 'string', Rule::unique('users', 'username')->ignore($userId)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'password' => 'nullable|min:7|confirmed',
            'password_confirmation' => 'nullable|min:7',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'status' => 'nullable|boolean',
            'role' => 'required|exists:roles,id',
        ];
    }
}
