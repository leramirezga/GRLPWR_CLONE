<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->String('talla',1);
            $table->unsignedInteger('resistencia');
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
