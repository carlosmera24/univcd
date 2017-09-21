<?php
  //Show errors
  error_reporting(E_ALL | E_STRICT);
  ini_set('display_errors', 'On');

  $KEY_ENCRYPT_PASS = 'u7Gd!aR$4@a'; //Key de encryptación para contraseñas
  /**
  * Función encargada de iniciar la conexión a la BDD,
  * Para evaluar errores se puede utilizar isErrorConexionBDD( $con )
  * @return Objecto conexión msqli
  */
  function start_connect()
  {
    $host = "localhost";
  	$user = "univcd";
  	$pass = "-h41A9SU;kMx";
  	$bd = "univcd";

  	return mysqli_connect($host,$user,$pass,$bd);
  }

  /**
  * Función encargada de cerrar la conexión a la BDD,
  * Para evaluar errores se puede utilizar isErrorConexionBDD( $con )
  * @return Objecto conexión msqli
  */
  function close_bd($con)
  {
    return mysqli_close($con);
  }

  /**
  * Funcion encargada de validar inactividad de session y expirar o actualizar
  * @return true | false
  */
	function session_valida()
	{
    $retorno = false;
		$t_minimo = 15 * 60; //Tiempo válido de inactividad 15 minutos
		if( isset( $_SESSION["tiempo_activo"] ) )
		{
			$t_transcurrido = time() - $_SESSION["tiempo_activo"];
			if( $t_transcurrido > $t_minimo )
			{
        $retorno = false;
				// header("Location:". get_site_url() ."/cerrar_sesion.php");
			}else{
				$_SESSION["tiempo_activo"] = time();
        $retorno = true;
			}
		}
    return $retorno;
	}

  /**
  * Función encargada de imprimir la configuración basica de las librerías de la cabecera principal
  */
  function getLibrariesHeader()
  {
    $head = '<!-- jQuery -->
              <script type="text/javascript" src="extensions/jquery/jquery-1.12.4.min.js"></script>
              <!-- bootstrap -->
              <link rel="stylesheet" href="extensions/bootstrap/css/bootstrap.min.css">
              <link rel="stylesheet" href="extensions/bootstrap/css/bootstrap-theme.min.css">
              <script src="extensions/bootstrap/js/bootstrap.min.js"></script>
              <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
              <!-- DataTables -->
              <link rel="stylesheet" type="text/css" href="extensions/datatables/css/jquery.dataTables.css">
              <script type="text/javascript" charset="utf8" src="extensions/datatables/js/jquery.dataTables.js"></script>
              <!-- jAlert JavaScript -->
              <script src="extensions/jAlert/js/jquery.ui.draggable.js"></script>
              <script src="extensions/jAlert/js/jquery.alerts.js"></script>
              <link href="extensions/jAlert/css/jquery.alerts.css" rel="stylesheet" media="screen">
              <!-- Functions -->
              <script type="text/javascript" src="js/functions.js?n='. time() .'"></script>
              <!-- Metis Menu Plugin JavaScript -->
              <script src="extensions/metisMenu/dist/metisMenu.min.js"></script>
              <link href="extensions/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
              <!-- Estilo -->
              <link href="css/style.css" rel="stylesheet">
              <link href="css/timeline.css" rel="stylesheet">
              <script>
              jQuery.browser = {};
              (function () {
                  jQuery.browser.msie = false;
                  jQuery.browser.version = 0;
                  if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
                      jQuery.browser.msie = true;
                      jQuery.browser.version = RegExp.$1;
                  }
              })();
          </script>';
    return $head;
  }

  function getMenuPerfil( $id_perfil )
  {
    $menu = "";
    switch( $id_perfil )
    {
      case 1: //Adminsitrador
        $menu = '<li>
                      <a href="usuarios.php"><i class="fa fa-users fa-fw"></i> Usuarios<span class="fa arrow"></span></a>
                  </li>
                  <li>
                      <a href="#"><i class="fa fa-university fa-fw"></i> Electivas<span class="fa arrow"></span></a>
                      <ul class="nav nav-second-level" id="sub-side-menu">
                          <li>
                              <a href="electivas.php"><i class="fa fa-list fa-fw"></i> CRUD Electivas</a>
                          </li>
                          <li>
                              <a href="otros_electivas.php"><i class="fa fa-users fa-fw"></i> Estudiantes electivas</a>
                          </li>
                          <li>
                              <a href="electiva_estudiantes.php"><i class="fa fa-list fa-fw"></i>Electiva estudiantes</a>
                          </li>
                          <li>
                              <a href="profesor_electivas.php"><i class="fa fa-graduation-cap fa-fw"></i>Profesor electivas</a>
                          </li>
                      </ul>
                  </li>
                  <li>
                    <a href="cerrar_sesion.php"><i class="fa fa-sign-out fa-fw"></i> Salir<span class="fa arrow"></span></a>
                  </li>';
        break;
      case 2: //Estudiante
          $menu = '<li>
                        <a href="#"><i class="fa fa-university fa-fw"></i> Electivas<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level" id="sub-side-menu">
                            <li>
                                <a href="mis_electivas.php"><i class="fa fa-user fa-fw"></i> Mis registros</a>
                            </li>
                            <li>
                                <a href="otros_electivas.php"><i class="fa fa-users fa-fw"></i> Consultar otros</a>
                            </li>
                            <li>
                                <a href="lista_electivas.php"><i class="fa fa-list fa-fw"></i> Listado electivas</a>
                            </li>
                            <li>
                                <a href="electiva_estudiantes.php"><i class="fa fa-list fa-fw"></i>Electiva estudiantes</a>
                            </li>
                            <li>
                                <a href="profesor_electivas.php"><i class="fa fa-graduation-cap fa-fw"></i>Profesor electivas</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                      <a href="cerrar_sesion.php"><i class="fa fa-sign-out fa-fw"></i> Salir<span class="fa arrow"></span></a>
                    </li>';
        break;
    }
    return $menu;
  }
?>
