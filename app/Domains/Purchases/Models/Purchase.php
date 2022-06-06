<?php

namespace App\Domains\Purchases\Models;

use App\Domains\Purchases\Repository\PurchaseRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function newEloquentBuilder($query): PurchaseRepository
    {
        return new PurchaseRepository($query);
    }
}
