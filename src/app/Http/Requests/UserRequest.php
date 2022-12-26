<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('users')->where(function ($query) {
                return $query->where('id', '<>', $this->id);
            })],
            'email' => ['required', 'email:rfc,dns', 'max:255', 'unique:users'],
            'password' => ['required',
                'string',
                'min:8',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character,
                ]
        ];

        if ($this->route()->uri !== 'api/auth/register') {
            $rules = [
                'email' => 'required',
                'password' => 'required'
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => __('Name field is required'),
            'name.max:255' => __('Name field must be not longer than 255 characters'),
            'name.unique' => __('This name is in used'),
            'name.string' => __('Name field must be a string'),
            'email.required' => __('Email field is required'),
            'email.unique' => __('This address email is in used'),
            'email.email' => __('Email must be valid email address'),
            'password.required' => __('Password field is required'),
            'password.string' => __('Password field must be a string'),
            'password.min' => __('Password field must have min 8 characters'),
            'password.regex' => __('Password must contain at least one lowercae letter, at least one uppercase letter, at least one digit, at least one special character')
        ];
    }
}
