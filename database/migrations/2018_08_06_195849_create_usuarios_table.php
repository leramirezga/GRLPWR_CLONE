<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->String('email',64)->unique();
            $table->String('password')->nullable();//nullable for login with facebook.
            $table->String('rol');
            $table->unsignedFloat('nivel', 5, 2)->default(0);
            $table->String('nombre',64);
            $table->String('apellido_1', 64)->nullable();
            $table->String('apellido_2', 64)->nullable();
            $table->String('genero', 1)->nullable();//debe ser nulo porque solo se llena hasta que completan el perfil
            $table->String('descripcion', 140)->nullable();
            //$table->'pais';
            //$table->'departamento';
            $table->String('ciudad')->nullable();//debe ser nulo porque solo se llena hasta que completan el perfil
            $table->String('telefono', 15)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->String('foto')->default('default-avatar.png');
            $table->String('slug',64)->unique();/*campo utilizado para URL personalizada*/
            $table->boolean('verificado')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('usuarios');
    }
}
