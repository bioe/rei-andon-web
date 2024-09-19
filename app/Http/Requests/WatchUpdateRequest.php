<?php

namespace App\Http\Requests;

use App\Models\Watch;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class WatchUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return  [
            'code' => ['string', 'max:255'],
            'ip_address' => ['ip', 'max:255', Rule::unique(Watch::class)->ignore($this->ip_address)],
            'active' => ['boolean'],
        ];
    }
}
