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
            $table->boolean('is_confirmed')->default(false)->index();
            $table->text("rejection_reason")->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->foreignId('transaction_id')->constrained();
            $table->foreignId('image_id')->constrained();
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
