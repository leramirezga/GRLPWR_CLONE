<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransaccionesPendientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacciones_pendientes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_transaccion');
            $table->boolean("verificada"); // false = Cuando aún no se ha obtenido el resultado final de la transaccion,
            // true cuando ya se encuentra actualziado el resultado
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
        Schema::dropIfExists('transacciones_pendientes');
    }
}
