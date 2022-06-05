<?php

namespace App\Domains\Transaction\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Domains\Transaction\Repository\TransactionRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function newEloquentBuilder($query)
    {
        return new TransactionRepository($query);
    }
}
