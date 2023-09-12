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
        Schema::create('plan_classes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('class_type_id',unsigned: true);
            $table->bigInteger('plan_id',unsigned: true);
            $table->boolean('equipment_included');
            $table->boolean('unlimited');
            $table->unsignedInteger('number_of_classes')->nullable();
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
        Schema::dropIfExists('plan_classes');
    }
};
