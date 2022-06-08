<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->float('amount');
            $table->string('status')->index();
            $table->text("rejection_reason")->nullable();
            $table->foreignId('user_id')->constrained();
            $table->integer('reviewed_by')->nullable()->constrained('users');
            $table->integer('transaction_id')->nullable()->constrained();
            $table->foreignId('image_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposits');
    }
};
