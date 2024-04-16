<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsSolicitudServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags_solicitud_servicio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tag_id');//foreign
            $table->unsignedInteger('solicitud_servicio_id');//foreign
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
        Schema::dropIfExists('tags_solicitud_servicio');
    }
}
