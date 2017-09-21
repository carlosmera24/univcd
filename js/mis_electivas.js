//Función encargada de inicializar los datos de la tabla
function inicializarDatosTabla()
{
  $('#tabla_electivas').DataTable({
    responsive: true,
    language:{
        "url"   :   "extensions/datatables/language/es.json"
    },
    ajax: {
	    type: "POST",
	    dataType: "json",
	    url: 'querys/gestion_electivas.php',
	    data: {
              opcion  : 1,
              id_user : $id_user
            },
	    dataSrc: function(res){
	      if( res.status === "OK" )
	      {
	        var datos = [];
	        for( var i=0; i < res.electivas.length; i++)
	        {
						datos[i] = [
      										res.electivas[i].id,
      										res.electivas[i].nombre,
      										res.electivas[i].profesor,
      										res.electivas[i].cupos
      									];
	        }
	        $("#btn_agregar").prop("disabled",false);
	        $("#modalLoading").modal("hide");
	        return datos;
	      }else if(res.status === "EXPIRED" )//Sesión finalizada
	      {
	        jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
	          window.location = "cerrar_sesion.php";
	        });
	      }else if( res.status === "ERROR")
	      {
	        jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
	      }
	    }
	  }
  });
}

/**
* Función encargada de recargar la tabla de entrevistas
*/
function recargarElectivas()
{
  $("#btn_agregar").prop("disabled",true);
  //Visualizar mensaje de carga
  $("#modalLoading").modal("show");
  //Recargar tabla con función propia de dataTable
  var table = $('#tabla_electivas').DataTable();
  table.ajax.reload(null,false);
}
var ELECTIVAS = [];
function abrirNuevoElectiva()
{
  $("#info_electiva .panel-body").html( "" );
  $("#info_electiva").fadeOut();
  $("#btn_agregar").prop("disabled",true);
  //Consultar perfiles
  $.ajax(
  {
      cache: false,
      type: "POST",
      url: "querys/gestion_electivas.php",
      data: {
              opcion  : 2,
              id_user : $id_user
            },
      dataType: "json",
      success: function(res)
      {
          if( res.status === "OK" )
          {
            var lista = '<option value="null">--Electivas--</option>';
            for( var i=0; i < res.electivas.length; i++ )
            {
              ELECTIVAS[res.electivas[i].id] = res.electivas[i];
              lista += '<option value="'+ res.electivas[i].id +'"">';
              lista += '['+ res.electivas[i].id +'] '+ res.electivas[i].nombre +' ('+ res.electivas[i].cupos_label +')</option>';
            }
            $("#new_electiva").html( lista );
            //Ocultar mensajes error
            $("#msg_error_electiva").fadeOut();
            //Abrir PopUp
            $("#modalRegistroElectiva").modal("show");
          }else if(res.status === "EXPIRED" )//Sesión finalizada
          {
            jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
              window.location = "cerrar_sesion.php";
            });
          }else if( res.status === "ERROR")
          {
            jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
          }
          $("#btn_agregar").prop("disabled",false);
          $("#btn_guardar_nuevo").prop("disabled",true);
      }
  });
}

function cargarInfoElectiva( value )
{
  if( value !== "null" )
  {
    var electiva = ELECTIVAS[ value ];
    var content = '<table class="table">';
    content += '<tr><td><label>Descripción</label></td><td>'+ electiva.descripcion +'</td></tr>';
    content += '<tr><td><label>Profesor</label></td><td>'+ electiva.profesor +'</td></tr>';
    content += '<tr><td><label>Cupos</label></td><td>'+ electiva.cupos +'</td></tr>';
    content += '<tr><td><label>Cupos registrados</label></td><td>'+ electiva.cupos_registrados +'</td></tr>';
    content += '<tr><td><label>Cupos disponibles</label></td><td>'+ electiva.cupos_disponibles +'</td></tr>';
    content += '</table>';

    $("#info_electiva .panel-body").html( content );
    $("#btn_guardar_nuevo").prop("disabled", !( electiva.cupos_disponibles > 0 ) );
    $("#info_electiva").fadeIn();
  }else{
    $("#info_electiva .panel-body").html( "" );
    $("#btn_guardar_nuevo").prop("disabled",true);
    $("#info_electiva").fadeOut()
  }
}

function guardarNuevo()
{
  var id_electiva = $("#new_electiva").val();
  $("#btn_guardar_nuevo").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_electivas.php",
        data: {
                opcion        : 3,
                id_user       : $id_user,
                id_electiva   : id_electiva
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalRegistroElectiva").modal("hide");
              jAlert('Electiva registrada con éxito', 'Nuevo Electiva', function(){
                recargarElectivas();
              });
            }else if(res.status === "EXPIRED" )//Sesión finalizada
            {
              jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
                window.location = "cerrar_sesion.php";
              });
            }else if( res.status === "ERROR")
            {
              jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
            }
            $("#btn_guardar_nuevo").button("reset");//Restaurar boton guardar
        }
    });
}

$(document).ready(function(){
	inicializarDatosTabla();
   $("#new_electiva").on('change',function(){
       cargarInfoElectiva( this.value );
   });
});
