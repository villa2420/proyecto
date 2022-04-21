<?php

//Incluimos inicialmete la conexion a la base de datos
require '../config/Conexion.php';

class Usuario {

    //Implementamos nuestro constructor
    public function __construct() {
        //se deja vacio para implementar instancias hacia esta clase
        //sin enviar parametro
    }

    //Implementamos un metodo para insertar registros
    public function insertar($nombre, $tipo_documento, $num_documento, $direccion,
            $telefono, $email, $cargo, $login, $clave, $imagen, $permisos) {

        //no se inserta el idcategoria por que es autoincremental
        //no se interta la condicion ya que por defecto es 1

        $sql = "INSERT INTO usuario (nombre, tipo_documento, num_documento, direccion, telefono, email, cargo, login, clave, imagen, condicion) VALUES "
                . "('$nombre', '$tipo_documento', '$num_documento', '$direccion', '$telefono', '$email', '$cargo', '$login', '$clave', '$imagen','1')";

        //return ejecutarConsulta($sql);

        $idusuarionew = ejecutarConsulta_retornarID($sql);

        //guardar los permisos
        //cantidad de permisos seleccionados
        $num_elementos = 0;
        //estado de la insercion del permiso
        $sw = true;

        while ($num_elementos < count($permisos)) {

            $sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) "
                    . "VALUES ('$idusuarionew', '$permisos[$num_elementos]')";

            //Si se ejecuta de manera correcta devuelve true, de lo contrario
            //se actualiza la variable sw a false.
            ejecutarConsulta($sql_detalle) or $sw = false;

            $num_elementos = $num_elementos + 1;
        }

        return $sw;
    }

    //Implementamos un metodo para editar registros
    public function editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion,
            $telefono, $email, $cargo, $login, $clave, $imagen, $permisos) {

        if ($clave == "") {

            $sql = "UPDATE usuario SET nombre='$nombre', tipo_documento='$tipo_documento', num_documento='$num_documento', "
                    . "direccion='$direccion', telefono='$telefono', email='$email', cargo='$cargo', login='$login', "
                    . "imagen='$imagen'  WHERE idusuario ='$idusuario'";
        } else {

            $sql = "UPDATE usuario SET nombre='$nombre', tipo_documento='$tipo_documento', num_documento='$num_documento', "
                    . "direccion='$direccion', telefono='$telefono', email='$email', cargo='$cargo', login='$login', "
                    . "clave='$clave', imagen='$imagen'  WHERE idusuario ='$idusuario'";
        }


        ejecutarConsulta($sql);

        //Se eliminan todos los permisos asignados, para volverlos a registrar
        $sqldel = "DELETE FROM usuario_permiso WHERE idusuario = '$idusuario'";
        ejecutarConsulta($sqldel);

        //inserto los permisos nuevamente
        //guardar los permisos
        //cantidad de permisos seleccionados
        $num_elementos = 0;
        //estado de la insercion del permiso
        $sw = true;

        while ($num_elementos < count($permisos)) {

            $sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) "
                    . "VALUES ('$idusuario', '$permisos[$num_elementos]')";

            //Si se ejecuta de manera correcta devuelve true, de lo contrario
            //se actualiza la variable sw a false.
            ejecutarConsulta($sql_detalle) or $sw = false;

            $num_elementos = $num_elementos + 1;
        }

        return $sw;
    }

    //Implementamos un metodo para desactivar los usuarios
    public function desactivar($idusuario) {

        $sql = "UPDATE usuario SET condicion ='0' WHERE idusuario ='$idusuario'";

        return ejecutarConsulta($sql);
    }

    //Implementamos un metodo para activar las categorias
    public function activar($idusuario) {

        $sql = "UPDATE usuario SET condicion ='1' WHERE idusuario ='$idusuario'";

        return ejecutarConsulta($sql);
    }

    //Implementar un metodo para mostrar los datos de un registro a modificar
    public function mostrar($idusuario) {

        $sql = "SELECT * FROM usuario WHERE idusuario= '$idusuario'";

        return ejecutarConsultaSimpleFila($sql);
    }

    //Implementar un metodo para listar los registros
    public function listar() {

        $sql = "SELECT * FROM usuario";

        return ejecutarConsulta($sql);
    }

    //Implementar un metodo para listar los permisos marcados
    public function listarMarcados($idusuario) {

        $sql = "SELECT * FROM usuario_permiso WHERE idusuario = '$idusuario'";

        return ejecutarConsulta($sql);
    }

    //funcion para verificar el acceso al sistema
    public function verificar($login, $clave) {

        $sql = "SELECT idusuario, nombre, tipo_documento, num_documento, "
                . "telefono, email, cargo, imagen, login FROM usuario WHERE "
                . "login = '$login' AND clave = '$clave' AND condicion = '1'";

        return ejecutarConsulta($sql);
    }

}
