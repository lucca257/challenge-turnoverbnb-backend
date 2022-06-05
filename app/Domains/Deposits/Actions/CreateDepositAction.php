<?php

namespace App\Domains\Deposits\Actions;

use App\Domains\Deposits\DTOs\DepositDTO;
use App\Domains\Deposits\Enums\DepositStatusEnum;
use App\Domains\Deposits\Models\Deposit;
use App\Domains\Images\Actions\CreateImageAction;
use Illuminate\Support\Facades\DB;

class CreateDepositAction
{
    public function __construct(private CreateImageAction $imageAction){}
    public function execute(DepositDTO $depositDTO): Deposit
    {
        return DB::transaction(function () use ($depositDTO) {
            $image = $this->imageAction->execute($depositDTO->image, $depositDTO->user_id);
            return Deposit::create([
                "amount" => $depositDTO->amount,
                "description" => $depositDTO->description,
                "user_id" => $depositDTO->user_id,
                "status" => DepositStatusEnum::PENDING->value,
                "image_id" => $image->id
            ]);
        });
    }


}
