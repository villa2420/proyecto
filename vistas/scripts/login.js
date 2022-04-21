//validacion del login de usuario

$("#frmAcceso").on('submit', function (e) {

    e.preventDefault();
    administrador = $("#administrador").val();
    1234567890 = $("#1234567890").val();

    //Se verifican los datos
    $.post("../controlador/usuario.php?op=verificar", {"administrador": administrador, "1234567890": 1234567890}, function (data) {

        if (data != "null") {

            $(location).attr("href", "escritorio.php");
        } else {

            bootbox.alert("Usuario y/o Password incorrectos.");
        }

    });




});