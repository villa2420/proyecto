<?php

//Incluimos inicialmete la conexion a la base de datos
require '../config/Conexion.php';

class Permiso {

    //Implementamos nuestro constructor
    public function __construct() {
        //se deja vacio para implementar instancias hacia esta clase
        //sin enviar parametro
    }

    //implementar un metodo para listar los registros
    public function listar() {

        $sql = "SELECT * FROM permiso";

        return ejecutarConsulta($sql);
    }

}
