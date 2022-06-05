<?php

namespace App\Applications\Api\Customer\Validators;

use App\Domains\Transaction\DTOs\FilterTransactionDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ListTransactionValidator extends FormRequest
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
            'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            "month" => "required|between:1,12",
            "type" => "nullable|in:income,expense"
        ];
    }

    public function toDTO(): FilterTransactionDTO
    {
        return new FilterTransactionDTO(
            $this->input("year"),
            $this->input("month")
        );
    }
}
