<?php
/**
 * Created by PhpStorm.
 * User: c.hernandez
 * Date: 11/1/2018
 * Time: 8:27 AM
 */

namespace App\Utils;

class Constantes {

    //USER
    const ROL_ENTRENADOR = 'entrenador';

    //MENSAJES
    const MENSAJE_ENTRENAMIENTO_YA_CANCELADO = 'El entrenamiento ya no estaba agendado. Posiblemente había sido cancelado o se realizó una reclamación';
    const MENSAJE_CANCELACION_TARDIA = 'Ha pasado el tiempo válido para cancelar. Puedes finalizar el entrenamiento o hacer una reclamación';
    const MENSAJE_CANCELACION_EXITOSA = 'EL entrenamiento ha sido cancelado.';
    const MENSAJE_ACTUALIZACION_PERFIL_EXITOSA = 'Tu perfil ahora está actualizado, VAMOS A ENTRENAR!';
    const MENSAJE_PAGINA_NO_DISPONIBLE = 'Algo ha cambiado y la página ya no está disponible';
    const MENSAJE_ESTADO_INCORRECTO_EDITAR_OFERTA = 'La solicitud ya fue contratada o fue eliminada por lo que no es posible editar la oferta';
    const MENSAJE_ESTADO_INCORRECTO_ELIMINAR_OFERTA = 'La solicitud ya fue contratada o fue eliminada por lo que no es posible eliminar la oferta';
    const MENSAJE_ESTADO_INCORRECTO_CONFIRMAR_OFERTA = 'La solicitud ya fue contratada o fue eliminada por lo que no es posible confirmar la oferta';
    const MENSAJE_ESTADO_INCORRECTO_VER_OFERTA = 'La solicitud ya fue contratada o fue eliminada, no podemos llevarte a la página que buscas';
    const MENSAJE_PROPUESTA_ACTUALIZADA = 'Tu propuesta fue actualizada!';
    const MENSAJE_PROPUESTA_PUBLICADA = 'Felicidades tu propuesta fue publicada!';
    const MENSAJE_PROPUESTA_DUPLICADA = 'Ya tienes una oferta creada, no puedes crear más';

    //HORARIOS_SOLICITUD_SERVICIO;
    const HORARIOS_SOLICITUD_SERVICIO_ESTADO_ACTIVO = 0;
    const HORARIOS_SOLICITUD_SERVICIO_ESTADO_CANCELADO = 4;

    //REVIEW
    const REVIEW_COMPLETAR_PERFIL = 'Felicitaciones de parte del equipo de Girl Power por haber completado tu perfil.';
    const REVIE_COMPLETAR_PERFIL_CLIENTE = 'Esperamos ayudarte a cumplir tus metas, a empoderarte, sentirte segura, hacer amigas y disfrutar de este Movimiento Conciente. Recuerda que para lograr tus objetivos hay que ser constantes. A ENTRENAR!';
    const REVIE_COMPLETAR_PERFIL_ENTRENADOR = 'Bienvenido a esta gran familia. Queremos que ayudes a todos nuestros atletas a cumplir sus metas, siempre siendo un gran profesional. Vamos a buscar atletas!';

    //SOLICITUD DE SERVICIO
    const UNICA_SESION = 0;
    const VARIAS_SESIONES = 1;
    const SOLICITUD_SERVICIO_ESTADO_ACTIVO = 0;
    const SOLICITUD_SERVICIO_ESTADO_MODIFICADA = 5;
    const SOLICITUD_SERVICIO_ESTADO_CONTRATADA = 1;

    //BLOG
    const BLOG_TIPO_BLOG = 0;
    const BLOG_TIPO_VIDEO = 1;
}