// variable global
var tabla;

//funcion que se ejecuta al inicio (al cargar la vista por primera vez)
function init() {

    // hace referencia a otras funciones que se van a implementar

    mostrarform(false);
    listar();

    $('#formulario').on("submit", function (e) {

        guardaryeditar(e);
    });

    $('#imagenmuestra').hide();

    //Mostramos los permisos
    $.post("../controlador/usuario.php?op=permisos&id=", function (r) {
        $("#permisos").html(r);
    });

}



//funcion limpiar, limpia los datos declarados en el formulario html
function limpiar() {

    $("#nombre").val("");
    $("#num_documento").val("");
    $("#direccion").val("");
    $("#telefono").val("");
    $("#email").val("");
    $("#cargo").val("");
    $("#login").val("");
    $("#clave").val("");
    $("#imagenmuestra").attr("src", "");
    $("#imagenactual").val("");
    $("#idusuario").val("");
}


//funcion mostrar formulario
function mostrarform(flag) {

    limpiar();
    if (flag) {

        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else {

        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }

}


//funcion cancelarform, oculta el formulario
function cancelarform() {

    limpiar();
    mostrarform(false);
}



//funcion listar tabla
function listar() {

    tabla = $('#tbllistado').dataTable({

        "aProcessing": true, //activamos el procesamiento del datatables
        "aServerSide": true, //paginacion y filtrados realizados por el servidor
        dom: 'Bfrtip', //definimos los elementos del control de tabla
        buttons: [

            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],

        "ajax": {

            url: '../controlador/usuario.php?op=listar',
            type: "GET",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },

        "bDestroy": true,
        "iDisplayLength": 5, //paginacion cada 5 registros
        "order": [[0, "desc"]] //organizacion de la columna a partir de la cero, ordenar (columna, orden)

    }).DataTable();
}


//funcion para guardar y editar 
function guardaryeditar(e) {

    e.preventDefault(); //no se activara la accion predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({

        url: '../controlador/usuario.php?op=guardaryeditar',
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {

            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }
    });

    limpiar();
}


//mostar una categoria para editarla
function mostrar(idusuario) {

    $.post("../controlador/usuario.php?op=mostrar", {idusuario: idusuario}, function (data, status) {

        data = JSON.parse(data);
        mostrarform(true);

        $("#nombre").val(data.nombre);
        $("#tipo_documento").val(data.tipo_documento);
        $("#tipo_documento").selectpicker('refresh');
        $("#num_documento").val(data.num_documento);
        $("#direccion").val(data.direccion);
        $("#telefono").val(data.telefono);
        $("#email").val(data.email);
        $("#cargo").val(data.cargo);
        $("#login").val(data.login);
        //$("#clave").val(data.clave);
        $("#imagenmuestra").show();
        $("#imagenmuestra").attr("src", "../files/usuarios/" + data.imagen);
        $("#imagenactual").val(data.imagen);
        $("#idusuario").val(data.idusuario);

    });


    //mostrar permisos del usuario
    //Mostramos los permisos
    $.post("../controlador/usuario.php?op=permisos&id=" + idusuario, function (r) {
        $("#permisos").html(r);
    });

}


//funcion para desactivar registros
function desactivar(idusuario) {

    bootbox.confirm("¿Esta seguro de desactivar el Usuario?", function (result) {

        if (result) {

            $.post("../controlador/usuario.php?op=desactivar", {idusuario: idusuario}, function (e) {

                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}



//funcion para activar registros
function activar(idusuario) {

    bootbox.confirm("¿Esta seguro de activar el Usuario?", function (result) {

        if (result) {

            $.post("../controlador/usuario.php?op=activar", {idusuario: idusuario}, function (e) {

                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}


init();



