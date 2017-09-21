<?php
  session_start();
  ob_start();
  include "functions.php";
  if( !session_valida() )
  {
    header("Location: cerrar_sesion.php");
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>UNIVGD-Crear Digital</title>
    <?= getLibrariesHeader() ?>
    <script type="text/javascript">
      var $id_user = <?= $_SESSION["id_usuario"] ?>;
    </script>
</head>
<body>
  <!-- Modal cargando data-backdrop="static" aria-hidden="true" data-keyboard="false" Evitan que se cierre con ESC o click por fuera-->
  <div class="modal fade" id="modalLoading" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="text-center">Cargando...</h3>
        </div>
        <div class="modal-body">
          <div class="progress">
            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="60" style="width:100%"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--End Modal cargando-->
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <h1 class="titulo"><img class="logo" src="images/logo.jpg"></h1>
                </a>
            </div>
            <!-- Menú lateral -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                  <ul class="nav" id="side-menu">
                        <?= getMenuPerfil( $_SESSION["id_perfil"] ) ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
