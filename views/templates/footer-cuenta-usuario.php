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
                    <li class="mb-2"><a href="#" class="text-muted">Gratuidad del Serivicio</a></li>
                    <li class="mb-2"><a href="#" class="text-muted">¿Es necesario hacerme un usuario?</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <ul class="list-unstyled fontSize14">
                    <li class="mb-2"><a href="#" class="text-muted">¿Que tipos de torneo puedo organizar?</a></li>
                    <li class="mb-2"><a href="#" class="text-muted">¿Cuántos campeonatos puedo organizar?</a></li>
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
            <form>
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
                                    <input type="text" class="form-control" id="InputNombreEquipo" aria-describedby="emailHelp" placeholder="Elige el nombre de tu equipo">
                                </div>
                                <div class="form-group">
                                    <label for="InputEscudo">Escudo</label>
                                    <input type="file" class="form-control" id="InputEscudo" placeholder="Elige tu escudo">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!--button type="submit" class="btn btn-primary">Submit</button-->
                    <!--button-- type="submit" class="btn btn-primary">Crear Equipo</button-->
                    <button type="button" class="btn btn-success">Crear Equipo</button>
                    <!--button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button-->
                    <button type="button" class="btn btn-secondary">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script src="<?= App::$urlPath;?>/js/jquery-3.3.1.min.js"></script>
<script src="<?= App::$urlPath;?>/bootstrap/js/bootstrap.min.js"></script>
<script>

    $('#agregar_equipo').click(function () {

        $('#modal_agregar_equipo').modal();

    })

</script>
</html>
