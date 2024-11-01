<?php

namespace App\Http\Requests;

use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGroupRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        //$this->group = id, laravel automatically assign
        return  [
            'code' => ['string', 'max:255', Rule::unique(Group::class)->ignore($this->group)], //Need to be unique, want to use for import
            'description' => ['nullable', 'string', 'max:255'],
            'active' => ['boolean'],
            'segment_code' => ['string'],
            'machine_list' => ['array'],
            'status_list' => ['array'],
        ];
    }
}
