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
        Schema::create('sesiones_cliente', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cliente_id');//foreign. Is necessary the unsigned to match with the other table
            $table->unsignedInteger('kangoo_id')->nullable();//foreign. nullable because the client can has his/her own kangoos. Is necessary the unsigned to match with the other table
            $table->bigInteger('evento_id',unsigned: true);//foreign. Is necessary the unsigned to match with the other table
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->dateTime('reservado_hasta')->nullable();
            $table->unsignedInteger('calorias')->nullable();
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
        Schema::dropIfExists('sesiones_cliente');
    }
};
