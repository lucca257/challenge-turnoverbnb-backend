<?php

namespace App\Domains\Deposits\Actions;

use App\Domains\Deposits\DTOs\ReviewDepositDTO;
use App\Domains\Deposits\Enums\DepositStatusEnum;
use App\Domains\Deposits\Models\Deposit;
use App\Domains\Transaction\Actions\CreateTransactionAction;
use App\Domains\Transaction\Enums\TransactionTypeEnum;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Domains\Transaction\DTOs\TransactionDTO;
use Illuminate\Support\Facades\DB;

class ReviewDepositAction
{
    public function __construct(private CreateTransactionAction $createTransactionAction) {}

    public function execute (ReviewDepositDTO $reviewDepositDTO)
    {
        return DB::transaction(function () use ($reviewDepositDTO) : Deposit
        {
            $deposit = Deposit::find($reviewDepositDTO->deposit_id);

            if($deposit->status !== DepositStatusEnum::PENDING->value)
            {
                throw new HttpResponseException(response()->json(["messa" => "This deposit already has a review"], 422));
            }

            if(!$reviewDepositDTO->accepted)
            {
                return $this->rejectDeposit($deposit, $reviewDepositDTO);
            }

            return $this->acceptDeposit($deposit, $reviewDepositDTO);
        });
    }

    private function rejectDeposit(Deposit $deposit, ReviewDepositDTO $reviewDepositDTO): Deposit
    {
        $deposit::find($reviewDepositDTO->deposit_id)->update([
            "status" => DepositStatusEnum::REJECTED->value,
            "reviewed_by" => $reviewDepositDTO->reviewed_by,
            "rejection_reason" => "Admin rejected deposit",
        ]);
        return $deposit->refresh();
    }

    private function acceptDeposit(Deposit $deposit, ReviewDepositDTO $reviewDepositDTO): Deposit
    {
        $this->createTransactionAction->execute(
            new TransactionDTO(
                $deposit->user_id,
                $deposit->amount,
                'Rejected deposit',
                TransactionTypeEnum::INCOME
            )
        );
        $deposit::find($reviewDepositDTO->deposit_id)->update([
            "status" => DepositStatusEnum::CONFIRMED->value,
            "reviewed_by" => $reviewDepositDTO->reviewed_by,
            "rejection_reason" => "Admin confirmed deposit",
        ]);
        return $deposit->refresh();
    }
}
