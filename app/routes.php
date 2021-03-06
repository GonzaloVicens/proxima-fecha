<?php
// Este archivo va a definir TODAS las rutas/urls de la app.
// Es importante ya que con el .htaccess hicimos que todas las urls redireccionen al index.php

use Proyecto\Core\Route;

Route::addRoute('GET' , '/'                                                    , 'HomeController@index');
Route::addRoute('POST', '/'                                                    , 'UsuarioController@loguear');
Route::addRoute('POST', '/buscar'                                              , 'HomeController@buscar');
Route::addRoute('GET' , '/adminPF'                                             , 'AdminController@login');
Route::addRoute('POST', '/adminPF'                                             , 'AdminController@loguear');
Route::addRoute('GET' , '/adminPF/home'                                        , 'AdminController@verHome');
Route::addRoute('GET' , '/adminPF/desloguear'                                  , 'AdminController@desloguear');
Route::addRoute('GET' , '/adminPF/desactivar-usuario/{usuario_id}'             , 'AdminController@desactivarUsuario');
Route::addRoute('GET' , '/adminPF/activar-usuario/{usuario_id}'                , 'AdminController@activarUsuario');
Route::addRoute('GET' , '/adminPF/desactivar-equipo/{equipo_id}'               , 'AdminController@desactivarEquipo');
Route::addRoute('GET' , '/adminPF/activar-equipo/{equipo_id}'                  , 'AdminController@activarEquipo');
Route::addRoute('POST', '/adminPF/buscar-equipo'                               , 'AdminController@buscarEquipo');
Route::addRoute('POST', '/adminPF/buscar-usuario'                              , 'AdminController@buscarUsuario');
Route::addRoute('GET' , '/desloguear'                                          , 'UsuarioController@desloguear');
Route::addRoute('GET' , '/usuarios/notificaciones'                             , 'UsuarioController@notificaciones');
Route::addRoute('GET' , '/usuarios/{usuario_id}'                               , 'UsuarioController@ver');
Route::addRoute('POST', '/usuarios/agregarMensaje'                             , 'UsuarioController@agregarMensaje');
Route::addRoute('POST', '/usuarios/crear-equipo'                               , 'EquipoController@registrar');
Route::addRoute('GET' , '/usuarios/crear-torneo'                               , 'UsuarioController@verCrearTorneo');
Route::addRoute('POST', '/usuarios/crear-torneo'                               , 'TorneoController@registrar');
Route::addRoute('GET' , '/usuarios/editar-datos'                               , 'UsuarioController@verEditarUsuario');
Route::addRoute('POST', '/usuarios/editar-datos'                               , 'UsuarioController@editarUsuario');
Route::addRoute('POST', '/usuarios/actualizarFotoPerfil'                       , 'UsuarioController@actualizarFotoPerfil');
Route::addRoute('GET' , '/usuarios/notificaciones'                             , 'UsuarioController@notificaciones');
Route::addRoute('GET' , '/usuarios/mensajes'                                   , 'UsuarioController@mensajes');
Route::addRoute('POST', '/usuarios/registrar'                                  , 'UsuarioController@registrar');
Route::addRoute('POST', '/usuarios/recuperar-password'                         , 'UsuarioController@recuperarPassword');
Route::addRoute('GET',  '/usuarios/pasar-a-cuenta-pro'                         , 'UsuarioController@cuentaPro');
Route::addRoute('GET' , '/equipos/{equipo_id}'                                 , 'EquipoController@ver');
Route::addRoute('POST', '/equipos/agregar-jugador'                             , 'EquipoController@agregarJugador');
Route::addRoute('POST', '/equipos/eliminar-equipo'                             , 'EquipoController@eliminarEquipo');
Route::addRoute('GET' , '/equipos'                                             , 'EquipoController@verEquipos');
Route::addRoute('GET' , '/torneos/editar-torneo'                               , 'TorneoController@editarTorneo');
Route::addRoute('POST', '/torneos/editar-torneo'                               , 'TorneoController@actualizarTorneo');
Route::addRoute('GET' , '/torneos/editar-organizadores'                        , 'TorneoController@editarOrganizadores');
Route::addRoute('POST' , '/torneos/editar-organizador'                          , 'TorneoController@editarOrganizador');
Route::addRoute('POST', '/torneos/agregar-organizador'                         , 'TorneoController@agregarOrganizador');
Route::addRoute('POST', '/torneos/solicitar-inscripcion'                       , 'TorneoController@solicitarInscripcion');
Route::addRoute('POST', '/torneos/agregar-inscripcion'                         , 'TorneoController@agregarInscripcion');
Route::addRoute('POST', '/torneos/eliminar-inscripcion'                        , 'TorneoController@eliminarInscripcion');
Route::addRoute('GET' , '/torneos/agregar-equipos'                             , 'TorneoController@verAgregarEquipos');
Route::addRoute('POST', '/torneos/agregar-equipo'                              , 'TorneoController@agregarEquipo');
Route::addRoute('POST', '/torneos/eliminar-equipo'                             , 'TorneoController@eliminarEquipo');
Route::addRoute('POST', '/torneos/buscar-equipo'                               , 'TorneoController@buscarEquipo');
Route::addRoute('POST', '/torneos/eliminar-torneo'                             , 'TorneoController@eliminar');
Route::addRoute('GET' , '/torneos/comenzar-torneo'                             , 'TorneoController@comenzarTorneo');
Route::addRoute('GET' , '/torneos/finalizar-partido'                           , 'TorneoController@finalizarPartido');
Route::addRoute('GET' , '/torneos/finalizar-torneo'                            , 'TorneoController@finalizarTorneo');
Route::addRoute('GET' , '/torneos/reiniciar-torneo'                            , 'TorneoController@reiniciarTorneo');
Route::addRoute('GET' , '/torneos/generar-fixture'                             , 'TorneoController@generarFixture');
Route::addRoute('GET' , '/torneos/ver-fixture-completo/{torneo}'               , 'TorneoController@verFixtureCompleto');
Route::addRoute('GET' , '/torneos/ver-fixture-torneo-completo'                 , 'TorneoController@verFixtureTorneoCompleto');
Route::addRoute('GET' , '/torneos/{torneo_id}'                                 , 'TorneoController@ver');
Route::addRoute('POST', '/torneos/{torneo}/{fase}/agregar-ficha-partido'       , 'TorneoController@agregarFichaPartido');
Route::addRoute('GET' , '/torneos/{torneo}/{fase}/{partido}'                   , 'TorneoController@verPartido');
Route::addRoute('GET' , '/torneos/{torneo}/{fase}'                             , 'TorneoController@verFase');
Route::addRoute('GET' , '/ver-proxima-fecha'                                   , 'TorneoController@verProximaFecha');
Route::addRoute('GET' , '/usuarios/crear-sede'                                 , 'UsuarioController@verCrearSede');
Route::addRoute('POST', '/usuarios/crear-sede'                                 , 'SedeController@registrar');
Route::addRoute('GET' , '/sedes/editar-sede'                                   , 'SedeController@editarSede');
Route::addRoute('POST', '/sedes/editar-sede'                                   , 'SedeController@actualizar');
Route::addRoute('GET' , '/sedes/{sede_id}'                                     , 'SedeController@ver');
Route::addRoute('GET' , '/sedes/editar-sede'                                   , 'SedeController@editarsede');
Route::addRoute('POST', '/sedes/editar-sede'                                   , 'SedeController@actualizar');
Route::addRoute('GET' , '/sedes/editar-duenos'                                 , 'SedeController@editarduenos');
Route::addRoute('POST', '/sedes/agregar-dueno'                                 , 'SedeController@agregardueno');
Route::addRoute('POST', '/sedes/editar-dueno'                                  , 'SedeController@editardueno');
Route::addRoute('POST', '/sedes/agregar-cancha'                                , 'SedeController@agregarCancha');
Route::addRoute('POST', '/sedes/eliminar-cancha'                               , 'SedeController@eliminarCancha');
Route::addRoute('POST', '/sedes/buscar-cancha'                                 , 'SedeController@buscarcancha');
Route::addRoute('POST', '/sedes/eliminar-sede'                                 , 'SedeController@eliminar');
Route::addRoute('GET' , '/sedes/habilitar-sede'                                , 'SedeController@habilitarsede');
Route::addRoute('GET' , '/sedes/deshabilitar-sede'                             , 'SedeController@deshabilitarsede');
Route::addRoute('GET' , '/contacto'                                            , 'HomeController@contacto');
Route::addRoute('POST', '/contacto'                                            , 'HomeController@contactoEnviar');
Route::addRoute('GET' , '/preguntas-frecuentes'                                , 'HomeController@preguntasFrecuentes');
Route::addRoute('GET' , '/terminos-y-condiciones-de-uso'                       , 'HomeController@terminosYCondiciones');
Route::addRoute('GET' , '/registrarse'                                         , 'HomeController@registrarse');
Route::addRoute('GET' , '/recuperar-password'                                  , 'HomeController@verRecuperarPassword');
Route::addRoute('GET' , '/error404'                                            , 'HomeController@error404');
Route::addRoute('GET' , '/mensajes/{usuario_id}/{contacto_id}'                 , 'UsuarioController@mostrarMensajes');
Route::addRoute('GET' , '/{sarasa}'                                            , 'HomeController@index');
Route::addRoute('GET' , '/{sarasa}/{sarasa}'                                   , 'HomeController@error404');
Route::addRoute('GET' , '/{sarasa}/{sarasa}/{sarasa}'                          , 'HomeController@error404');



/**


Route::addRoute('GET', '/about', 'MainController@about');
/*Route::addRoute('GET', '/blog', 'MainController@blog');

Route::addRoute('GET', '/ayuda', 'MainController@ayuda');
Route::addRoute('GET', '/contacto', 'MainController@contacto');
Route::addRoute('POST', '/contacto', 'MainController@enviarMail');
Route::addRoute('POST', '/ver-alimento', 'MainController@traerAlimento');
Route::addRoute('POST', '/buscar-alimento', 'MainController@buscarAlimento');
Route::addRoute('POST', '/resultados-sugeridos', 'MainController@buscarOpciones');

Route::addRoute('POST', '/info-alimento/{id}', 'MainController@traerAlimento');

Route::addRoute('GET', '/blog/articulo/{id}', 'MainController@traerArticulo');
Route::addRoute('GET', '/blog/{id}', 'MainController@traerCincoArticulos');
Route::addRoute('GET', '/blog', 'MainController@traerUltimosCinco');

// Definimos las rutas
Route::addRoute('GET', '/login', 'LoginController@index');
Route::addRoute('POST', '/login', 'LoginController@autenticar');

Route::addRoute('GET', '/abm', 'ABMController@index');

Route::addRoute('GET', '/abm/salir', 'ABMController@cerrarSesion');
Route::addRoute('GET', '/abm/abm_alimentos', 'ABMController@abmAlimentos');
Route::addRoute('GET', '/abm/abm_articulos', 'ABMController@abmArticulos');
Route::addRoute('POST', '/abm/abm_articulos', 'ABMController@abmArticulosPost');

Route::addRoute('POST', '/abm/abm_articulos/insertar', 'ABMController@insertarArticulo');
Route::addRoute('GET', '/abm/abm_alimentos/insertar-alimento', 'ABMController@insertarAlimento');
Route::addRoute('POST', '/abm/abm_alimentos/insertar-alimento', 'ABMController@insertarAlimentoPost');

Route::addRoute('POST', '/abm/abm_articulos/editar', 'ABMController@editarArticulo');

Route::addRoute('POST', '/abm/abm_articulos/previa', 'ABMController@previsualizarArticulo');

Route::addRoute('POST', '/abm/abm_articulos/previa-edit', 'ABMController@previsualizarArticuloEditado');

Route::addRoute('POST', '/abm/abm_articulos/ver-eliminar', 'ABMController@verArticuloEliminarPost');
Route::addRoute('POST', '/abm/abm_alimentos/ver-eliminar', 'ABMController@verAlimentoEliminarPost');

//Route::addRoute('GET', '/abm/abm_articulos/{id}/editar', 'ABMController@verArticuloEditar');
Route::addRoute('POST', '/abm/abm_articulos/ver-editar', 'ABMController@verArticuloEditar');

Route::addRoute('POST', '/abm/abm_alimentos/ver-editar', 'ABMController@verAlimentoEditar');
Route::addRoute('POST', '/abm/abm_alimentos/editar-alimento', 'ABMController@editarAlimento');


Route::addRoute('POST', '/abm/abm_articulos/volver-a-editar', 'ABMController@verArticuloEditarPost');

//Route::addRoute('GET', '/abm/abm_articulos/{id}/eliminar', 'ABMController@eliminarArticulo');
Route::addRoute('POST', '/abm/abm_articulos/eliminar', 'ABMController@eliminarArticuloPost');
Route::addRoute('POST', '/abm/abm_alimentos/eliminar', 'ABMController@eliminarAlimentoPost');

 */