<?php

require_once '../modelos/Permiso.php';

$permiso = new Permiso();


//envio de operaciones por medio de peticiones ajax
switch ($_GET["op"]) {

    case 'listar':

        $rspta = $permiso->listar();

        //vamos a declarar un array
        $data = Array();

        while ($reg = $rspta->fetch_object()) {

            $data[] = array(
                "0" => $reg->nombre
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
}