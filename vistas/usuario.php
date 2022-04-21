<?php
//activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {

    header("Location: login.php");
} else {

    require './header.php';

    if ($_SESSION["acceso"] == 1) {
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
                                <h1 class="box-title">Usuario 
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
                                    <th>Nombre</th>
                                    <th>Documento</th>
                                    <th>Número</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Login</th>
                                    <th>Foto</th>
                                    <th>Estado</th>
                                    </thead>

                                    <tbody>

                                    </tbody>

                                    <tfoot>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Documento</th>
                                    <th>Número</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Login</th>
                                    <th>Foto</th>
                                    <th>Estado</th>
                                    </tfoot>
                                </table>
                            </div>


                            <div class="panel-body" id="formularioregistros">
                                <form name="formulario" id="formulario" method="POST">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label>Nombre(*):</label>
                                        <input type="hidden" name="idusuario" id="idusuario">
                                        <input type="text" name="nombre" class="form-control" id="nombre" maxlength="100" placeholder="Nombre" required>   
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Tipo Documento(*):</label>
                                        <select class="form-control selectpicker" name="tipo_documento" id="tipo_documento" data-live-search="true" required>  
                                            <option value="CC">CC</option>
                                            <option value="CE">CE</option>
                                            <option value="PA">PA</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Número(*):</label>
                                        <input type="number" name="num_documento" class="form-control" id="num_documento" maxlength="20" placeholder="Documento" required>   
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Dirección:</label>
                                        <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Dirección" maxlength="70">   
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Teléfono:</label>
                                        <input type="number" name="telefono" class="form-control" id="telefono" placeholder="Teléfono" maxlength="20">   
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Email:</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Email" maxlength="50">   
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Cargo:</label>
                                        <input type="text" name="cargo" class="form-control" id="cargo" placeholder="Cargo" maxlength="20">   
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Login(*):</label>
                                        <input type="text" name="login" class="form-control" id="login" placeholder="Login" maxlength="20" required>   
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Clave(*):</label>
                                        <input type="password" name="clave" class="form-control" id="clave" placeholder="Clave" maxlength="64">   
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Permisos:</label>
                                        <ul style="list-style: none;" id="permisos">

                                        </ul>
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Imagen:</label>
                                        <input type="file" name="imagen" class="form-control" id="imagen">   
                                        <input type="hidden" name="imagenactual" id="imagenactual">
                                        <img src="" width="150px" height="150px" id="imagenmuestra">
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button class="btn btn-primary" type="submit" id="btnGuardar">
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

    <script type="text/javascript" src="scripts/usuario.js?=<?php echo $_SESSION['version_sistema']; ?>"></script>


    <?php
}
//termina el buffer
ob_end_flush();
