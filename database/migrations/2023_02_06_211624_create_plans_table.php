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
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('number_of_classes');
            $table->unsignedInteger('duration_days');//how many days the user has to use the plan
            $table->unsignedFloat('price', 9, 2);
            $table->unsignedInteger('plan_type');//1 kangoo -> sin kangoos; 2 kangoo -> con kangoos; 3 Baile; 4 Gym
            $table->string('description')->nullable();
            $table->dateTime('expiration_date')->nullable();
            $table->unsignedInteger('available_plans')->nullable();
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
        Schema::dropIfExists('plans');
    }
};
