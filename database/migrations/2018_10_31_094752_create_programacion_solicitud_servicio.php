<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramacionSolicitudServicio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programacion_solicitud_servicio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('solicitud_servicio_id');//foreign
            $table->date('fecha_inicio');
            $table->date('fecha_finalizacion');
            $table->boolean('lunes')->nullable();
            $table->time('hora_inicio_lunes')->nullable();
            $table->time('hora_fin_lunes')->nullable();
            $table->boolean('martes')->nullable();
            $table->time('hora_inicio_martes')->nullable();
            $table->time('hora_fin_martes')->nullable();
            $table->boolean('miercoles')->nullable();
            $table->time('hora_inicio_miercoles')->nullable();
            $table->time('hora_fin_miercoles')->nullable();
            $table->boolean('jueves')->nullable();
            $table->time('hora_inicio_jueves')->nullable();
            $table->time('hora_fin_jueves')->nullable();
            $table->boolean('viernes')->nullable();
            $table->time('hora_inicio_viernes')->nullable();
            $table->time('hora_fin_viernes')->nullable();
            $table->boolean('sabado')->nullable();
            $table->time('hora_inicio_sabado')->nullable();
            $table->time('hora_fin_sabado')->nullable();
            $table->boolean('domingo')->nullable();
            $table->time('hora_inicio_domingo')->nullable();
            $table->time('hora_fin_domingo')->nullable();
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
        Schema::dropIfExists('programacion_solicitud_servicio');
    }
}
