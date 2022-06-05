<?php

namespace App\Domains\Deposits\Repository;

use App\Domains\Deposits\DTOs\ListDepositsDTO;
use Illuminate\Database\Eloquent\Builder;

class DepositRepository extends Builder
{
    public function findByFilters(ListDepositsDTO $filter): Self
    {
        return $this->whereYear('created_at', $filter->year)
            ->whereMonth('created_at', $filter->month)
            ->when($filter->status, function ($query) use ($filter) {
                return $query->where('status', $filter->status);
            })
            ->orderBy('created_at', 'desc');
    }
}
