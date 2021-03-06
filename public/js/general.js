$(document).ready(function() {

    $('.modal').on('shown.bs.modal', function() {//que los modales no pierdan el autofocus
        $(this).find('[autofocus]').focus();
    });

    $(".flash-message").fadeTo(2000, 500).slideUp(500, function(){//las alerta de exito se autoocultan
        $(".flash-message").slideUp(500);
    });
});




