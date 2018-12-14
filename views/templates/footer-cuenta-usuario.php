<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 21/10/2018
 * Time: 04:27 PM
 */

use Proyecto\Core\App;

?>

<footer class="mt-5 pt-4 pb-5 border-top">
    <div class="container pb-4">
        <div class="row text-muted">
            <div class="col-md-12">
                <p class="h6 mb-3">Preguntas Frecuentes</p>
            </div>
            <div class="col-md-4">
                <ul class="list-unstyled fontSize14">
                    <li class="mb-2"><a href="<?= App::$urlPath;?>/preguntas-frecuentes" class="text-muted">Gratuidad del Serivicio</a></li>
                    <li class="mb-2"><a href="<?= App::$urlPath;?>/preguntas-frecuentes" class="text-muted">¿Es necesario hacerme un usuario?</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <ul class="list-unstyled fontSize14">
                    <li class="mb-2"><a href="<?= App::$urlPath;?>/preguntas-frecuentes" class="text-muted">¿Que tipos de torneo puedo organizar?</a></li>
                    <li class="mb-2"><a href="<?= App::$urlPath;?>/preguntas-frecuentes" class="text-muted">¿Cuántos campeonatos puedo organizar?</a></li>
                </ul>
            </div>
            <div class="col-md-4 text-center">
                <img src="<?= App::$urlPath;?>/img/LOGOPF-Sin-Fondo.png" class="logoHeader mr-3">
            </div>

        </div>
    </div>
</footer>
<div class="modal fade bd-example-modal-lg" id='modal_agregar_equipo' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method='post' action='<?= App::$urlPath;?>/usuarios/crear-equipo' enctype="multipart/form-data">
                <div class="modal-header fondoHeader2 text-white">
                    <h5 class="modal-title">Crear Equipo</h5>
                    <button type="button" class="close  text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="InputNombreEquipo">Nombre Equipo</label>
                                    <input name="nombre" type="text" class="form-control" id="InputNombreEquipo" aria-describedby="emailHelp" placeholder="Elige el nombre de tu equipo">
                                </div>
                                <div class="form-group">
                                    <label for="InputEscudo">Escudo</label>
                                    <input type="file" class="form-control" name="foto" id="InputEscudo" placeholder="Elige tu escudo" accept="image/jpeg">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!--button type="submit" class="btn btn-primary">Submit</button-->
                    <!--button-- type="submit" class="btn btn-primary">Crear Equipo</button-->
                    <button type="submit" class="btn btn-success">Crear Equipo</button>
                    <!--button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button-->
                    <button type="button" class="btn btn-secondary cancelar">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id='modal_buscar' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header fondoHeader2 text-white">
                    <h5 class="modal-title">Buscar Equipos, Torneos, Usuarios</h5>
                    <button type="button" class="close  text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="modal-body my-3 pt-4 pb-5">
                                <label for="InputBuscar">Nombre a buscar:</label>
                                <div class="input-group">
                                    <input class="form-control py-2 border-right-0 border" type="text" placeholder="Buscar" id="InputBuscar">
                                    <span class="input-group-append">
                                        <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Buscar</button>
                    <button type="button" class="btn btn-secondary cancelar">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id='modal_cambiar_fotoportada' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header fondoHeader2 text-white">
                    <h5 class="modal-title">Actualizar foto de portada</h5>
                    <button type="button" class="close  text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="modal-body my-3 pt-4 pb-5">
                                <form>
                                    <label for="BuscarImagen">Buscar imagen:</label>
                                    <div class="input-group">
                                        <input class="py-2" type="file" id="BuscarImagen">
                                        <!--span class="input-group-append">
                                            <div class="input-group-text bg-transparent"><i class="fa fa-images"></i></div>
                                        </span-->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary cancelar">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- POR ALGUNA RA´ZON ESTÁ ACA?
<div class="modal fade bd-example-modal-lg" id='modal_eliminar_torneo' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="eliminar-torneo" method="post" >
                <input type="hidden" name="torneo_id" value=""/>
                <div class="modal-header fondoHeader2 text-white">
                    <h5 class="modal-title">Eliminar Torneo</h5>
                    <button type="button" class="close  text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="modal-body">
                                <p><strong>Está a un paso de eliminar este torneo</strong>. Tenga en cuenta que esta acción es irreversible y no podrá volver atrás.</p>
                                <div class="form-group">
                                    <label for="InputSiEliminar">Por favor para confirmar esta acción, escriba "SI" en el campo debajo:</label>
                                    <input type="text" name="confirmar" class="form-control" id="InputSiEliminar" maxlength="2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Eliminar Torneo</button>
                    <button type="button" class="btn btn-secondary cancelar">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
-->

<div class="modal fade bd-example-modal-lg" id='modal_cambiar_fotoperfil' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="actualizarFotoPerfil" method="post" enctype="multipart/form-data">
                <div class="modal-header fondoHeader2 text-white">
                    <h5 class="modal-title">Actualizar foto de perfil</h5>
                    <button type="button" class="close  text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="modal-body my-3 pt-4 pb-5">
                                <label for="BuscarImagen">Buscar imagen:</label>
                                <div class="input-group">
                                    <input class="py-2" type="file" id="BuscarImagen" name="foto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type='hidden' name='usuario_id' value='<?php echo $usuario->getUsuarioId() ?>'/>
                    <input type="submit" class="btn btn-primary" value="Guardar" />
                    <button type="button" class="btn btn-secondary cancelar">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
<script src="<?= App::$urlPath;?>/js/jquery-3.3.1.min.js"></script>
<script src="<?= App::$urlPath;?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= App::$urlPath;?>/js/modals-arrows.js"></script>
</html>
