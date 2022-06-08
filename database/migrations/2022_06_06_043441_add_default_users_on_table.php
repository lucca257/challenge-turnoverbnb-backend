<?php

use App\Domains\Transaction\Models\UserBalance;
use App\Domains\Users\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(env('APP_ENV') === 'testing') {
            return;
        }
        User::insert([
            [
                "username" => "customer",
                "email" => "customer@mail.com",
                "password" => Hash::make("password"),
                "role" => "customer",
            ],
            [
                "username" => "admin",
                "email" => "admin@mail.com",
                "password" => Hash::make("password"),
                "role" => "admin",
            ],
        ]);
        UserBalance::create([
            "user_id" => 1,
            "current_balance" => 0,
            "total_incomes" => 0,
            "total_expenses" => 0,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
