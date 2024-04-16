<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigInteger('usuario_id', unsigned: true);;//foreing
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
