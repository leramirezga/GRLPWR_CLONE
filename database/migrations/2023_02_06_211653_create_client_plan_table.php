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
        Schema::create('client_plan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('client_id');//foreign. Is necessary the unsigned to match with the other table
            $table->unsignedInteger('plan_id');//foreign. Is necessary the unsigned to match with the other table
            $table->unsignedInteger('remaining_classes');
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
        Schema::dropIfExists('client_plan');
    }
};
