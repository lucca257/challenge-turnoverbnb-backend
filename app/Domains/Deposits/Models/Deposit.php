<?php

namespace App\Domains\Deposits\Models;

use App\Domains\Deposits\Repository\DepositRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'deposits';
    use HasFactory;

    protected $guarded = [];

    public function newEloquentBuilder($query): DepositRepository
    {
        return new DepositRepository($query);
    }
}
