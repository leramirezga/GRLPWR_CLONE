<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('usuario_id', unsigned: true);;//foreign
            $table->string('titulo');
            $table->string('portada');//Si es solo un video en la portada se coloca el link
            $table->text('contenido')->nullable();//65535 caracteres
            $table->unsignedInteger('tipo');//0 blog, 1 video
            $table->String('slug',64)->unique();/*campo utilizado para URL personalizada*/
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
        Schema::dropIfExists('blogs');
    }
}
