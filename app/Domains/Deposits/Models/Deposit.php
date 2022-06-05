<?php

namespace App\Domains\Deposits\Models;

use App\Domains\Deposits\Repository\DepositRepository;
use App\Domains\Images\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deposit extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    protected $table = 'deposits';
    use HasFactory;

    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function images() : HasMany
    {
        return $this->hasMany(Image::class, 'id', 'image_id');
    }

    /**
     * @param $query
     * @return DepositRepository
     */
    public function newEloquentBuilder($query): DepositRepository
    {
        return new DepositRepository($query);
    }
}
