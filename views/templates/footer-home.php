<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 21/10/2018
 * Time: 04:20 PM
 */

use Proyecto\Core\App;

?>
<footer class="fondoFooter pt-5">
    <div class="container-fluid pb-4">
        <div class="row text-white">
            <div class="col-md-3 text-center">
                <img src="<?= App::$urlPath;?>/img/LOGOPF-Sin-Fondo.png" class="logoHeader mr-3">
            </div>
            <div class="col-md-2">
                <p class="h5 mb-3">Organizadores</p>
                <ul class="list-unstyled fontSize14">
                    <li class="mb-3"><a href="<?= App::$urlPath;?>/preguntas-frecuentes" class="text-white">Organizar un Torneo</a></li>
                    <li class="mb-3"><a href="<?= App::$urlPath;?>/contacto" class="text-white">Contacto</a></li>
                    <li class="mb-3"><a href="<?= App::$urlPath;?>/registrarse" class="text-white">Registrarme</a></li>
                    <li class="mb-3"><a href="#" class="text-white">Ingresar</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <p class="h5 mb-3">Jugadores</p>
                <ul class="list-unstyled fontSize14">
                    <li class="mb-3"><a href="#" class="text-white">Buscar Campeonato</a></li>
                    <li class="mb-3"><a href="<?= App::$urlPath;?>/contacto" class="text-white">Contacto</a></li>
                    <li class="mb-3"><a href="<?= App::$urlPath;?>/registrarse" class="text-white">Registrarme</a></li>
                    <li class="mb-3"><a href="#" class="text-white">Ingresar</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <p class="h5 mb-3">Preguntas Frecuentes</p>
                <ul class="list-unstyled fontSize14">
                    <li class="mb-3"><a href="<?= App::$urlPath;?>/preguntas-frecuentes" class="text-white">¿Es necesario hacerme un usuario?</a></li>
                    <li class="mb-3"><a href="<?= App::$urlPath;?>/preguntas-frecuentes" class="text-white">¿Es gratis el servicio?</a></li>
                    <li class="mb-3"><a href="<?= App::$urlPath;?>/preguntas-frecuentes" class="text-white">¿Que tipos de torneo puedo organizar?</a></li>
                    <li class="mb-3"><a href="<?= App::$urlPath;?>/preguntas-frecuentes" class="text-white">¿Puedo organizar un campeonato siendo jugador de otro?</a></li>
                    <li class="mb-3"><a href="<?= App::$urlPath;?>/preguntas-frecuentes" class="text-white">¿Cuántos campeonatos puedo organizar?</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <p>Redes Sociales</p>
                <ul class="list-unstyled d-flex">
                    <li class="mr-4"><a href="https://www.facebook.com/proximafecha.ar/"><img src="<?= App::$urlPath;?>/img/fb_naranja.png" alt="facebook icon"></a></li>
                    <li><a href="https://twitter.com/proximafecha"><img src="<?= App::$urlPath;?>/img/twitter.png" alt="twitter icon"></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="basefooter">
    </div>
</footer>
<!-- debajo hay una ventana modal, se puede usar si se necesita, descomentándola -->
<!--div class="modal fade bd-example-modal-lg" id='modalregistrarse' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title">Registrarse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Usuario</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Elige tu usuario">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nombre</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Elige tu usuario">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Apellido</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Elige tu usuario">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingrese su email">
                                    <!--small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Confirmar Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <!--div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div-->
</body>
<script src="<?= App::$urlPath;?>/js/jquery-3.3.1.min.js"></script>
<script src="<?= App::$urlPath;?>/js/login-form.js"></script>
<script src="<?= App::$urlPath;?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= App::$urlPath;?>/js/modals-arrows.js"></script>
</html>
