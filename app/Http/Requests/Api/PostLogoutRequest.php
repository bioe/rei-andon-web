<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PostLogoutRequest extends FormRequest
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
        return  array_merge($rules, [
            'watch_code' => ['string', 'max:255', 'required'],
        ]);
    }
}
