<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return  [
            'name' => ['string', 'max:255'],
            'description' => ['string', 'max:255'],
            'active' => ['boolean'],
            'machine_list' => ['array'],
        ];
    }
}