<?php

namespace App\Applications\Api\Authentication\Validators;

use App\Domains\Authentication\DTOs\AuthenticationDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthenticationValidator extends FormRequest
{
    /**
     * Disable validator redirect back to use in API
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "username" => "required|alpha_num|max:30",
            "email" => "nullable|email",
            "password" => "required|min:6"
        ];
    }

    public function toDTO(): AuthenticationDTO
    {
        return new AuthenticationDTO(...$this->validated());
    }
}
