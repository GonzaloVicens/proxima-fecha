<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;
?>
<main class="py-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <h2 class="mt-5 mb-4 pfgreen">Registrarse</h2>
                <form>
                    <div class="form-group">
                       <label for="usuario">Usuario</label>
                       <input type="text" class="form-control" id="usuario" placeholder="Elige tu usuario">
                    </div>
                    <div class="form-group">
                       <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" aria-describedby="emailHelp" placeholder="Ingresá tu nombre">
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control" id="apellido"  placeholder="Ingresá tu apellido">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Tu dirección de e-mail">
                        <!--small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small-->
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Elige un Password">
                    </div>
                    <div class="form-group mb-4">
                        <label for="confirmarpassword">Confirmar Password</label>
                        <input type="password" class="form-control" id="confirmarpassword" placeholder="Confirmar Password">
                    </div>
                    <!--div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div-->
                    <button type="submit" class="btn btn-lg btn-outline-success">Crear Cuenta</button>
                    <!--button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button-->
                </form>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
</main>

