<?php
use Proyecto\Core\App;
use Proyecto\Session\Session;

if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')=='S') {
    $usuarioLogueado = true;
}else{
    $usuarioLogueado = false;
}

if (! $usuarioLogueado ){
    if (Session::has("errorAdmin")){
        $errorAdmin = Session::get("errorAdmin");
        Session::clearValue("errorAdmin");
    };
?>
<main class="py-4 mb-4 admin">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6 mx-auto">
                <h2 class="mt-5 mb-4 pfgreen text-center h4"><i class="fas fa-lock text-muted fontSize1-4rem mr-2"></i> Admin Próxima Fecha</h2>
                <div id='usuario' class="border rounded shadow px-3 pt-2 pb-5">
                    <form id='usr' method='POST' action='<?= App::$urlPath;?>/adminPF'>
                        <div class="form-group m-4">
                            <label for='user' class="mt-1"><i class="fas fa-user text-muted mr-2"></i><span class="">Usuario</span></label>
                            <input id='user' type='text' name='usuario' placeholder="Usuario" class="form-control">
                        </div>
                        <div class="form-group m-4">
                            <label for='pass' class="mt-1"><i class="fas fa-lock text-muted mr-2"></i><span class="">Password</span></label>
                            <input id ='pass' type='password' name='password' placeholder="Password" class="form-control">
                        </div>
                        <div class="form-group m-4">
                                <input type='submit' value='Ingresar' id='login_btn' class="form-control btn btn-secondary">
                        </div>
                        <?php
                        if (! $usuarioLogueado && isset($errorAdmin)) {
                            echo("<div class='DivErrores text-center'>");
                            echo("    <p style='color:#F00'>" . ucfirst($errorAdmin) . "</p>");
                            echo("</div>");
                        }
                        }
                        ?>
                    </form>
                </div>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
</main>

