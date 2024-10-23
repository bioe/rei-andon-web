<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {

        //$this->user = id
        $rules = [];
        if (env(LOGIN_USERNAME, false)) {
            $rules['username'] = ['alpha_dash', 'max:255', Rule::unique(User::class)->ignore($this->user)];
        }
        if ($this->isMethod('POST')) {
            $rules['password'] = ['required', Password::min(6)];
        } else {
            $rules['password'] = ['nullable', Password::min(6)];
        }
        return  array_merge($rules, [
            'name' => ['string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user)],
            'active' => ['boolean'],
            'user_type' => ['string'],
            'shift' => ['nullable', 'string'],
            'badge_no' => ['nullable', 'string', Rule::unique(User::class)->ignore($this->user)],
        ]);
    }
}
