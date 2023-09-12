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
        Schema::create('client_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');//foreign. Is necessary the unsigned to match with the other table
            $table->bigInteger('plan_id', unsigned: true);//foreign. Is necessary the unsigned to match with the other table
            $table->unsignedInteger('remaining_shared_classes')->nullable();
            $table->dateTime('expiration_date');
            $table->unsignedInteger('payment_id');//foreign. Is necessary the unsigned to match with the other table
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
        Schema::dropIfExists('client_plans');
    }
};
