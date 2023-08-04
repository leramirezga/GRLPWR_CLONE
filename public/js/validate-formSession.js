/*!

 =========================================================
 * Material Bootstrap Wizard - v1.0.2
 =========================================================
 
 * Product Page: https://www.creative-tim.com/product/material-bootstrap-wizard
 * Copyright 2017 Creative Tim (http://www.creative-tim.com)
 * Licensed under MIT (https://github.com/creativetimofficial/material-bootstrap-wizard/blob/master/LICENSE.md)
 
 =========================================================
 
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 */
var $validator;
$(document).ready(function(){
    // Code for the Validator
    $validator = $('.wizard-card form').validate({
        rules: {
            cantidadSesiones:{
                required: true,
            },
            name: {
                required: true,
            },
            place: {
                required: true,
            },
            fechaInicio: {
                required: true,
            },
            fechaFin: {
                required: true,
            },
            horaInicio:{
                required: true,
            },
            horaFin:{
                required: true,
            },
            horaInicioLunes:{
                required: true,
            },
            horaFinLunes:{
                required: true,
            },
            horaInicioMartes:{
                required: true,
            },
            horaFinMartes:{
                required: true,
            },
            horaInicioMiércoles:{
                required: true,
            },
            horaFinMiércoles:{
                required: true,
            },
            horaInicioJueves:{
                required: true,
            },
            horaFinJueves:{
                required: true,
            },
            horaInicioViernes:{
                required: true,
            },
            horaFinViernes:{
                required: true,
            },
            horaInicioSábado:{
                required: true,
            },
            horaFinSabado:{
                required: true,
            },
            horaInicioDomingo:{
                required: true,
            },
            horaFinDomingo:{
                required: true,
            },
            quotas: {
                required: true,
            },
            price: {
                required: true,
            },
        },
        messages: {
            radio: "This is a required field"
        },

        errorPlacement: function(error, element) {
            $(element).parent('div').addClass('has-error');
        }
    });

});

