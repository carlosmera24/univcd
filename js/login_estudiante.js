function iniciarSesion()
{
  var doc = $("#usuario").val();
  //Ocultar mensajes error
  $("#msg_error_usuario").fadeOut();

  //Validar campos requeridos
  if( doc === "" )
  {
    $("#doc").focus();
    $("#msg_error_usuario").fadeIn();
  }else{
    $("#btn_guardar").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_usuarios.php",
        data: {
                opcion    : 2,
                doc       : doc
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              window.location.href = "portal_estudiantes.php";
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
  $("#usuario").keydown(function(e){
    inputNumberOnly(e);
  });
  $("#usuario").bind('keypress', function(event) {
      if(event.which === 13)
      {
        iniciarSesion();
      }
    });
  $("#form_login").submit( function(e){ return false; });
});
