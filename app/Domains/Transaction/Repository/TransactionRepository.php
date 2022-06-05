<?php

namespace App\Domains\Transaction\Repository;

use App\Domains\Transaction\DTOs\FilterTransactionDTO;
use Illuminate\Database\Eloquent\Builder;

class TransactionRepository extends Builder
{
    public function findByFilters(FilterTransactionDTO $filter): Self
    {
        return $this->whereYear('created_at', $filter->year)
            ->whereMonth('created_at', $filter->month)
            ->when($filter->type, function (Self $query) use ($filter) {
                return $query->where('type', $filter->type);
            })
            ->orderBy('created_at', 'desc');
    }
}
