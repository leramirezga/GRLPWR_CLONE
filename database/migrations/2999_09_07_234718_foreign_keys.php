<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->foreign('usuario_id')->references('id')->on('usuarios');
        });

        Schema::table('entrenadores', function (Blueprint $table) {
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            //$table->foreign('banco')->references('id')->on('bancos');//TODO
        });

        Schema::table('horarios_solicitud_servicio', function (Blueprint $table) {
            $table->foreign('solicitud_servicio_id')->references('id')->on('solicitudes_servicio');
            $table->foreign('usuario_cancelacion')->references('id')->on('usuarios');
        });

        Schema::table('logros_alcanzados', function (Blueprint $table) {
            $table->foreign('logro_id')->references('id')->on('logros');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
        });

        Schema::table('ofrecimientos', function (Blueprint $table) {
            $table->foreign('solicitud_servicio_id')->references('id')->on('solicitudes_servicio');
            $table->foreign('usuario_id')->references('id')->on('usuarios');//se coloca directamente en usuarios, para que un entrenador pueda crear solicitudes sin necesidad de completar su perfil
        });

        Schema::table('pesos', function (Blueprint $table) {
            $table->foreign('usuario_id')->references('usuario_id')->on('clientes');
        });

        Schema::table('estaturas', function (Blueprint $table) {
            $table->foreign('usuario_id')->references('usuario_id')->on('clientes');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->foreign('reviewer_id')->references('id')->on('usuarios');
        });

        Schema::table('solicitudes_servicio', function (Blueprint $table) {
            $table->foreign('usuario_id')->references('usuario_id')->on('clientes');
            $table->foreign('oferta_aceptada')->references('id')->on('ofrecimientos');
        });

        Schema::table('tags_solicitud_servicio', function (Blueprint $table) {
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->foreign('solicitud_servicio_id')->references('id')->on('solicitudes_servicio');
        });

        Schema::table('tags_entrenador', function (Blueprint $table) {
            $table->foreign('usuario_id')->references('usuario_id')->on('entrenadores');
            $table->foreign('tag_id')->references('id')->on('tags');
        });

        Schema::table('tutoriales_realizados', function (Blueprint $table) {
            $table->foreign('tutorial_id')->references('id')->on('tutoriales');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
        });

        Schema::table('transacciones_pagos', function (Blueprint $table) {
            $table->foreign('cliente_id')->references('usuario_id')->on('clientes');
            $table->foreign('sesion_evento_id')->references('id')->on('sesiones_evento');
        });
        Schema::table('transacciones_pendientes', function (Blueprint $table) {
            $table->foreign('id_transaccion')->references('id')->on('transacciones_pagos');
        });

        Schema::table('programacion_solicitud_servicio', function (Blueprint $table) {
            $table->foreign('solicitud_servicio_id')->references('id')->on('solicitudes_servicio');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->foreign('usuario_id')->references('id')->on('usuarios');
        });

        Schema::table('comentarios', function (Blueprint $table) {
            $table->foreign('blog_id')->references('id')->on('blogs');
            $table->foreign('reply_id')->references('id')->on('comentarios');
        });

        Schema::table('sesiones_evento', function (Blueprint $table) {
            $table->foreign('evento_id')->references('id')->on('eventos');
        });

        Schema::table('sesiones_cliente', function (Blueprint $table) {
            $table->foreign('cliente_id')->references('usuario_id')->on('clientes');
            $table->foreign('kangoo_id')->references('id')->on('kangoos');
            $table->foreign('sesion_evento_id')->references('id')->on('sesiones_evento');
        });

        Schema::table('kangoo_partes', function (Blueprint $table) {
            $table->foreign('parte_id')->references('id')->on('partes');
            $table->foreign('kangoo_id')->references('id')->on('kangoos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            $table->dropColumn('usuario_id');
        });

        Schema::table('entrenadores', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            $table->dropColumn('usuario_id');
            //$table->dropForeign(['banco']);//TODO
        });

        Schema::table('horarios_solicitud_servicio', function (Blueprint $table) {
            $table->dropForeign(['solicitud_servicio_id']);
            $table->dropColumn('solicitud_servicio_id');
            $table->dropForeign(['usuario_cancelacion']);
            $table->dropColumn('usuario_cancelacion');
        });

        Schema::table('logros_alcanzados', function (Blueprint $table) {
            $table->dropForeign(['logro_id']);
            $table->dropForeign(['usuario_id']);
            $table->dropColumn('usuario_id');
            $table->dropColumn('logro_id');
        });

        Schema::table('ofrecimientos', function (Blueprint $table) {
            $table->dropForeign(['solicitud_servicio_id']);
            $table->dropForeign(['usuario_id']);
            $table->dropColumn('usuario_id');
            $table->dropColumn('solicitud_servicio_id');
        });

        Schema::table('pesos', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            $table->dropColumn('usuario_id');
        });

        Schema::table('estaturas', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            $table->dropColumn('usuario_id');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            $table->dropForeign(['reviewer_id']);
            $table->dropColumn('usuario_id');
            $table->dropColumn('reviewer_id');
        });

        Schema::table('solicitudes_servicio', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            $table->dropForeign(['oferta_aceptada']);
            $table->dropColumn('usuario_id');
            $table->dropColumn('oferta_aceptada');
        });

        Schema::table('tags_solicitud_servicio', function (Blueprint $table) {
            $table->dropForeign(['tag_id']);
            $table->dropForeign(['solicitud_servicio_id']);
            $table->dropColumn('tag_id');
            $table->dropColumn('solicitud_servicio_id');
        });

        Schema::table('tags_entrenador', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            $table->dropForeign(['tag_id']);
            $table->dropColumn('usuario_id');
            $table->dropColumn('tag_id');
        });

        Schema::table('tutoriales_realizados', function (Blueprint $table) {
            $table->dropForeign(['tutorial_id']);
            $table->dropForeign(['usuario_id']);
            $table->dropColumn(['tutorial_id']);
            $table->dropColumn(['usuario_id']);
        });

        Schema::table('programacion_solicitud_servicio', function (Blueprint $table) {
            $table->dropForeign(['solicitud_servicio_id']);
            $table->dropColumn('solicitud_servicio_id');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            $table->dropColumn('usuario_id');
        });

        Schema::table('comentarios', function (Blueprint $table) {
            $table->dropForeign(['blog_id']);
            $table->dropColumn('blog_id');
            $table->dropForeign(['reply_id']);
            $table->dropColumn('reply_id');
        });

        Schema::table('sesiones_evento', function (Blueprint $table) {
            $table->dropForeign(['evento_id']);
            $table->dropColumn('evento_id');
        });

        Schema::table('sesiones_cliente', function (Blueprint $table) {
            $table->dropForeign(['cliente_id']);
            $table->dropColumn('cliente_id');
            $table->dropForeign(['kangoo_id']);
            $table->dropColumn('kangoo_id');
            $table->dropForeign(['sesion_evento_id']);
            $table->dropColumn('sesion_evento_id');
        });

        Schema::table('kangoo_partes', function (Blueprint $table) {
            $table->dropForeign(['parte_id']);
            $table->dropColumn('parte_id');
            $table->dropForeign(['kangoo_id']);
            $table->dropColumn('kangoo_id');
        });

        Schema::table('transacciones_pagos', function (Blueprint $table) {
            $table->dropForeign(['cliente_id']);
            $table->dropColumn('cliente_id');
            $table->dropForeign(['sesion_evento_id']);
            $table->dropColumn('sesion_evento_id');
        });

        Schema::table('transacciones_pendientes', function (Blueprint $table) {
            $table->dropForeign(['id_transaccion']);
            $table->dropColumn('id_transaccion');
        });
    }
}
