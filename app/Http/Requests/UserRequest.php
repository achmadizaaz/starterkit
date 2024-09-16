<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => $this->image ? 'mimes:png,jpg,jpeg|max:2048':'',
            'username' => ['required', Rule::unique('users', 'username')->ignore($this->id), 'string', 'min:5', 'regex:/^\S*$/'],
            'email' => $this->method() == 'POST' ? 'required|email' : '',
            'is_active' => 'required|boolean',
            'password' => $this->method() == 'POST' ? 'required|string|min:7|max:16' :'',
            'gender' => 'boolean',
            'date_of_birth' => 'nullable|date',
            'phone' => 'nullable|numeric|digits_between:5,15',
        ];
    }

    public function messages()
    {
        return [
            'is_active.boolean' => 'The is active field must be active or non-active.',
            'username.regex' => 'The username field format invalid and cannot contain spaces.',
            'gender.boolean' => 'The is gender field must be man or woman.',
        ];
    }
}
