<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKangoosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kangoos', function (Blueprint $table) {
            $table->increments('id');
            $table->String('marca');
            $table->String('referencia');
            $table->String('SKU')->unique();
            //TODO change for enum
            $table->String('talla',1);
            $table->unsignedInteger('resistencia');
            //TODO change for enum
            $table->String('estado');//(disponible, asignado, en mantenimiento, dañado, borrado)
            $table->String('anotaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kangoos');
    }
}
