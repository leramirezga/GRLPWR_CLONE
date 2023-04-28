<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransaccionesPagos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacciones_pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('payment_method_id');//foreign. Is necessary the unsigned to match with the other table
            $table->string('ref_payco');
            $table->integer('codigo_respuesta');
            $table->string('respuesta');
            $table->longText('data');
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('transacciones_pagos');
    }
}
