<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorialesRealizados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutoriales_realizados', function (Blueprint $table) {
            $table->unsignedInteger('tutorial_id');//foreign
            $table->unsignedInteger('usuario_id');//foreing
            //TODO unique entre tutorial id y usuario id
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
        Schema::dropIfExists('tutoriales_realizados');
    }
}
