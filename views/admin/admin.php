        <div>
            <div id="nav">
                <ul>
                    <li><a href="index.php?c=equipos">Equipos</a></li>
                    <li><a href="index.php?c=usuarios">Usuarios</a></li>
                    <li><a href="php/cerrar.sesion.php">Cerrar Sesión</a></li>
                </ul>
            </div>

            <?php
            $cat = isset( $_GET['c'] ) ? $_GET['c'] : 'prod';
            switch( $cat ){
                case 'equipos': include('modulos/equipos.listado.php'); break;
                case 'usuarios': include('modulos/usuarios.listado.php'); break;
                default:  include('modulos/equipos.listado.php'); break;
            }
            ?>

        </div>
