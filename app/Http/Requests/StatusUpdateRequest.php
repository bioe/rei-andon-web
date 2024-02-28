<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusUpdateRequest extends FormRequest
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
            'code' => ['string', 'max:255'],
            'name' => ['string', 'max:255'],
            'state' => ['string', 'max:255'],
            'button_1' => ['string', 'max:255'],
            'button_2' => ['nullable', 'string', 'max:255'],
            'active' => ['boolean'],
        ]);
    }
}
