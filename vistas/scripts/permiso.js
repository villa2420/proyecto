// variable global
var tabla;

//funcion que se ejecuta al inicio
function init() {

    // hace referencia a otras finciones que se van a implementar

    mostrarform(false);
    listar();
}


//funcion mostrar formulario
function mostrarform(flag) {

    //limpiar();
    if (flag) {

        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else {

        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").hide();
    }

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

            url: '../controlador/permiso.php?op=listar',
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


init();


