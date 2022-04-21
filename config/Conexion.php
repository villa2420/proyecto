<?php

require_once 'global.php';

$conexion = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

mysqli_query($conexion, 'SET NAMES "' . DB_ENCODE . '"');

//si tenemos un posible error en la conexion mostramos
if (mysqli_connect_errno()) {

    printf("Fallo la conexion a la base de datos: %s\n", mysqli_connect_error());
    exit();
}


//si no existe la funcion de consulta, la definimos
if (!function_exists('ejecutarConsulta')) {

    function ejecutarConsulta($sql) {

        global $conexion;
        $query = $conexion->query($sql);
        return $query;
    }

    //retorna en una fila el resultado de una consulta
    function ejecutarConsultaSimpleFila($sql) {

        global $conexion;
        $query = $conexion->query($sql);
        $row = $query->fetch_assoc();
        return $row;
    }

    //inserta un registro por id
    function ejecutarConsulta_retornarID($sql) {

        global $conexion;
        $query = $conexion->query($sql);
        return $conexion->insert_id;
    }

    //limpia caracteres especiales antes de consultar
    function limpiarCadena($str) {

        global $conexion;
        $str = mysqli_real_escape_string($conexion, trim($str));
        return htmlspecialchars($str);
    }

}