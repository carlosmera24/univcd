/**
* Función encargada de recargar la tabla de usuarios
*/
function recargarElectivas()
{
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_electivas.php",
    data: { opcion : 7 },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        var datos = [];
        for( var i=0; i < res.electivas.length; i++)
        {
            var link_editar = '<a href="#" class="fa fa-pencil-square-o" aria-hidden="true" onclick="modificarElectiva(\''+ res.electivas[i].id +'\',\''+ res.electivas[i].nombre +'\',\''+
                              res.electivas[i].descripcion +'\',\''+ res.electivas[i].cupos +'\',\''+ res.electivas[i].id_profesor +'\')"></a>';
            var link_borrar = '<a href="#" class="fa fa-trash-o" aria-hidden="true" onclick="elimnarElectiva(\''+ res.electivas[i].id +'\')"></a>';
            datos[i] = [
                            res.electivas[i].id,
                            res.electivas[i].nombre,
                            res.electivas[i].descripcion,
                            res.electivas[i].cupos,
                            res.electivas[i].profesor,
                            link_editar,
                            link_borrar
                        ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_electivas').DataTable();
        table.destroy();
        $("#tabla_electivas").DataTable({
            data: datos,
            responsive: true,
            "language":{
                "url"   :   "extensions/datatables/language/es.json"
            }
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
    }
  });
}
/**
* Función encargada de gestionar la apertura del PopUp para el ingreso del nuevo usuario
*/
function abrirNuevaElectiva()
{
  //Consultar perfiles
  $.ajax(
  {
      cache: false,
      type: "POST",
      url: "querys/gestion_electivas.php",
      data: { opcion : 6 },
      dataType: "json",
      success: function(res)
      {
          if( res.status === "OK" )
          {
            var lista = '<option value="null">--Profesor--</option>';
            for( var i=0; i < res.profesores.length; i++ )
            {
              lista += '<option value="'+ res.profesores[i].id +'">'+ res.profesores[i].nombre +' '+ res.profesores[i].apellido +'</option>';
            }
            $("#new_profesor").html( lista );
            //Resetear campos
            $("#new_nombre").val("");
            $("#new_desc").val("");
            $("#new_cupos").val("");
            $("#new_profesor").val("null");
            //Ocultar mensajes error
            $("#form_nueva_electiva #msg_error_nombre").fadeOut();
            $("#form_nueva_electiva #msg_error_desc").fadeOut();
            $("#form_nueva_electiva #msg_error_cupos").fadeOut();
            $("#form_nueva_electiva #msg_error_profesor").fadeOut();
            //Abrir PopUp
            $("#modalNuevaElectiva").modal("show");
            $('#modalNuevaElectiva').on('shown.bs.modal', function (e) {
                $("#new_nombre").focus();
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
      }
  });
}

/**
* Función encargada de inicializar y abrir PopUp modificar Usuario
*/
function modificarElectiva(id,nombre,desc,cupo,id_profesor)
{
  //Consultar perfiles
  $.ajax(
  {
      cache: false,
      type: "POST",
      url: "querys/gestion_electivas.php",
      data: { opcion : 6 },
      dataType: "json",
      success: function(res)
      {
          if( res.status === "OK" )
          {
            var lista = '<option value="null">--Profesor--</option>';
            for( var i=0; i < res.profesores.length; i++ )
            {
              lista += '<option value="'+ res.profesores[i].id +'">'+ res.profesores[i].nombre +' '+ res.profesores[i].apellido +'</option>';
            }
            $("#edit_profesor").html( lista );
            //Resetear campos
            $("#edit_id_electiva").val(id);
            $("#edit_nombre").val(nombre);
            $("#edit_desc").val(desc);
            $("#edit_cupos").val(cupo);
            $("#edit_profesor").val(id_profesor);
            //Ocultar mensajes error
            $("#form_editar_electiva #msg_error_nombre").fadeOut();
            $("#form_editar_electiva #msg_error_desc").fadeOut();
            $("#form_editar_electiva #msg_error_cupos").fadeOut();
            $("#form_editar_electiva #msg_error_profesor").fadeOut();
            //Abrir Pop
            $("#modalEditarElectiva").modal("show");
            $('#modalEditarElectiva').on('shown.bs.modal', function (e) {
                $("#edit_nombre").focus();
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
      }
  });
}

/**
* Funcion encargada de procesar el registro del nuevo usuario
*/
function guardarNuevo()
{
  var nombre = $("#new_nombre").val();
  var desc = $("#new_desc").val();
  var cupo = $("#new_cupos").val();
  var profesor = $("#new_profesor").val();

  //Ocultar mensajes error
  $("#form_nueva_electiva #msg_error_nombre").fadeOut();
  $("#form_nueva_electiva #msg_error_desc").fadeOut();
  $("#form_nueva_electiva #msg_error_cupos").fadeOut();
  $("#form_nueva_electiva #msg_error_profesor").fadeOut();

  //Validar campos requeridos
  if( nombre === "" )
  {
    $("#new_nombre").focus();
    $("#form_nueva_electiva #msg_error_nombre").fadeIn();
  }else if( desc === "")
  {
    $("#new_desc").focus();
    $("#form_nueva_electiva #msg_error_desc").fadeIn();
  }else if( cupo === "")
  {
    $("#new_cupos").focus();
    $("#form_nueva_electiva #msg_error_cupos").fadeIn();
  }else if( profesor === "null")
  {
    $("#form_nueva_electiva #new_profesor").focus();
    $("#form_nueva_electiva #msg_error_profesor").fadeIn();
  }
  else{
    $("#btn_guardar_nuevo").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_electivas.php",
        data: {
                opcion      : 8,
                nombre      : nombre,
                desc        : desc,
                cupos       : cupo,
                id_profesor : profesor
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalNuevaElectiva").modal("hide");
              jAlert('Electiva guardada con éxito', 'Nueva electiva', function(){
                recargarElectivas();
              });
            }else if(res.status === "EXIST" )//Correo existente
            {
              jAlert('El E-Mail '+ email +' ya se encuentra registrado', 'Error', function(){
                $("#new_email").focus();
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
}
/**
* Funcion encargada de procesar la modificación del usuario
*/
function guardarModificacion()
{
  var id = $("#edit_id_electiva").val();
  var nombre = $("#edit_nombre").val();
  var desc = $("#edit_desc").val();
  var cupo = $("#edit_cupos").val();
  var profesor = $("#edit_profesor").val();

  //Ocultar mensajes error
  $("#form_editar_electiva #msg_error_nombre").fadeOut();
  $("#form_editar_electiva #msg_error_desc").fadeOut();
  $("#form_editar_electiva #msg_error_cupos").fadeOut();
  $("#form_editar_electiva #msg_error_profesor").fadeOut();
  //Validar campos requeridos
  if( nombre === "" )
  {
    $("#edit_nombre").focus();
    $("#form_editar_electiva #msg_error_nombre").fadeIn();
  }else if( desc === "")
  {
    $("#edit_desc").focus();
    $("#form_editar_electiva #msg_error_desc").fadeIn();
  }else if( cupo === "")
  {
    $("#edit_cupos").focus();
    $("#form_editar_electiva #msg_error_cupos").fadeIn();
  }else if( profesor === "null")
  {
    $("#form_editar_electiva #edit_profesor").focus();
    $("#form_editar_electiva #msg_error_profesor").fadeIn();
  }
  else{
    $("#btn_guardar_edit").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_electivas.php",
        data: {
                opcion    : 9,
                id_electiva   : id,
                nombre      : nombre,
                desc        : desc,
                cupos       : cupo,
                id_profesor : profesor
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalEditarElectiva").modal("hide");
              jAlert('Elevtiva actualizada con éxito', 'Editar Electiva', function(){
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
            $("#btn_guardar_edit").button("reset");//Restaurar boton guardar
        }
    });
  }
}

/**
* Función encargada de borrar el usuario
*/
function elimnarElectiva(id)
{
  jConfirm('¿Desea borrar la electiva con ID:'+ id +'?','Eliminar usuario', function(res){
    if(res)
    {
      $.ajax(
      {
          cache: false,
          type: "POST",
          url: "querys/gestion_electivas.php",
          data: {
                  opcion  : 10,
                  id      : id,
                },
          dataType: "json",
          success: function(res)
          {
              if( res.status === "OK" )
              {
                jAlert('Usuario eliminado con éxito', 'Eliminar electiva', function(){
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
          }
      });
    }
  });
}

$(document).ready( function()
{
  $("#tabla_electivas").DataTable({
    responsive: true,
    "language":{
        "url"   :   "extensions/datatables/language/es.json"
    }
  });
  $("#new_cupos").keydown(function(e){
    inputNumberOnly(e);
  });
  $("#edit_cupos").keydown(function(e){
    inputNumberOnly(e);
  });
});
