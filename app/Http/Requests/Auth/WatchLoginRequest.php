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
        $watch = Watch::with('login_user')->where('code', $this->watch_code)->where('active', true)->first();
        $user = User::where('username', $this->username)->where('active', true)->first();

        //Check watch login to any user
        $watch_by_user_msg = null;
        if ($watch->login_user != null) {
            $watch_by_user_msg = $watch->login_user->name . " is login to " . $watch->code;
        }

        //Check user login to any watch
        $user_login_watch = null;
        if ($user) {
            $user_login_watch = Watch::where('login_user_id', $user->id)->where('active', true)->first();
        }

        $this->watch = $watch;
        $this->user = $user;

        if (!$watch || !$user || $user_login_watch || $watch_by_user_msg) {
            throw ValidationException::withMessages([
                'watch_code' => $watch == null ? "Watch Code not found." : ($watch_by_user_msg != null ?  $watch_by_user_msg : null),
                'username' => $user == null ? "Employee Code not found." : ($user_login_watch ? "This employee login to " . $user_login_watch->code : null),
            ]);
        }
    }
}
