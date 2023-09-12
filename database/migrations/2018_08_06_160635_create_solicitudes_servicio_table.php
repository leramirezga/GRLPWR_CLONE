<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudesServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes_servicio', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('usuario_id', unsigned: true);//foreign
            $table->string('titulo', 32);
            $table->string('descripcion', 140)->nullable();
            $table->string('ciudad', 64);
            $table->string('direccion', 140)->nullable();
            $table->float('latitud', 10, 6);
            $table->float('longitud', 10, 6);
            $table->boolean('tipo');//0 unica sesion, 1 varias sesiones
            $table->unsignedInteger('estado');//0 activa, 1 contratada, 2 pago liberado, 5 modificada. No tiene estado de eliminada porque usa soft delete
            $table->unsignedInteger('oferta_aceptada')->nullable();//foreign
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
        Schema::dropIfExists('solicitudes_servicio');
    }
}
