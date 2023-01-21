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
        Schema::create('kangoo_partes', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedInteger('parte_id');
            $table->unsignedInteger('kangoo_id');
            $table->date('fecha_instalacion');
            $table->date('ultimo_mantenimiento');
            $table->date('proximo_mantenimiento');
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
        Schema::dropIfExists('kangoo_partes');
    }
};
