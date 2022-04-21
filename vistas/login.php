
<?php
//se valida que no halla una session creada, de ser asi, se crea una nueva session
if (strlen(session_id()) < 1) {

    session_start();
}


//valida que halla sesion de usuario iniciada y redirecciona a prestador.php
(isset($_SESSION["nombre"])) ? header("Location: escritorio.php") : "";
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>GESTION NACIONAL</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="../public/css/bootstrap.min.css?='1.0'">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../public/css/font-awesome.css?='1.0'">

        <!-- Theme style -->
        <link rel="stylesheet" href="../public/css/AdminLTE.min.css?='1.0'">
        <!-- iCheck -->
        <link rel="stylesheet" href="../public/css/blue.css?='1.0'">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="../../index2.html"><b>CENTRO OCUPACIONAL S.A.S</b></a>
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Ingresa tus datos</p>
                <form method="post" id="frmAcceso">
                    <div class="form-group has-feedback">
                        <input type="text" id="administrador" name="administrador" class="form-control" placeholder="Usuario" required>
                        <span class="fa fa-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" id="1234567890" name="1234567890" class="form-control" placeholder="Password" required>
                        <span class="fa fa-key form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                        </div><!-- /.col -->
                    </div>
                </form>


            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->

        <!-- jQuery 2.1.4 -->
        <script src="../public/js/jquery-3.1.1.min.js?='1.0'"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="../public/js/bootstrap.min.js?='1.0'"></script>
        <!-- Bootbox -->
        <script src="../public/js/bootbox.min.js?='1.0'"></script>
        <!-- Arc login -->
        <script src="scripts/login.js?='1.0'"></script>


    </body>
</html>
