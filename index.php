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
  </head>
  <body>
    <div id="login" class="row">
      <div class="col-sm-4"></div>
      <div class="col-sm-4 panel panel-primary">
        <h1 class="text-center"><img class="logo" src="images/logo.jpg"></h1>
        <h2 class="text-center">UNIVCD</h2>
        <div class="row">
          <div class="col-sm-12 text-center">
            <ul class="list-group">
              <li class="list-group-item" ><a href="login_estudiante.php"><i class="fa fa-graduation-cap fa-fw"></i> Estudiantes</a></li>
              <li class="list-group-item"><a href="admin.php"><i class="fa fa-shield fa-fw"></i> Administradores</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
