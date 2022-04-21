<?php
//activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {

    header("Location: login.php");
} else {

    require './header.php';

    if ($_SESSION["pacientes"] == 1) {
        ?>

        <!--Contenido-->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h1 class="box-title">Paciente
                                    <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>
                                </h1>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <!-- centro -->
                            <div class="panel-body table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                    <th>Opciones</th>
                                    <th>Tip_documento</th>
                                    <th>Documento</th>
                                    <th>Nombres</th>
                                    <th>Sexo</th>
                                    <th>Departamento</th>
                                    <th>Municipio</th>
                                    <th>Estado</th>
                                    </thead>

                                    <tbody>

                                    </tbody>

                                    <tfoot>
                                    <th>Opciones</th>
                                    <th>Tip_documento</th>
                                    <th>Documento</th>
                                    <th>Nombres</th>
                                    <th>Sexo</th>
                                    <th>Departamento</th>
                                    <th>Municipio</th>
                                    <th>Estado</th>
                                    </tfoot>
                                </table>
                            </div>


                            <div class="panel-body" style="height: 500px;" id="formularioregistros">
                                <form name="formulario" id="formulario" method="POST">

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Tipo Documento:</label>
                                        <input type="hidden" name="idpersona" id="idpersona">   
                                        <select id="tipo_documento" name="tipo_documento" class="form-control selectpicker" data-live-search="true" required>

                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Número Documento:</label>
                                        <input type="number" name="num_documento" class="form-control" id="num_documento" maxlength="20" placeholder="Documento" required>   
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Primer Nombre:</label>
                                        <input type="text" name="primer_nombre" class="form-control" id="primer_nombre" maxlength="100" placeholder="Primer Nombre" required>   
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Segundo Nombre:</label>
                                        <input type="text" name="segundo_nombre" class="form-control" id="segundo_nombre" maxlength="100" placeholder="Segundo Nombre" required>   
                                    </div>


                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Primer Apellido:</label>
                                        <input type="text" name="primer_apellido" class="form-control" id="primer_apellido" maxlength="100" placeholder="Primer Apellido" required>   
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Segundo Apellido:</label>
                                        <input type="text" name="segundo_apellido" class="form-control" id="segundo_apellido" maxlength="100" placeholder="segundo Apellido" required>   
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Sexo:</label>
                                        <select id="tipo_genero" name="tipo_genero" class="form-control selectpicker" data-live-search="true" required>

                                        </select>   
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Departamento:</label>
                                        <select id="depto" name="depto" class="form-control selectpicker" data-live-search="true" onchange="cargar_municipios()" required>

                                        </select>    
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Municipio:</label>
                                        <select id="municipio" name="municipio" class="form-control selectpicker"  data-live-search="true" required>
                                            <option value="0">SELECCIONE</option>
                                        </select>   
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button class="btn btn-primary" type="button" id="btnGuardar" onclick="guardaryeditar()">
                                            <i class="fa fa-save"></i> 
                                            Guardar
                                        </button>

                                        <button class="btn btn-danger" type="button" onclick="cancelarform()">
                                            <i class="fa fa-arrow-circle-left"></i> 
                                            Cancelar
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!--Fin centro -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->

        </div><!-- /.content-wrapper -->
        <!--Fin-Contenido-->

        <?php
    } else {

        require 'noacceso.php';
    }

    require './footer.php';
    ?>

    <script type="text/javascript" src="scripts/paciente.js?=<?php echo $_SESSION['version_sistema']; ?>"></script>

    <?php
}
//termina el buffer
ob_end_flush();

