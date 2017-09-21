<?php include "header.php"; ?>
<script type="text/javascript">
  $(document).ready( function()
  {
    $("#tabla_electivas").DataTable({
      responsive: true,
      "language":{
          "url"   :   "extensions/datatables/language/es.json"
      }
    });
  });
</script>
<div id="page-wrapper">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-list fa-fw"></i> Listado de electivas</h1>
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row" id="datos">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
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
                  <th>Cupos disponibles</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $con = start_connect();
            			if ($con)
                  {
                    $query = "SELECT * FROM qr_electivas_cupos ORDER BY nombre ASC";
                    $result = mysqli_query($con,$query);
                    while( $row = mysqli_fetch_array($result) )
                    {
                ?>
                    <tr>
                      <td><?= $row["id_electiva"] ?></td>
                      <td><?= utf8_encode( $row["nombre"] ) ?></td>
                      <td><?= utf8_encode( $row["descripcion"] ) ?></td>
                      <td><?= utf8_encode( $row["nombre_profesor"] ) ?></td>
                      <td><?= $row["cupos_disponibles"] ?>/<?= $row["cupos"] ?></td>
                    </tr>
                <?php
                    }
                    //Close BD Connection
                    if( !close_bd($con) )
                    {
                      $retorno["msg"] = "WARNING: Fallo al cerrar la conexión BDD";
                    }
                  }
                ?>
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
