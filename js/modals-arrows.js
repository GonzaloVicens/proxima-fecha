$(document).ready(function(){

    $('#agregar_equipo').click(function () {

        $('#modal_agregar_equipo').modal();

    });

    $('#modal_agregar_equipo .cancelar').click(function () {

        $('#modal_agregar_equipo').modal('hide');

    });

    $('#cambiar_fotoportada').click(function () {

        $('#modal_cambiar_fotoportada').modal();

    });

    $('#modal_cambiar_fotoportada .cancelar').click(function () {

        $('#modal_cambiar_fotoportada').modal('hide');

    });

    $('#buscar').click(function () {

        $('#modal_buscar').modal();

    });

    $('#modal_buscar .cancelar').click(function () {

        $('#modal_buscar').modal('hide');

    });

    $('#eliminar_torneo').click(function () {

        $('#modal_eliminar_torneo').modal();

    });

    $('#modal_eliminar_torneo .cancelar').click(function () {

        $('#modal_eliminar_torneo').modal('hide');

    });

    $('.faq .btn.btn-link.faq-link').on('click', function () {

        if($(this).hasClass('arrowdown')) {
            $(this).toggleClass('arrowdown')
        } else {
            $('.faq .btn.btn-link.faq-link').removeClass('arrowdown');
            $(this).toggleClass('arrowdown');
        }


            //$('.faq .btn.btn-link.faq-link').removeClass('arrowdown');

            //var test = $(this).hasClass('arrowdown');
    })

});