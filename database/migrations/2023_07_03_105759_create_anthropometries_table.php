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
        Schema::create('anthropometries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');//foreign. Is necessary the unsigned to match with the other table
            $table->unsignedInteger('heart_rate')->nullable();
            $table->unsignedInteger('systolic_pressure')->nullable();
            $table->unsignedInteger('diastolic_pressure')->nullable();
            $table->unsignedFloat('hip')->nullable();
            $table->unsignedFloat('abdominal_perimeter')->nullable();
            $table->unsignedFloat('back')->nullable();
            $table->unsignedFloat('chest')->nullable();
            $table->unsignedFloat('right_thigh')->nullable();
            $table->unsignedFloat('left_thigh')->nullable();
            $table->unsignedFloat('right_arm')->nullable();
            $table->unsignedFloat('left_arm')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('anthropometries');
    }
};
