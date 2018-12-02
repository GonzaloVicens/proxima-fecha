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
    })

    var ancho = $('.d-inline-block.fondoHeader2.rounded-circle.ml-3.escudoequipo img.rounded-circle').css('width');
    $('.d-inline-block.fondoHeader2.rounded-circle.ml-3.escudoequipo img.rounded-circle').css('height', ancho);

    $(window).resize(function(){
        var ancho = $('.d-inline-block.fondoHeader2.rounded-circle.ml-3.escudoequipo img.rounded-circle').css('width');
        $('.d-inline-block.fondoHeader2.rounded-circle.ml-3.escudoequipo img.rounded-circle').css('height', ancho);
    });

    $('.usuario div div.hover-camera.rounded-circle').click(function () {

        $('#modal_cambiar_fotoperfil').modal();

    });

    $('#modal_cambiar_fotoperfil .cancelar').click(function () {

        $('#modal_cambiar_fotoperfil').modal('hide');

    });

    $('.editar-mis-datos #edit_pass').click(function () {

        $('.editar-mis-datos .edit-pass-field').toggleClass('d-none');

    });


    $('.editar-mis-datos #cambiar-foto-perfil').click(function () {

        $('.editar-mis-datos #cambiar-foto-perfil-input').click();

    });

});