<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Models\Watch;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\ValidationException;

class WatchLoginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules['watch_code'] = ['required', 'string'];
        $rules['username'] = ['required', 'string'];
        //$rules['password'] = ['required', 'string'];
        return $rules;
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $watch = Watch::where('code', $this->watch_code)->first();
        $user = User::where('username', $this->username)->where('user_type', OPERATOR)->first();

        $this->user = $user;

        if (!$watch || !$user) {
            throw ValidationException::withMessages([
                'watch_code' => $watch == null ? "Watch Code not found." : null,
                'username' => $user == null ? "Employee Code not found." : null,
            ]);
        }
    }
}
