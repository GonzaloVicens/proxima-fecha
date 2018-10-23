<?php

namespace Proyecto\Controllers;

use Proyecto\Core\App;
use Proyecto\Core\Route;
use Proyecto\Model\Categoria;
use Proyecto\Model\Porcion;
use Proyecto\Model\Categoriaalimento;
use Proyecto\Model\Usuario;
use Proyecto\Model\Articulo;
use Proyecto\Model\Alimento;
use Proyecto\View\View;
use Proyecto\Auth\Autenticar;
use Proyecto\Session\Session;
use Proyecto\Exceptions\ErrorListarException;
use Proyecto\Exceptions\ErrorEliminarException;
use Proyecto\Exceptions\ErrorIngresoException;
use Proyecto\Exceptions\ErrorEdicionException;

/**
 * Class HomeController
 * @package Proyecto\Controllers
 *
 */
class ABMController
{

    public function index()
    {

        View::render('web/abm2');

    }

     public function registro()
    {

        View::render('login/registro2');

    }


    public function abmAlimentos()
    {


        try{

            $alimentos = Alimento::listarTodo();

        } catch (ErrorListarException $e){

            $msg = $e->getMessage();

            View::render('web/abm-error', [
                'msg' => $msg
            ]);
        }

        View::render('web/abm_alimentos', [
            'alimentos' => $alimentos
        ]);



        //View::render('web/abm_alimentos', [
          //  'alimentos' => $alimentos
        //]);

    }

    public function abmArticulos()
    {

        $articulos = Articulo::traerTodos();

        View::render('web/abm_articulos', [
            'articulos' => $articulos
        ]);


        //View::render('web/abm_articulos');

    }

    public function abmArticulosPost()
    {

        $articulos = Articulo::traerTodos();

        View::render('web/abm_articulos', [
            'articulos' => $articulos
        ]);


        //View::render('web/abm_articulos');

    }

    public function insertarAlimento()
    {

        $porciones = Porcion::listarTodo();
        $categorias = Categoriaalimento::listarTodo();

        View::render('web/insertar-alimento', [
            //'ali' => $ali,
            'porciones' => $porciones,
            'categorias' => $categorias
        ]);


        //View::render('web/insertar-alimento');

    }

    /**
     * Ingresa un nuevo Usuario a la base si los datos enviados cunplen con la validación
     *
     * De no pasar la validación devuelve al formulario de registro guardando los datos registrados por el usuairo.
     */

    public function crear_usuario()
    {
        // Obtenemos los datos de POST.
        $input = $_POST;
        $_SESSION['_data_'] = $_POST;

        // Validamos los datos enviados por $_POST
        $regresar = false;

        if ($input['usuario']=='') {
            $_SESSION['usuario_error'] = "Es obligatorio ingresar un nombre de usuario";
            $regresar = true;
        }

        if (!filter_var($input['mail'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['mail_error'] = "La dirección de correo <em>" . $input['mail'] . "</em> no es válida.";
            $regresar = true;
        }

        if ($input['nombre']=='') {
            $_SESSION['nombre_error'] = "Necesitamos que ingreses tu nombre";
            $regresar = true;
        }

        if ($input['apellido']=='') {
            $_SESSION['apellido_error'] = "Necesitamos que ingreses tu apellido";
            $regresar = true;
        }

        if ($input['sexo']=='') {
            $_SESSION['sexo_error'] = "Necesitamos saber tu sexo";
            $regresar = true;
        }

        if ($input['pais']=='') {
            $_SESSION['pais_error'] = "Necesitamos que ingreses tu pais";
            $regresar = true;
        }

        if ($input['password']=='') {
            $_SESSION['password_error'] = "Es obligatorio ingresar un password";
            $regresar = true;
        } else if ($input['password'] != $input['password2']) {
            $_SESSION['password_error'] = "Los passwords no coinciden. Por favor, confirme su password correctamente";
            $regresar = true;
        }

        if($regresar){

            $_SESSION['_input_'] = $_POST;

            View::render('login/registro2');

        } else {

            unset($input['password2']);

            Usuario::crear($input);

            header('Location: ' . App::$urlPath . '/login');

        }

    }

    public function autenticar()
    {

        if(Autenticar::login($_POST['USUARIO'], $_POST['PASSWORD'])){

            $_SESSION['NOMBRE'] = $_POST['USUARIO'];
            header('Location: ' . App::$urlPath . '/abm');
        } else {
            $_SESSION['_error'] = "Usuario y/o password incorrectos.";
            $_SESSION['_input'] = $_POST;
            header('Location: ' . App::$urlPath . '/login');

        }
    }

    public function cerrarSesion()
    {
        Session::destroy();
        header('Location: ' . App::$urlPath . '/login');
    }


    public function previsualizarArticulo()
    {

        $datos = $_POST;

        $artic = Articulo::armarPrevia($datos);

        View::render('web/ver-previa-articulo', [
            'artic' => $artic
            //'posteos' => $posteos
        ]);

    }


    public function previsualizarArticuloEditado()
    {

        $datos = $_POST;

        $artic = Articulo::armarPreviaEdit($datos);

        View::render('web/ver-previa-articulo-edit', [
            'artic' => $artic
        ]);

    }


    public function insertarArticulo()
    {

        $datos = $_POST;

        $nombrearchivo = explode('/', $datos['IMAGEN1']);

        $indicenombre = sizeof($nombrearchivo) - 1;

        $nombrearchivo = $nombrearchivo[$indicenombre];

        $ahora = date("YmdHis");
        //print_r($nombrearchivo);
        //echo "<br>";
        //print_r($indicenombre);
        //echo "<br>";

        $origen = App::$publicPath . '/uploads/' . $nombrearchivo;
        $destino = App::$publicPath . '/img/articulos/' . $nombrearchivo . $ahora;

       // print_r($origen);
        //echo "<br>";
        //print_r($destino);
        //echo "<br>";

        $test = rename($origen, $destino);

        //echo "Resultado move_upload_file: " . $test;

        //echo "<pre>";
        //print_r($origen);
        //echo "<br>";
        //echo sizeof($origen);
        //echo "</pre>";

        //die;

        $datos['IMAGEN1'] = '/img/articulos/'. $nombrearchivo;

        Articulo::insertarDatos($datos);

        $articulos = Articulo::traerTodos();

        View::render('web/abm_articulos', [
            'articulos' => $articulos
        ]);

        /*

        if($input['texto_comentario']==''){

            $posteos = Posteo::traerTodos();
            $msj = 'vacio';

            View::render('/sesion/index2', [
                'msj' => $msj,
                'posteos' => $posteos
            ]);
        } else {

            Comentario::crear($input);

            header('Location: ' . App::$urlPath . '/sesion');

        }*/
    }


    public function insertarAlimentoPost()
    {
        /*
        $datos = $_POST;

        Alimento::insertarDatos($datos);

        $alimentos = Alimento::listarTodo();

        View::render('web/abm_alimentos', [
            'alimentos' => $alimentos
        ]);

        */

        try{

            $datos = $_POST;

            Alimento::insertarDatos($datos);

            $alimentos = Alimento::listarTodo();

            View::render('web/abm_alimentos', [
                'alimentos' => $alimentos
            ]);


        } catch (ErrorIngresoException $e){

            $msg = $e->getMessage();

            View::render('web/abm-error', [
                'msg' => $msg
            ]);
        }


    }


    public function verArticuloEditar()
    {

        //$routeData = Route::getRouteParams();
        //$id = $routeData['id'];
        $id = $_POST['IDARTICULO'];
        $artic = Articulo::traerUno($id);

        //print_r($data);
        //die;

        //View::render('web/index');
        View::render('web/ver-articulo-editar', [
            'artic' => $artic
        ]);
        //echo '<pre>';
        //print_r($data);
        //echo '<pre>';
        //die;
    }


    public function verAlimentoEditar()
    {
        $id = $_POST['IDALIMENTO'];
        $ali = Alimento::traerUno($id);

        $porciones = Porcion::listarTodo();
        $categorias = Categoriaalimento::listarTodo();

        View::render('web/ver-alimento-editar', [
            'ali' => $ali,
            'porciones' => $porciones,
            'categorias' => $categorias
        ]);
    }


    public function editarAlimento()
    {

        /*
        $data = $_POST;
        $ali = Alimento::updateDatos($data);

        $alimentos = Alimento::listarTodo();

        View::render('web/abm_alimentos', [
            'alimentos' => $alimentos
        ]);

        */


        try{

            $data = $_POST;
            $ali = Alimento::updateDatos($data);

            $alimentos = Alimento::listarTodo();

            View::render('web/abm_alimentos', [
                'alimentos' => $alimentos
            ]);


        } catch (ErrorEdicionException $e){

            $msg = $e->getMessage();

            View::render('web/abm-error', [
                'msg' => $msg
            ]);
        }




    }





    public function verArticuloEliminarPost()
    {

        $id = $_POST['IDARTICULO'];

        //$artic = Articulo::armarPreviaEdit($datos); /// VER ESTO!!!!!!!
        $artic = Articulo::traerUno($id);

        View::render('web/ver-articulo-eliminar', [
            'artic' => $artic
            //'posteos' => $posteos
        ]);

    }

    //////////////////////////////////////////////////////////////////////////////////////////

    public function eliminarArticuloPost()
    {

        $id = $_POST['IDARTICULO'];
        $artic = Articulo::eliminarDatos($id);

        //print_r($data);
        //die;

        $articulos = Articulo::traerTodos();

        View::render('web/abm_articulos', [
            'articulos' => $articulos
        ]);
    }


    public function verArticuloEditarPost()
    {

        $datos = $_POST;

        $artic = Articulo::armarPreviaEdit($datos); /// VER ESTO!!!!!!!

        View::render('web/ver-articulo-editar', [
            'artic' => $artic
            //'posteos' => $posteos
        ]);

    }

    public function editarArticulo()
    {

        $datos = $_POST;

        //print_r($datos['IMAGEN1']);

        //die;

        $arrayimagen = explode('/', $datos['IMAGEN1']);

        $indicenombre = sizeof($arrayimagen) - 1;

        $nombrearchivo = $arrayimagen[$indicenombre];

        $averiguarorigen = sizeof($arrayimagen) - 2;

        $ahora = date("YmdHis");

        if($arrayimagen[$averiguarorigen] == 'uploads'){

            //
            $origen = App::$publicPath . '/uploads/' . $nombrearchivo;

            $destino = App::$publicPath . '/img/articulos/' . $nombrearchivo . $ahora;

            $test = rename($origen, $destino);

            //$datos['IMAGEN1'] = '/img/articulos/'. $nombrearchivo;

        } //else {
           // $datos['IMAGEN1'] = '/img/articulos/'. $nombrearchivo;
        //}

        $datos['IMAGEN1'] = '/img/articulos/'. $nombrearchivo;

        Articulo::editarDatos($datos);

        $articulos = Articulo::traerTodos();

        View::render('web/abm_articulos', [
            'articulos' => $articulos
        ]);

    }


    public function verAlimentoEliminarPost()
    {

        $id = $_POST['IDALIMENTO'];

        $ali = Alimento::traerUno($id);
        $porciones = Porcion::listarTodo();
        $categorias = Categoriaalimento::listarTodo();


        View::render('web/ver-alimento-eliminar', [
            'ali' => $ali,
            'porciones' => $porciones,
            'categorias' => $categorias
        ]);

    }

    public function eliminarAlimentoPost()
    {

        /*
        $id = $_POST['IDALIMENTO'];
        $ali = Alimento::eliminarDatos($id);

        $alimentos = Alimento::listarTodo();

        View::render('web/abm_alimentos', [
            'alimentos' => $alimentos
        ]);

        */

        try{

            $id = $_POST['IDALIMENTO'];
            $ali = Alimento::eliminarDatos($id);

            $alimentos = Alimento::listarTodo();

            View::render('web/abm_alimentos', [
                'alimentos' => $alimentos
            ]);

        } catch (ErrorEliminarException $e){

            $msg = $e->getMessage();

            View::render('web/abm-error', [
                'msg' => $msg
            ]);
        }


    }

}
