<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosSolicitudServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios_solicitud_servicio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('solicitud_servicio_id');//foreign
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->unsignedInteger('estado');//0 activo, 3 con reclamación, 4 cancelado
            $table->boolean('finalizado_cliente')->nullable();
            $table->boolean('finalizado_entrenador')->nullable();
            $table->bigInteger('usuario_cancelacion', unsigned: true)->nullable();//foreign
            $table->dateTime('canceled_at')->nullable();//es importante la fecha de cancelación para los posibles reembolsos
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
        Schema::dropIfExists('horarios_solicitud_servicio');
    }
}
