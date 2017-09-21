<!DOCTYPE html>
<html lang="es">
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>UNIVGD-Crear Digital</title>
    <?php
      include "functions.php";
      echo getLibrariesHeader();
    ?>
    <script type="text/javascript" src="js/registro_estudiante.js?n=<?= time() ?>"></script>
  </head>
  <body>
    <div id="login" class="row">
      <div class="col-sm-4"></div>
      <div class="col-sm-4 panel panel-primary">
        <h1 class="text-center"><img class="logo" src="images/logo.jpg"></h1>
        <h2 class="text-center">UNIVCD</h2>
        <form class="">
          <div class="form-group">
            <label for="doc">Documento</label>
            <input type="text" class="form-control" id="doc" name="doc" placeholder="Tu documento de identificación">
            <div id="msg_error_doc" class="alert alert-danger object_hidden" role="alert">Campo requerido</div>
          </div>
          <div class="form-group">
            <label for="nombre">Nombres</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="NOMBRE">
            <div id="msg_error_nombre" class="alert alert-danger object_hidden" role="alert">Campo requerido</div>
          </div>
          <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="APELLIDO">
            <div id="msg_error_apellido" class="alert alert-danger object_hidden" role="alert">Campo requerido</div>
          </div>
          <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="E-MAIL">
            <div id="msg_error_email" class="alert alert-danger object_hidden" role="alert">Campo requerido</div>
          </div>
          <div class="form-group text-center">
            <button id="btn_guardar" type="button" class="btn btn-primary" onclick="registrarEstudiante()"
            data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando...">Aceptar</button>
            <a href="login_estudiante.php" class="btn btn-primary">Cancelar</a>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
