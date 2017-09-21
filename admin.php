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

    <script type="text/javascript" src="js/login_admin.js?n=<?= time() ?>"></script>
  </head>
  <body>
    <div id="login" class="row">
      <div class="col-sm-4"></div>
      <div class="col-sm-4 panel panel-primary">
        <h1 class="text-center"><img class="logo" src="images/logo.jpg"></h1>
        <h2 class="text-center">UNIVCD</h2>
        <form id="form_login" class="">
          <div class="form-group">
            <label for="usuario">Usuario</label>
            <input type="text" class="form-control" id="usuario" name="usuario">
            <div id="msg_error_usuario" class="alert alert-danger object_hidden" role="alert">Campo requerido</div>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
            <div id="msg_error_password" class="alert alert-danger object_hidden" role="alert">Campo requerido</div>
          </div>
          <div class="form-group text-center">
            <button id="btn_guardar" type="button" class="btn btn-primary" onclick="iniciarSesion()"
            data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Procesando...">Aceptar</button>
          </div>
          <div id="msg_error_session" class="alert alert-danger text-center object_hidden" role="alert"></div>
          <div class="form-group text-center">
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
