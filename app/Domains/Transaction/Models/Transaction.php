<?php

namespace App\Domains\Transaction\Models;

use App\Domains\Transaction\Repository\TransactionRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function newEloquentBuilder($query): TransactionRepository
    {
        return new TransactionRepository($query);
    }
}
