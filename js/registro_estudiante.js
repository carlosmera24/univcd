function registrarEstudiante()
{
  var doc = $("#doc").val();
  var nombre = $("#nombre").val();
  var apellido = $("#apellido").val();
  var email = $("#email").val();

  //Ocultar mensajes error
  $("#msg_error_doc").fadeOut();
  $("#msg_error_nombre").fadeOut();
  $("#msg_error_apellido").fadeOut();
  $("#msg_error_email").fadeOut();

  //Validar campos requeridos
  if( doc === "" )
  {
    $("#doc").focus();
    $("#msg_error_doc").fadeIn();
  }else if( nombre === "" )
  {
    $("#nombre").focus();
    $("#msg_error_nombre").fadeIn();
  }else if( apellido === "")
  {
    $("#apellido").focus();
    $("#msg_error_apellido").fadeIn();
  }else if( email === "")
  {
    $("#email").focus();
    $("#msg_error_email").text("Campo requerido");
    $("#msg_error_email").fadeIn();
  }else if( !validarEmail(email) )
  {
    $("#email").focus();
    $("#msg_error_email").text("E-mail inválida");
    $("#msg_error_email").fadeIn();
  }else{
    $("#btn_guardar").button("loading"); //Cambiar estado del botón guardarNuevo
    $.ajax(
    {
        cache: false,
        type: "POST",
        url: "querys/gestion_usuarios.php",
        data: {
                opcion    : 1 ,
                doc       : doc,
                nombre : nombre,
                apellido  : apellido,
                correo    : email
              },
        dataType: "json",
        success: function(res)
        {
            if( res.status === "OK" )
            {
              jAlert('Usuario guardado con éxito, por favor utilice su documento como código para ingresar a la plataforma', 'Nuevo Usuario', function(){
                window.location.href = "login_estudiante.php"
              });
            }else if(res.status === "EXIST" )//Documento existente
            {
              jAlert('El documento '+ doc +' ya se encuentra registrado', 'Error', function(){
                $("#doc").focus();
              });
            }else if( res.status === "ERROR")
            {
              jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
            }
            $("#btn_guardar").button("reset");//Restaurar boton guardar
        }
    });
  }
}

$(document).ready(function(){
  $("#doc").focus();
  $("#doc").keydown(function(e){
    inputNumberOnly(e);
  });
});
