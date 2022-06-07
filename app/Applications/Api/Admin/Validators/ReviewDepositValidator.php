<?php

namespace App\Applications\Api\Admin\Validators;

use App\Domains\Authentication\DTOs\AuthenticationDTO;
use App\Domains\Deposits\DTOs\ReviewDepositDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class ReviewDepositValidator extends FormRequest
{
    /**
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator) : void{
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "deposit_id" => "required|exists:deposits,id",
            "accepted" => "required|boolean",
        ];
    }

    public function toDTO(): ReviewDepositDTO
    {
        return new ReviewDepositDTO(Auth::user()->id, ...$this->validated());
    }
}
