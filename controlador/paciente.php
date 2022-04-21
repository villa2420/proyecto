<?php

require_once '../modelos/Paciente.php';

$persona = new Paciente();

$idpersona = isset($_POST["idpersona"]) ? limpiarCadena($_POST["idpersona"]) : "";
$tipo_documento_id = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$numero_documento = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]) : "";
$nombre1         = isset($_POST["primer_nombre"]) ? limpiarCadena($_POST["primer_nombre"]) : "";
$nombre2         = isset($_POST["segundo_nombre"]) ? limpiarCadena($_POST["segundo_nombre"]) : "";
$apellido1       = isset($_POST["primer_apellido"]) ? limpiarCadena($_POST["primer_apellido"]) : "";
$apellido2       = isset($_POST["segundo_apellido"]) ? limpiarCadena($_POST["segundo_apellido"]) : "";
$genero_id       = isset($_POST["tipo_genero"]) ? limpiarCadena($_POST["tipo_genero"]) : "";
$departamento_id = isset($_POST["depto"]) ? limpiarCadena($_POST["depto"]) : "";
$municipio_id    = isset($_POST["municipio"]) ? limpiarCadena($_POST["municipio"]) : "";

//envio de operaciones por medio de peticiones ajax
switch ($_GET["op"]) {
    case 'guardaryeditar':

        if (empty($idpersona)) {

            $rspta = $persona->insertar($tipo_documento_id, $numero_documento, $nombre1, $nombre2, $apellido1, $apellido2, $genero_id, $departamento_id, $municipio_id);
            echo $rspta ? "Paciente registrado" : "Paciente no se pudo registrar";
        } else {

            $rspta = $persona->editar($tipo_documento_id, $numero_documento, $nombre1, $nombre2, $apellido1, $apellido2, $genero_id, $departamento_id, $municipio_id, $idpersona);
            echo $rspta ? "Paciente actualizado" : "Paciente no se pudo actualizar";
        }
        break;

    case 'eliminar':

        $rspta = $persona->eliminar($idpersona);
        echo $rspta ? "Paciente desactivada" : "Paciente no se puede desactivar";
        break;

    case 'activar':

        $rspta = $persona->activar($idpersona);
        echo $rspta ? "Paciente activado" : "Paciente no se puede activar";
        break;

    case 'mostrar':

        $rspta = $persona->mostrar($idpersona);
        //codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    //listado de los clientes
    case 'listarp':

        $rspta = $persona->listarp();
        //vamos a declarar un array
        $data = Array();

        while ($reg = $rspta->fetch_object()) {

            $data[] = array(
                "0" => ($reg->condicion) ? '<button class="btn btn-warning" onclick="mostrar(' . $reg->id . ')"> <i class="fa fa-pencil"></i> </button>' .
                ' <button class="btn btn-danger" onclick="eliminar(' . $reg->id . ')"> <i class="fa fa-close"></i> </button>' : '<button class="btn btn-warning" onclick="mostrar(' . $reg->id . ')"> <i class="fa fa-pencil"></i> </button>' .
                ' <button class="btn btn-primary" onclick="activar(' . $reg->id . ')"> <i class="fa fa-check"></i> </button>',
                "1" => $reg->tipo_doc,
                "2" => $reg->numero_documento,
                "3" => $reg->nombre,
                "4" => $reg->sexo,
                "5" => $reg->departamento,
                "6" => $reg->municipio,
                "7" => ($reg->condicion == 1) ? '<span class="label bg-green">Activo</span>' : '<span class="label bg-red">Inactivo</span>'
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

    case 'selectDocumento':

        $rspta = $persona->tip_documento();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->id . '>' . $reg->nombre . '</option>';
        }
        break;

    case 'selectGenero':

        $rspta = $persona->genero();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->id . '>' . $reg->nombre . '</option>';
        }
        break;

    case 'selectDepartamento':

        $rspta = $persona->departamento();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->id . '>' . $reg->nombre . '</option>';
        }
        break;

    case 'cargar_municipios':

        $rspta = $persona->cargar_municipios($_REQUEST["id_departamento"]);
        //$rspta = $persona->cargar_municipios(1);

        $data = Array();

        while ($reg = $rspta->fetch_object()) {

            $data[] = array(
                "id" => $reg->id,
                "nombre" => $reg->nombre,
            );
        }

        echo json_encode($data);

        break;
}