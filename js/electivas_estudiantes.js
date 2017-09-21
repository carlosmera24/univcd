function cargarDatosUsuario( value )
{
  if( value === "null" )
  {
    var table = $('#tabla_electivas').DataTable();
    table.destroy();
    $("#tabla_electivas").DataTable({
        data: [],
        responsive: true,
        "language":{
            "url"   :   "extensions/datatables/language/es.json"
        }
    });
  }else{
    $.ajax(
    {
	    type: "POST",
	    dataType: "json",
	    url: 'querys/gestion_electivas.php',
	    data: {
              opcion  : 4,
              id_electiva : value
            },
      dataType: "json",
      success: function(res)
      {
        if( res.status === "OK" )
	      {
	        var datos = [];
	        for( var i=0; i < res.estudiantes.length; i++)
	        {
						datos[i] = [
      										res.estudiantes[i].id,
      										res.estudiantes[i].nombre,
      										res.estudiantes[i].apellido,
      										res.estudiantes[i].email
      									];
	        }
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
}

$(document).ready( function()
{
  $("#tabla_electivas").DataTable({
    responsive: true,
    "language":{
        "url"   :   "extensions/datatables/language/es.json"
    }
  });
  $("#list_electiva").on('change',function(){
      cargarDatosUsuario( this.value );
  });
});
