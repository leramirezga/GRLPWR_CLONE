<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estaturas', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('usuario_id', unsigned: true);//foreign
            $table->unsignedFloat('estatura',5,2);
            $table->unsignedInteger('unidad_medida');//0 metros, 1 centimetros, 2 pulgadas
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
        Schema::dropIfExists('estaturas');
    }
}
