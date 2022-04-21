<?php
session_start();

if (!isset($_SESSION["nombre"])) {

    header("Location: login.php");
} else {

    require './header.php';

    if ($_SESSION["escritorio"] == 1) {
        
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
                                <h1 class="box-title"> Escritorio </h1>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <!-- centro -->
                            <div class="panel-body">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                            <h4 style="font-size: 17px">
                                                <strong>Bienvenidos al sistema!!!</strong>
                                            </h4>
                                        </div>

                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>

                                        <a href="paciente.php" class="small-box-footer">
                                            Pacientes
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
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



    <?php
}
