<?php

namespace App\Applications\Api\Customer\Validators\Purchases;

use App\Domains\Purchases\DTOs\FilterPurchasesDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class StorePurchasesValidator extends FormRequest
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
            "amount" => "required|numeric",
            "description" => "required|string",
            "purchase_at" => "required|date_format:Y-m-d",
        ];
    }

    public function toDTO(): FilterPurchasesDTO
    {
        return new FilterPurchasesDTO(["user_id" => Auth::user()->id], ...$this->validated());
    }
}
