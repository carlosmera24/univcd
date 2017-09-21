/**
* Función encargada de recargar la tabla de usuarios
*/
function recargarUsuarios()
{
  $.ajax(
  {
    cache: false,
    type: "POST",
    url: "querys/gestion_usuarios.php",
    data: { opcion : 7 },
    dataType: "json",
    success: function(res)
    {
      if( res.status === "OK" )
      {
        var datos = [];
        for( var i=0; i < res.usuarios.length; i++)
        {
            var link_editar = '<a href="#" class="fa fa-pencil-square-o" aria-hidden="true" onclick="modificarUsuario(\''+ res.usuarios[i].id +'\',\''+ res.usuarios[i].usuario +'\',\''+
                              res.usuarios[i].password +'\',\''+ res.usuarios[i].id_perfil +'\')"></a>';
            var link_borrar = '<a href="#" class="fa fa-trash-o" aria-hidden="true" onclick="elimnarUsuario(\''+ res.usuarios[i].id +'\')"></a>';
            datos[i] = [
                            res.usuarios[i].id,
                            res.usuarios[i].usuario,
                            res.usuarios[i].perfil,
                            link_editar,
                            link_borrar
                        ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_usuarios').DataTable();
        table.destroy();
        $("#tabla_usuarios").DataTable({
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
function abrirNuevoUsuario()
{
  //Consultar perfiles
  $.ajax(
  {
      cache: false,
      type: "POST",
      url: "querys/gestion_usuarios.php",
      data: { opcion : 4 },
      dataType: "json",
      success: function(res)
      {
          if( res.status === "OK" )
          {
            var lista = "";
            for( var i=0; i < res.perfiles.length; i++ )
            {
              lista += '<option value="'+ res.perfiles[i].id +'">'+ res.perfiles[i].nombre +'</option>';
            }
            $("#new_perfil").html( lista );
            //Resetear campos
            $("#new_nombre").val("");
            $("#new_pass").val("");
            $("#new_perfil").val("null");
            //Ocultar mensajes error
            $("#form_nuevo_usuario #msg_error_nombre").fadeOut();
            $("#form_nuevo_usuario #msg_error_password").fadeOut();
            $("#form_nuevo_usuario #msg_error_perfil").fadeOut();
            //Abrir PopUp
            $("#modalNuevoUsuario").modal("show");
            $('#modalNuevoUsuario').on('shown.bs.modal', function (e) {
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
function modificarUsuario(id,nombre,pass,perfil)
{
  //Consultar perfiles
  $.ajax(
  {
      cache: false,
      type: "POST",
      url: "querys/gestion_usuarios.php",
      data: { opcion : 4 },
      dataType: "json",
      success: function(res)
      {
          if( res.status === "OK" )
          {
            var lista = "";
            for( var i=0; i < res.perfiles.length; i++ )
            {
              lista += '<option value="'+ res.perfiles[i].id +'">'+ res.perfiles[i].nombre +'</option>';
            }
            $("#edit_perfil").html( lista );
            //Asignar valores a los campos
            $("#edit_id_usuario").val(id);
            $("#edit_nombre").val(nombre);
            $("#edit_pass").val(pass);
            $("#edit_perfil").val(perfil);
            //Ocultar mensajes error
            $("#form_editar_usuario #msg_error_nombre").fadeOut();
            $("#form_editar_usuario #msg_error_password").fadeOut();
            $("#form_editar_usuario #msg_error_perfil").fadeOut();
            //Abrir Pop
            $("#modalEditarUsuario").modal("show");
            $('#modalEditarUsuario').on('shown.bs.modal', function (e) {
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
  var pass = $("#new_pass").val();
  var perfil = $("#new_perfil").val();

  //Ocultar mensajes error
  $("#form_nuevo_usuario #msg_error_nombre").fadeOut();
  $("#form_nuevo_usuario #msg_error_password").fadeOut();
  $("#form_nuevo_usuario #msg_error_perfil").fadeOut();

  //Validar campos requeridos
  if( nombre === "" )
  {
    $("#new_nombre").focus();
    $("#form_nuevo_usuario #msg_error_nombre").fadeIn();
  }else if( pass === "")
  {
    $("#new_pass").focus();
    $("#form_nuevo_usuario #msg_error_password").fadeIn();
  }else if( perfil === "null")
  {
    $("#form_nuevo_usuario #new_perfil").focus();
    $("#form_nuevo_usuario #msg_error_perfil").fadeIn();
  }
  else{
    $("#btn_guardar_nuevo").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_usuarios.php",
        data: {
                opcion    : 5,
                usuario    : nombre,
                password  : pass,
                perfil    : perfil
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalNuevoUsuario").modal("hide");
              jAlert('Usuario guardado con éxito', 'Nuevo Usuario', function(){
                recargarUsuarios();
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
  var id = $("#edit_id_usuario").val();
  var nombre = $("#edit_nombre").val();
  var pass = $("#edit_pass").val();
  var perfil = $("#edit_perfil").val();

  //Ocultar mensajes error
  $("#form_editar_usuario #msg_error_nombre").fadeOut();
  $("#form_editar_usuario #msg_error_password").fadeOut();
  $("#form_editar_usuario #msg_error_perfil").fadeOut();
  //Validar campos requeridos
  if( nombre === "" )
  {
    $("#edit_nombre").focus();
    $("#form_editar_usuario #msg_error_nombre").fadeIn();
  }else if( pass === "")
  {
    $("#edit_pass").focus();
    $("#form_editar_usuario #msg_error_password").fadeIn();
  }else if( perfil === "null")
  {
    $("#edit_perfil").focus();
    $("#form_editar_usuario #msg_error_perfil").fadeIn();
  }
  else{
    $("#btn_guardar_edit").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_usuarios.php",
        data: {
                opcion    : 6,
                id_user   : id,
                usuario    : nombre,
                password  : pass,
                perfil    : perfil
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              $("#modalEditarUsuario").modal("hide");
              jAlert('Usuario actualizado con éxito', 'Editar Usuario', function(){
                recargarUsuarios();
              });
            }else if(res.status === "EXIST" )//Correo existente
            {
              jAlert('El E-Mail '+ email +' ya se encuentra registrado', 'Error', function(){
                $("#edit_email").focus();
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
function elimnarUsuario(id)
{
  jConfirm('¿Desea borrar el usuario con ID:'+ id +'?','Eliminar usuario', function(res){
    if(res)
    {
      $.ajax(
      {
          cache: false,
          type: "POST",
          url: "querys/gestion_usuarios.php",
          data: {
                  opcion    : 8,
                  id_user   : id,
                },
          dataType: "json",
          success: function(res)
          {
              if( res.status === "OK" )
              {
                jAlert('Usuario eliminado con éxito', 'Eliminar Usuario', function(){
                  recargarUsuarios();
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
  $("#tabla_usuarios").DataTable({
    responsive: true,
    "language":{
        "url"   :   "extensions/datatables/language/es.json"
    }
  });
});
