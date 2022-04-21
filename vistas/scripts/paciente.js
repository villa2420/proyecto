// variable global
var tabla;

//funcion que se ejecuta al inicio
function init() {

    // hace referencia a otras finciones que se van a implementar
    mostrarform(false);
    listar();



    //Cargamos los items al select documento
    $.post("../controlador/paciente.php?op=selectDocumento", function (r) {
        $("#tipo_documento").html(r);
        $('#tipo_documento').selectpicker('refresh');
    });


    //Cargamos los items al select genero
    $.post("../controlador/paciente.php?op=selectGenero", function (r) {
        $("#tipo_genero").html(r);
        $('#tipo_genero').selectpicker('refresh');
    });


    //Cargamos los items al select departamento
    $.post("../controlador/paciente.php?op=selectDepartamento", function (r) {
        $("#depto").html(r);
        $('#depto').selectpicker('refresh');
    });

}


function validar_datos() {

    var estado = 0;


    if ($("#tipo_documento").val() === '0') {

        $("#tipo_documento").focus();
        estado = 1;
    }

    if ($("#tipo_genero").val() === '0') {

        $("#tipo_genero").focus();
        estado = 1;
    }

    if ($("#depto").val() === '0') {

        $("#depto").focus();
        estado = 1;
    }

    if ($("#municipio").val() === '0') {

        $("#municipio").focus();
        estado = 1;
    }

    return estado;
}



//funcion limpiar, limpia los datos declarados en el formulario html
function limpiar() {

    $("#num_documento").val("");
    $("#primer_nombre").val("");
    $("#segundo_nombre").val("");
    $("#primer_apellido").val("");
    $("#segundo_apellido").val("");
    $("#idpersona").val("");

}


//funcion mostrar formulario true o false como parametro
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

            url: '../controlador/paciente.php?op=listarp',
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
function guardaryeditar() {

    if (validar_datos() === 0) {

        //e.preventDefault(); //no se activara la accion predeterminada del evento
        $("#btnGuardar").prop("disabled", true);
        var formData = new FormData($("#formulario")[0]);

        $.ajax({

            url: '../controlador/paciente.php?op=guardaryeditar',
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
}


//mostar una categoria para editarla
function mostrar(idpersona) {

    $.post("../controlador/paciente.php?op=mostrar", {idpersona: idpersona}, function (data, status) {

        data = JSON.parse(data);
        mostrarform(true);


        $("#num_documento").val(parseInt(data.numero_documento));
        $("#primer_nombre").val(data.nombre1);
        $("#segundo_nombre").val(data.nombre2);
        $("#primer_apellido").val(data.apellido1);
        $("#segundo_apellido").val(data.apellido2);
        $("#idpersona").val(data.id);

         $('#tipo_documento').val(data.tipo_documento_id);
         $("#tipo_documento").selectpicker('refresh');
         $('#tipo_genero').val(data.genero_id);
         $("#tipo_genero").selectpicker('refresh');
         $('#depto').val(data.departamento_id);
         $("#depto").selectpicker('refresh');
         
         //Cargar todos los municipios y seleccionar el almacenado
         cargar_municipios();
         $('#municipio').val(data.municipio_id);
         $("#municipio").selectpicker('refresh');
        
    });
}


//funcion para eliminar registros
function eliminar(idpersona) {

    bootbox.confirm("¿Esta seguro de deshabilitar el Paciente?", function (result) {

        if (result) {

            $.post("../controlador/paciente.php?op=eliminar", {idpersona: idpersona}, function (e) {

                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}


//funcion para activar registros
function activar(idpersona) {

    bootbox.confirm("¿Esta seguro de activar el Paciente?", function (result) {

        if (result) {

            $.post("../controlador/paciente.php?op=activar", {idpersona: idpersona}, function (e) {

                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}


//Metodo que carga los municipios en funcion del departamento
function cargar_municipios() {

    //Limpio el contenido del select
    $('#municipio').empty();

    //Obtengo el DPTO
    var depto = $("#depto").val();


    //Obtengo las propiedades del select
    var mostrar_municipio = document.querySelector('#municipio');


    if (depto !== '0') {

        $.ajax({
            url: '../controlador/paciente.php?op=cargar_municipios',
            data: {id_departamento: depto},
            type: "GET",
            dataType: "json",
            success: function (data) {

                for (var i = 0; i < data.length; i++) {

                    //Creo los elementos para el select
                    var option = document.createElement("option");

                    option.innerHTML = data[i].nombre;
                    option.value = data[i].id;
                    mostrar_municipio.appendChild(option);
                    $('#municipio').selectpicker('refresh');
                }

            },
            error: function (e) {
                console.log(e.responseText);
            }
        });

    } else {

        //Creo un elemento vacio
        var option = document.createElement("option");
        option.innerHTML = 'SELECCIONE';
        option.value = '0';
        mostrar_municipio.appendChild(option);
        $('#municipio').selectpicker('refresh');
    }

}


init();


