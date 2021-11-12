<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoyaltyPointsTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyalty_points_transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->float('points_amount');
            $table->float('payment_amount')->nullable();
            $table->string('payment_id')->nullable();
            $table->integer('payment_time')->nullable();
            $table->string('description');
            $table->integer('points_rule')->nullable();
            $table->unsignedInteger('canceled')->default(0);
            $table->string('cancellation_reason')->nullable();
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('loyalty_account')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loyalty_points_transaction');
    }
}
