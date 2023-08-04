<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edited_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('evento_id',unsigned: true);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->time('start_hour');
            $table->time('end_hour');
            $table->boolean('deleted');
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->string('info_adicional')->nullable();
            $table->string('lugar')->nullable();
            $table->integer('cupos')->nullable();
            $table->float('precio', '9', '2')->nullable();
            $table->float('precio_sin_botas', '9', '2')->nullable();
            $table->float('descuento', '9', '2')->nullable();
            $table->float('oferta', '5', '2')->nullable();
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
        Schema::dropIfExists('edited_events');
    }
};
