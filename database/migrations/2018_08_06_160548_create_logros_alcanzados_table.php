<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogrosAlcanzadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logros_alcanzados', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('logro_id');//foreign
            $table->bigInteger('usuario_id', unsigned: true);//foreign
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
        Schema::dropIfExists('logros_alcanzados');
    }
}
