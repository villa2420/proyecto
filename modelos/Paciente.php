<?php

//Incluimos inicialmete la conexion a la base de datos
require '../config/Conexion.php';

class Paciente {

    //Implementamos nuestro constructor
    public function __construct() {
        //se deja vacio para implementar instancias hacia esta clase
        //sin enviar parametro
    }

    //Implementamos un metodo para insertar registros
    public function insertar($tipo_documento_id, $numero_documento, $nombre1, $nombre2, $apellido1, $apellido2,
            $genero_id, $departamento_id, $municipio_id) {

        //no se inserta el idpersona por que es autoincremental
        $sql = "INSERT INTO paciente (tipo_documento_id, numero_documento, nombre1, nombre2, apellido1, apellido2, genero_id, departamento_id, municipio_id, condicion) "
                . "VALUES ('$tipo_documento_id', '$numero_documento', '$nombre1', '$nombre2', '$apellido1', '$apellido2', '$genero_id', '$departamento_id', '$municipio_id', 1)";

        return ejecutarConsulta($sql);
    }

    //Implementamos un metodo para editar registros
    public function editar($tipo_documento_id, $numero_documento, $nombre1, $nombre2, $apellido1, $apellido2,
            $genero_id, $departamento_id, $municipio_id, $idpersona) {

        $sql = "UPDATE paciente SET tipo_documento_id='$tipo_documento_id', numero_documento='$numero_documento', nombre1='$nombre1', "
                . "nombre2='$nombre2', apellido1='$apellido1', apellido2='$apellido2', genero_id='$genero_id', "
                . "departamento_id='$departamento_id', municipio_id='$municipio_id' WHERE id ='$idpersona'";
        

        return ejecutarConsulta($sql);
    }

    //Implementamos un metodo para eliminar las personas
    public function eliminar($idpersona) {

        $sql = "UPDATE paciente SET condicion = 0 WHERE id ='$idpersona'";

        return ejecutarConsulta($sql);
    }

    //Implementamos un metodo para activar las personas
    public function activar($idpersona) {

        $sql = "UPDATE paciente SET condicion = 1 WHERE id ='$idpersona'";

        return ejecutarConsulta($sql);
    }

    //Implementar un metodo para mostrar los datos de un registro a modificar
    public function mostrar($idpersona) {

        $sql = "SELECT * FROM paciente WHERE id= '$idpersona'";

        return ejecutarConsultaSimpleFila($sql);
    }

    /**
     * Metodo que lista todos los pacientes
     * @return boolean
     */
    public function listarp() {

        $sql = "SELECT P.id, TD.nombre tipo_doc, P.numero_documento, CONCAT(P.nombre1, ' ' ,P.nombre2, ' ' ,P.apellido1, ' ' ,P.apellido2) nombre, "
                . "G.nombre sexo, "
                . "D.nombre departamento, M.nombre municipio, P.condicion FROM paciente P "
                . "INNER JOIN tipos_documento TD ON TD.id = P.tipo_documento_id  "
                . "INNER JOIN genero G ON G.id = P.genero_id "
                . "INNER JOIN departamentos D ON D.id = P.departamento_id "
                . "INNER JOIN municipios M ON M.id = P.municipio_id AND D.id = M.departamento_id";

        return ejecutarConsulta($sql);
    }

    //Implementar un metodo para mostrar los tipos de documento
    public function tip_documento() {

        $sql = "SELECT 0 id, 'SELECCIONE' nombre "
                . "UNION "
                . "SELECT id, nombre FROM tipos_documento";

        return ejecutarConsulta($sql);
    }

    //Implementar un metodo para mostrar los sexos
    public function genero() {

        $sql = "SELECT 0 id, 'SELECCIONE' nombre "
                . "UNION "
                . "SELECT id, nombre FROM genero";

        return ejecutarConsulta($sql);
    }

    //Implementar un metodo para mostrar los departamentos
    public function departamento() {

        $sql = "SELECT 0 id, 'SELECCIONE' nombre "
                . "UNION "
                . "SELECT id, nombre FROM departamentos";

        return ejecutarConsulta($sql);
    }

    //Implementamos un metodo para cargar los municipios de un departamento
    public function cargar_municipios($iddepto) {

        $sql = "SELECT * FROM municipios WHERE departamento_id = '$iddepto'";

        return ejecutarConsulta($sql);
    }

}

//$a = new Paciente();
//$z = $a->cargar_municipios('1');
//$z->fetch_object(); 
//var_dump($z);

  //  while ($reg = $z->fetch_object()) {

    //       echo $reg->nombre;
      //  }
