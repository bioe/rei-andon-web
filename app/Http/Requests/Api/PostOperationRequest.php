<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class PostOperationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'operation' => ['string', 'required'],
            'cabinetCode' => ['string', 'required'],
            'staffId' => ['string', 'required', 'exists:users,username'],
            'boxId' => ['string', 'required'],
            'boxNo' => ['string', 'required'],
            'occurAt' => ['date', 'required'],
        ];
    }

    /**
     * Customize the failed validation response.
     *
     * @param  Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        // Get the default validation messages
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json([
            'code'    => 40000, // Custom Error Code, follow China Cabinet Format
            'message' => $errors->first() . ' (and ' . (count($errors) - 1) . ' more errors)',
            'errors'  => $errors,
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)); // HTTP 422
    }
}
