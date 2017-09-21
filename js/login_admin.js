function iniciarSesion()
{
  var user = $("#usuario").val();
  var pass = $("#password").val();
  //Ocultar mensajes error
  $("#msg_error_usuario").fadeOut();
  $("#msg_error_password").fadeOut();

  //Validar campos requeridos
  if( user === "" )
  {
    $("#doc").focus();
    $("#msg_error_usuario").fadeIn();
  }else if( pass === "" )
  {
    $("#password").focus();
    $("#msg_error_password").fadeIn();
  }else{
    $("#btn_guardar").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_usuarios.php",
        data: {
                opcion    : 3,
                doc       : user,
                pass      : pass
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              window.location.href = "portal_admin.php";
            }else if( res.status === "ERROR" || res.status === "INVALID")
            {
              $("#msg_error_session").text( res.msg );
              $("#msg_error_session").fadeIn();
            }
            $("#btn_guardar").button("reset");//Restaurar boton guardar
        }
    });
  }
}

$(document).ready(function(){
  $("#usuario").focus();
  $("#password").bind('keypress', function(event) {
      if(event.which === 13)
      {
        iniciarSesion();
      }
    });
  $("#form_login").submit( function(e){ return false; });
});
