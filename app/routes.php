<?php
// Este archivo va a definir TODAS las rutas/urls de la app.
// Es importante ya que con el .htaccess hicimos que todas las urls redireccionen al index.php

use Proyecto\Core\Route;

Route::addRoute('GET' , '/'                                    , 'HomeController@index');
Route::addRoute('POST', '/'                                    , 'UsuarioController@loguear');
Route::addRoute('GET' , '/desloguear'                          , 'UsuarioController@desloguear');
Route::addRoute('GET' , '/usuarios/notificaciones'             , 'UsuarioController@notificaciones');
Route::addRoute('GET' , '/usuarios/{usuario_id}'               , 'UsuarioController@ver');
Route::addRoute('POST', '/usuarios/agregarMensaje'             , 'UsuarioController@agregarMensaje');
Route::addRoute('POST', '/usuarios/crear-equipo'               , 'EquipoController@registrar');
Route::addRoute('GET' , '/usuarios/crear-torneo'               , 'UsuarioController@verCrearTorneo');
Route::addRoute('GET' , '/usuarios/editar-mis-datos'           , 'UsuarioController@editarUsuario');
Route::addRoute('GET' , '/usuarios/editar-torneo'              , 'TorneoController@editarTorneo');
Route::addRoute('POST', '/usuarios/editar-torneo'              , 'TorneoController@actualizar');
Route::addRoute('GET' , '/usuarios/notificaciones'             , 'UsuarioController@notificaciones');
Route::addRoute('POST', '/usuarios/registrar'                  , 'UsuarioController@registrar');
Route::addRoute('GET' , '/equipos/{equipo_id}'                 , 'EquipoController@ver');
Route::addRoute('POST', '/equipos/agregar-jugador'             , 'EquipoController@agregarJugador');
Route::addRoute('GET' , '/equipos'                             , 'EquipoController@verEquipos');
Route::addRoute('GET' , '/torneos/{torneo_id}'                 , 'TorneoController@ver');
Route::addRoute('GET' , '/ver-proxima-fecha'                   , 'TorneoController@verProximaFecha');
Route::addRoute('GET' , '/ver-fixture-completo'                , 'TorneoController@verFixtureCompleto');
Route::addRoute('GET' , '/agregar-equipos'                     , 'TorneoController@agregarEquipos');
Route::addRoute('GET' , '/preguntas-frecuentes'                , 'HomeController@preguntasFrecuentes');
Route::addRoute('GET' , '/registrarse'                         , 'HomeController@registrarse');
Route::addRoute('GET' , '/error404'                            , 'HomeController@error404');
Route::addRoute('GET' , '/mensajes/{usuario_id}/{contacto_id}' , 'UsuarioController@mostrarMensajes');
Route::addRoute('GET' , '/{sarasa}'                            , 'HomeController@error404');



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