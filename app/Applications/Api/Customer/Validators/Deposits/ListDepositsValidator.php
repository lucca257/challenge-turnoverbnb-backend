<?php

namespace App\Applications\Api\Customer\Validators\Deposits;

use App\Domains\Deposits\DTOs\ListDepositsDTO;
use App\Domains\Deposits\Enums\DepositStatusEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ListDepositsValidator extends FormRequest
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
            "status" => "nullable|in:pending,confirmed,rejected",
        ];
    }

    public function toDTO(): ListDepositsDTO
    {
        $filter_dto = new ListDepositsDTO(
            $this->input('year'),
            $this->input('month'),
        );

        if ($this->has('status')) {
            $filter_dto->status = DepositStatusEnum::from($this->input("status"));
        }
        return $filter_dto;
    }
}
