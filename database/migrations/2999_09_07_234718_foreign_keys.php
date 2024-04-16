<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->foreign('reviewer_id')->references('id')->on('usuarios');
        });

        Schema::table('reviews_user', function (Blueprint $table) {
            $table->foreign('review_id')->references('id')->on('reviews');
            $table->foreign('user_id')->references('id')->on('usuarios');
        });

        Schema::table('reviews_session', function (Blueprint $table) {
            $table->foreign('review_id')->references('id')->on('reviews');
            $table->foreign('session_id')->references('id')->on('sesiones_cliente');
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
            $table->foreign('user_id')->references('id')->on('usuarios');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
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

        Schema::table('edited_events', function (Blueprint $table) {
            $table->foreign('evento_id')->references('id')->on('eventos');
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('class_type_id')->references('id')->on('class_types');
        });

        Schema::table('eventos', function (Blueprint $table) {
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('class_type_id')->references('id')->on('class_types');
        });

        Schema::table('event_hours', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('eventos');
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->foreign('branch_id')->references('id')->on('branches');
        });

        Schema::table('plan_classes', function (Blueprint $table) {
            $table->foreign('class_type_id')->references('id')->on('class_types');
            $table->foreign('plan_id')->references('id')->on('plans');
        });

        Schema::table('remaining_classes', function (Blueprint $table) {
            $table->foreign('class_type_id')->references('id')->on('class_types');
            $table->foreign('client_plan_id')->references('id')->on('client_plans');
        });

        Schema::table('plan_benefits', function (Blueprint $table) {
            $table->foreign('plan_id')->references('id')->on('plans');
        });

        Schema::table('sesiones_cliente', function (Blueprint $table) {
            $table->foreign('cliente_id')->references('usuario_id')->on('clientes');
            $table->foreign('kangoo_id')->references('id')->on('kangoos');
            $table->foreign('evento_id')->references('id')->on('eventos');
        });

        Schema::table('kangoo_partes', function (Blueprint $table) {
            $table->foreign('parte_id')->references('id')->on('partes');
            $table->foreign('kangoo_id')->references('id')->on('kangoos');
        });

        Schema::table('client_plans', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('usuarios');//This client id points to user table to allow a user buy a plan even if he/she has not completed profile
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->foreign('payment_id')->references('id')->on('transacciones_pagos');
        });

        Schema::table('anthropometries', function (Blueprint $table) {
            $table->foreign('client_id')->references('usuario_id')->on('clientes');
        });
        Schema::table('cardiovascular_risks', function (Blueprint $table) {
            $table->foreign('client_id')->references('usuario_id')->on('clientes');
        });
        Schema::table('max_heart_rates', function (Blueprint $table) {
            $table->foreign('client_id')->references('usuario_id')->on('clientes');
        });
        Schema::table('fitness_components', function (Blueprint $table) {
            $table->foreign('client_id')->references('usuario_id')->on('clientes');
        });
        Schema::table('exercise_prescriptions', function (Blueprint $table) {
            $table->foreign('client_id')->references('usuario_id')->on('clientes');
        });
        Schema::table('nutrition_and_health', function (Blueprint $table) {
            $table->foreign('client_id')->references('usuario_id')->on('clientes');
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
            $table->dropForeign(['reviewer_id']);
            $table->dropColumn('reviewer_id');
        });

        Schema::table('reviews_user', function (Blueprint $table) {
            $table->dropForeign(['review_id']);
            $table->dropColumn('review_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('reviews_session', function (Blueprint $table) {
            $table->dropForeign(['review_id']);
            $table->dropColumn('review_id');
            $table->dropForeign(['session_id']);
            $table->dropColumn('session_id');
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

        Schema::table('edited_events', function (Blueprint $table) {
            $table->dropForeign(['evento_id', 'branch_id', 'class_type_id']);
            $table->dropColumn('evento_id');
            $table->dropColumn('branch_id');
            $table->dropColumn('class_type_id');
        });

        Schema::table('eventos', function (Blueprint $table) {
            $table->dropForeign(['branch_id', 'class_type_id']);
            $table->dropColumn('branch_id');
            $table->dropColumn('class_type_id');
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        Schema::table('plan_classes', function (Blueprint $table) {
            $table->dropForeign(['class_type_id', 'plan_id']);
            $table->dropColumn('class_type_id');
            $table->dropColumn('plan_id');
        });

        Schema::table('plan_benefits', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropColumn('plan_id');
        });

        Schema::table('remaining_classes', function (Blueprint $table) {
            $table->dropForeign(['class_type_id', 'plan_id']);
            $table->dropColumn('class_type_id');
            $table->dropColumn('plan_id');
        });

        Schema::table('event_hours', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });

        Schema::table('sesiones_cliente', function (Blueprint $table) {
            $table->dropForeign(['cliente_id']);
            $table->dropColumn('cliente_id');
            $table->dropForeign(['kangoo_id']);
            $table->dropColumn('kangoo_id');
            $table->dropForeign(['evento_id']);
            $table->dropColumn('evento_id');
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
            $table->dropForeign(['payment_method_id']);
            $table->dropColumn('payment_method_id');
        });

        Schema::table('transacciones_pendientes', function (Blueprint $table) {
            $table->dropForeign(['id_transaccion']);
            $table->dropColumn('id_transaccion');
        });

        Schema::table('client_plans', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('plan_id');
            $table->dropForeign(['payment_id']);
            $table->dropColumn('payment_id');
        });
        Schema::table('anthropometries', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
        Schema::table('cardiovascular_risks', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
        Schema::table('max_heart_rates', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
        Schema::table('fitness_components', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
        Schema::table('exercise_prescriptions', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
        Schema::table('nutrition_and_health', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }
}
