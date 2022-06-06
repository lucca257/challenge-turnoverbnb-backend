<?php

namespace App\Applications\Api\Customer\Validators\Purchases;

use App\Domains\Purchases\DTOs\FilterPurchasesDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ListPurchasesValidator extends FormRequest
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
            'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            "month" => "required|between:1,12",
        ];
    }

    public function toDTO(): FilterPurchasesDTO
    {
        return new FilterPurchasesDTO(...$this->validated());
    }
}
