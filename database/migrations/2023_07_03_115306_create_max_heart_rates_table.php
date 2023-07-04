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
        Schema::create('max_heart_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('client_id');//foreign. Is necessary the unsigned to match with the other table
            $table->unsignedInteger('max_heart_rate');
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
        Schema::dropIfExists('max_heart_rates');
    }
};
