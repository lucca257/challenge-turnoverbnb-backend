<?php

namespace App\Applications\Api\Customer\Validators\Deposits;


use App\Domains\Deposits\DTOs\DepositDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class StoreDepositsValidator extends FormRequest
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
            "amount" => "required|integer",
            "description" => "required|max:255",
            "image" => "required|image"
        ];
    }

    public function toDTO(): DepositDTO
    {
         return new DepositDTO(...[...$this->validated(), "user_id" => Auth::user()->id]);
    }
}
