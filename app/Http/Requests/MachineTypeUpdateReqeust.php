<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MachineTypeUpdateReqeust extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'code' => ['string', 'max:255', 'required'],
            'name' => ['string', 'max:255', 'required'],
        ];

        return $rules;
    }
}
