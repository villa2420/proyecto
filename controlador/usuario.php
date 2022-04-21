<?php

session_start();

require_once '../modelos/Usuario.php';

$usuario = new Usuario();

$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$num_documento = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$cargo = isset($_POST["cargo"]) ? limpiarCadena($_POST["cargo"]) : "";
$login = isset($_POST["login"]) ? limpiarCadena($_POST["login"]) : "";
$clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

//envio de operaciones por medio de peticiones ajax
switch ($_GET["op"]) {
    case 'guardaryeditar':

        //valido el formato de la imagen antes de guardar y/o este cargado
        if (!file_exists($_FILES["imagen"]["tmp_name"]) || !is_uploaded_file($_FILES["imagen"]["tmp_name"])) {

            $imagen = $_POST["imagenactual"];
        } else {

            $ext = explode(".", $_FILES["imagen"]["name"]);

            if ($_FILES["imagen"]["type"] == "image/jpg" || $_FILES["imagen"]["type"] == "image/jpeg" || $_FILES["imagen"]["type"] == "image/png") {

                //renombro la imagen para que no se repita el nombre
                $imagen = round(microtime(true)) . '.' . end($ext);

                //muevo el archivo a la ubicacion dispuesta
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
            }
        }


        if ($clave == "") {

            //Hash SHA256 en la contraseña
            $clavehash = "";
        } else {

            //Hash SHA256 en la contraseña
            $clavehash = hash("SHA256", $clave);
        }

        if (empty($idusuario)) {

            $rspta = $usuario->insertar($nombre, $tipo_documento, $num_documento, $direccion,
                    $telefono, $email, $cargo, $login, $clavehash, $imagen, $_POST['permiso']);
            echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
        } else {


            $rspta = $usuario->editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion,
                    $telefono, $email, $cargo, $login, $clavehash, $imagen, $_POST['permiso']);
            echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
        }
        break;

    case 'desactivar':

        $rspta = $usuario->desactivar($idusuario);
        echo $rspta ? "Usuario desactivado" : "Usuario no se puede desactivar";
        break;

    case 'activar':

        $rspta = $usuario->activar($idusuario);
        echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
        break;

    case 'mostrar':

        $rspta = $usuario->mostrar($idusuario);
        //codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'listar':

        $rspta = $usuario->listar();
        //vamos a declarar un array
        $data = Array();

        while ($reg = $rspta->fetch_object()) {

            $data[] = array(
                "0" => ($reg->condicion) ? '<button class="btn btn-warning" onclick="mostrar(' . $reg->idusuario . ')"> <i class="fa fa-pencil"></i> </button>' .
                ' <button class="btn btn-danger" onclick="desactivar(' . $reg->idusuario . ')"> <i class="fa fa-close"></i> </button>' : '<button class="btn btn-warning" onclick="mostrar(' . $reg->idusuario . ')"> <i class="fa fa-pencil"></i> </button>' .
                ' <button class="btn btn-primary" onclick="activar(' . $reg->idusuario . ')"> <i class="fa fa-check"></i> </button>',
                "1" => $reg->nombre,
                "2" => $reg->tipo_documento,
                "3" => $reg->num_documento,
                "4" => $reg->telefono,
                "5" => $reg->email,
                "6" => $reg->login,
                "7" => "<img src='../files/usuarios/" . $reg->imagen . "' height='50px' width='50px'>",
                "8" => ($reg->condicion) ? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
            );
        }

        $results = array(
            "sEcho" => 1, //Informacion para el datatables
            "iTotalRecords" => count($data), //Enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data), //Enviamos el total de registros a visualizar
            "aaData" => $data
        );

        echo json_encode($results);
        break;

    case 'permisos':
        //Obtenemos todos los permisos de la tabla permisos
        require_once "../modelos/Permiso.php";
        $permiso = new Permiso();
        $rspta = $permiso->listar();

        //obtener los permisos asignados al usuario
        $id = $_GET['id'];
        $marcados = $usuario->listarMarcados($id);
        //se declara un array que guardara los permisos del usuario
        $valores = array();

        //almacenar los permisos asignados en un array
        while ($per = $marcados->fetch_object()) {

            array_push($valores, $per->idpermiso);
        }

        //Mostramos la lista de permisos en la vista y si están o no marcados
        while ($reg = $rspta->fetch_object()) {

            //in_array, busca que un valor este dentro de un arreglo
            $sw = in_array($reg->idpermiso, $valores) ? 'checked' : '';

            echo '<li> <input type="checkbox" ' . $sw . ' name="permiso[]" value="' . $reg->idpermiso . '"> ' . $reg->nombre . '</li>';
        }
        break;

    //login de usuario
    case 'verificar':

        $logina = $_POST["logina"];
        $clavea = $_POST["clavea"];

        //Hash SHA256 en la contraseña
        $clavehash = hash("SHA256", $clavea);

        $rspta = $usuario->verificar($logina, $clavehash);

        $fetch = $rspta->fetch_object();

        if (isset($fetch)) {

            $_SESSION['idusuario'] = $fetch->idusuario;
            $_SESSION['nombre'] = $fetch->nombre;
            $_SESSION['imagen'] = $fetch->imagen;
            $_SESSION['login'] = $fetch->login;
            $_SESSION['cargo'] = $fetch->cargo;
            $_SESSION['version_sistema'] = microtime();

            //obtenemos los permisos del usuario
            $marcados = $usuario->listarMarcados($fetch->idusuario);

            //declaramos un array para almacenar todos los permisos marcados
            $valores = array();

            //almacenamos los permisos marcados en el array valores
            while ($per = $marcados->fetch_object()) {

                array_push($valores, $per->idpermiso);
            }

            //determinamos los accesos del usuario, con in_array se busca que el valor 
            //buscado este en los permisos obtenidos
            in_array(1, $valores) ? $_SESSION["escritorio"] = 1 : $_SESSION["escritorio"] = 0;
            in_array(4, $valores) ? $_SESSION["pacientes"] = 1 : $_SESSION["pacientes"] = 0;
            in_array(5, $valores) ? $_SESSION["acceso"] = 1 : $_SESSION["acceso"] = 0;
            
        }

        echo json_encode($fetch);

        break;

    case 'salir':

        //limpiar las variables de sessison
        session_unset();

        //destruir la session
        session_destroy();

        //redireccion al login
        header("Location: ../index.php");

        break;
}