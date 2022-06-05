<?php

namespace App\Domains\Deposits\Repository;

use App\Domains\Transaction\DTOs\FilterTransactionDTO;
use Illuminate\Database\Eloquent\Builder;

class DepositRepository extends Builder
{
    public function findByFilters(FilterTransactionDTO $filter): Self
    {
        return $this->whereYear('created_at', $filter->year)
            ->whereMonth('created_at', $filter->month)
            ->orderBy('created_at', 'desc');
    }
}
