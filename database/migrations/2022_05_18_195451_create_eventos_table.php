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
        Schema::create('eventos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('descripcion', 250)->nullable();
            $table->string('imagen');
            $table->string('info_adicional', 250)->nullable();
            $table->string('lugar');
            $table->integer('cupos');
            $table->float('precio', '9', '2');
            $table->float('precio_sin_botas', '9', '2')->nullable();
            $table->float('descuento', '9', '2')->nullable();
            $table->float('oferta', '5', '2')->nullable();
            $table->boolean('repeatable');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->time('start_hour')->nullable();
            $table->time('end_hour')->nullable();
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
        Schema::dropIfExists('eventos');
    }
};
