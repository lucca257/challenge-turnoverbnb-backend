<?php

namespace App\Domains\Deposits\Models;

use App\Domains\Deposits\Repository\DepositRepository;
use App\Domains\Images\Models\Image;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Deposit extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    protected $table = 'deposits';
    use HasFactory;

    protected $guarded = [];

    /**
     * @return HasOne
     */
    public function images() : HasOne
    {
        return $this->HasOne(Image::class, 'id', 'image_id');
    }

    /**
     * @return HasOne
     */
    public function user() : HasOne
    {
        return $this->hasONe(User::class, 'id', 'user_id');
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
