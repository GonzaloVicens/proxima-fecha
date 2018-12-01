<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;
use Proyecto\Session\Session;

if (Session::has('torneo')){
    $torneo = Session::get('torneo');
}
?>
<main class="py-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <h2 class="mt-5 mb-4 pfgreen">Editar <span class="font-weight-normal">Torneo o Liga</span></h2>
                <form>
                    <div class="form-group">
                       <label for="nombre">Nombre Torneo / Liga</label>
                        <!-- dejo los valores de value vacío para cargar con la info traída de la base de datos -->
                       <input type="text" class="form-control" id="nombre" placeholder="Nombre del torneo" value="">
                    </div>
                    <div class="form-group">
                       <label for="deporte">Deporte</label>
                        <!-- se coloca atributo selected a elemento option de acuerdo al que esté indicado en base -->
                       <select name="deporte" class="form-control">
                           <option value="1">Futbol</option>
                           <option value="2">Básquet</option>
                           <option value="3">Tenis</option>
                           <option value="4">Voley</option>
                           <option value="5">Hockey</option>
                           <option value="6">Handball</option>
                       </select>
                    </div>
                    <div class="form-group">
                        <label>Tipo de Competición</label><br>
                        <!-- marcar con opción selected -->
                         <div>
                            <input type="radio" name='tipo' value='t' id="torneo"> <label for="torneo">Torneo</label>
                         </div>
                        <div>
                            <input type="radio" name='tipo' value='l' id="liga"> <label for="liga">Liga</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad Equipos</label>
                        <input type="text" name='cantidad' class="form-control" id="cantidad" value="">
                    </div>
                    <div class="form-group">
                        <label for="fechainicio">Fecha de Inicio</label>
                        <input type="text" name='fechainicio' class="form-control" id="fechainicio" value="">
                    </div>
                    <div class="form-group">
                        <!-- este campo no sería obligatorio - y no revisé en el DER si existe este dato, si no existe sacar este bloque -->
                        <label for="fechafinalizacion">Fecha Finalización</label>
                        <input type="text" name='fechafinalizacion' class="form-control" id="fechafinalizacion"  value="">
                    </div>
                    <button type="submit" class="btn btn-lg btn-outline-success">Enviar</button>
                    <!--button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button-->
                </form>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
</main>

