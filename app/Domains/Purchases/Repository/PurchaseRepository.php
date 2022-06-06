<?php

namespace App\Domains\Purchases\Repository;

use App\Domains\Purchases\DTOs\FilterPurchasesDTO;
use Illuminate\Database\Eloquent\Builder;

class PurchaseRepository extends Builder
{
    public function findByFilters(FilterPurchasesDTO $filter): Self
    {
        return $this->whereYear('created_at', $filter->year)
            ->whereMonth('created_at', $filter->month)
            ->orderBy('created_at', 'desc');
    }
}
