<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntrenadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrenadores', function (Blueprint $table) {
            $table->bigInteger('usuario_id', unsigned: true)->unique();//foreign
            /*Los atributos financieros pueden ser nulos para que pueda registrarse sin llenar estos datos*/
            $table->String('banco',140)->nullable();
            $table->boolean('tipo_cuenta')->nullable();//0 ahorros, 1 corriente)
            $table->String('numero_cuenta', 32)->nullable();
            $table->unsignedInteger('tarifa')->nullable();//la tarifa puede ser nula para que en la futura versión puedan haber profesiones sin tarifa
            /**/
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
        Schema::dropIfExists('entrenadores');
    }
}
