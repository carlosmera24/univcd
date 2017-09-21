<?php include "header.php"; ?>
<script type="text/javascript" src="js/otros_electivas.js?n=<?= time() ?>"></script>
<div id="page-wrapper">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-users fa-fw"></i> Electivas otros estudiantes</h1>
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row" id="datos">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div>
            <label for="">Estudiante: </label>
            <select id="list_users">
              <option value="null">--Seleccionar--</option>
              <?php
                $con = start_connect();
          			if ($con)
                {
                  $query = "SELECT * FROM qr_usuarios WHERE id_perfil='2' AND id_usuarios!='". $_SESSION["id_usuario"] ."' ORDER BY nombres ASC";
                  $result = mysqli_query($con,$query);
                  while( $row = mysqli_fetch_array($result) )
                  {
              ?>
                <option value="<?= $row["id_usuarios"] ?>"><?= utf8_encode($row["nombres"]) ?> <?= utf8_encode($row["apellidos"]) ?></option>
              <?php
                  }
                  //Close BD Connection
                  if( !close_bd($con) )
                  {
                    $retorno["msg"] = "WARNING: Fallo al cerrar la conexión BDD";
                  }
                }
              ?>
            </select>
          </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <div class="dataTable_wrapper table-responsive">
            <table class="table table-striped table-bordered table-hover " id="tabla_electivas">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th>Profesor</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
            <!-- /.table-responsive -->
        </div>
          <!-- /.panel-body -->
      </div>
      <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
