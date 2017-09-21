<?php include "header.php"; ?>
<script type="text/javascript" src="js/electivas.js?n=<?= time() ?>"></script>
<div id="page-wrapper">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-university fa-fw"></i> Electivas</h1>
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row" id="datos">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <button type="button" class="btn btn-default btn-circle btn-lg" onclick="abrirNuevaElectiva()">
            <i class="fa fa-plus"></i>
          </button> Agregar Nueva Electiva
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
                  <th>Cupo</th>
                  <th class="center">Editar</th>
                  <th class="center">Borrar</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $con = start_connect();
                if( $con )
                {
                  $query = "SELECT * FROM qr_electiva ORDER BY id_electiva ASC";
                  $resultado = mysqli_query($con, $query);
                  while( $row = mysqli_fetch_array($resultado) )
                  {
              ?>
                    <tr class="gradeX">
                      <td><?= $row["id_electiva"] ?></td>
                      <td><?= utf8_encode( $row["nombre"] ) ?></td>
                      <td><?= utf8_encode( $row["descripcion"] ) ?></td>
                      <td><?= utf8_encode( $row["nombres"] ) ?> <?= utf8_encode( $row["apellidos"] ) ?></td>
                      <td><?= $row["cupos"] ?></td>
                      <td class="center">
                        <a href="#" class="fa fa-pencil-square-o" aria-hidden="true" onclick="modificarElectiva('<?= $row["id_electiva"] ?>','<?= utf8_encode( $row["nombre"] ) ?>',
                          '<?= utf8_encode( $row["descripcion"] ) ?>','<?= $row["cupos"] ?>','<?= $row["profesor_id_profesor"] ?>')"></a>
                      </td>
                      <td class="center">
                        <a href="#" class="fa fa-trash-o" aria-hidden="true" onclick="elimnarElectiva('<?= $row["id_electiva"] ?>')"></a>
                      </td>
                    </tr>
                <?php
                  }
                  if( !close_bd($con) )
                  {
                    echo "Error al cerrar la BDD";
                  }
                }else{
                  echo "Error de conexión a la BDD:". mysqli_connect_error();
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

  <!-- Modal Nueva Electivaº -->
  <div class="modal fade" id="modalNuevaElectiva" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-university fa-fw"></i> Electivas</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Nueva Electiva
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_nueva_electiva" role="form">
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_nombre">Nombre:</label>
                          <div class="col-sm-9">
                            <input type="text" id="new_nombre" name="new_nombre" class="form-control" placeholder="Nombre electiva">
                            <div id="msg_error_nombre" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_desc">Descripción:</label>
                          <div class="col-sm-9">
                            <textarea id="new_desc" name="new_desc" rows="8" cols="40" class="form-control" placeholder="Descripción de la electiva"></textarea>
                            <div id="msg_error_desc" class="alert alert-danger object_hidden" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_cupos">Cupos:</label>
                          <div class="col-sm-9">
                            <input type="text" id="new_cupos" name="new_cupos" class="form-control" placeholder="Cantidad de cupos">
                            <div id="msg_error_cupos" class="alert alert-danger object_hidden" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_profesor">Profesor:</label>
                          <div class="col-sm-9">
                            <select id="new_profesor" name="new_profesor">
                              <option value="null">--Perfil--</option>
                            </select>
                            <div id="msg_error_profesor" class="alert alert-danger object_hidden" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group text-center">
                          <button id="btn_guardar_nuevo" type="button" onclick="guardarNuevo()"  class="btn btn-primary"
                            data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando...">Guardar</button>
                        </div>
                      </form>
                    </div>
                    <!-- /.col-lg-12 (nested) -->
                  </div>
                  <!-- /.row (nested) -->
                </div>
                  <!-- /.panel-body -->
              </div>
              <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- / Modal Nueva Electiva -->
  <!-- Modal Editar Electiva -->
  <div class="modal fade" id="modalEditarElectiva" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-university fa-fw"></i> Electivas</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Editar Usuario
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_editar_electiva" role="form">
                        <input type="hidden" id="edit_id_electiva" name="edit_id_electiva">
                        <div class="row form-group">
                          <label class="col-sm-3" for="edit_nombre">Nombre:</label>
                          <div class="col-sm-9">
                            <input type="text" id="edit_nombre" name="edit_nombre" class="form-control" placeholder="Nombre electiva">
                            <div id="msg_error_nombre" class="alert alert-danger" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="edit_desc">Descripción:</label>
                          <div class="col-sm-9">
                            <textarea id="edit_desc" name="edit_desc" rows="8" cols="40" class="form-control" placeholder="Descripción de la electiva"></textarea>
                            <div id="msg_error_desc" class="alert alert-danger object_hidden" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="edit_cupos">Cupos:</label>
                          <div class="col-sm-9">
                            <input type="text" id="edit_cupos" name="edit_cupos" class="form-control" placeholder="Cantidad de cupos">
                            <div id="msg_error_cupos" class="alert alert-danger object_hidden" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group">
                          <label class="col-sm-3" for="edit_profesor">Profesor:</label>
                          <div class="col-sm-9">
                            <select id="edit_profesor" name="edit_profesor">
                              <option value="null">--Perfil--</option>
                            </select>
                            <div id="msg_error_profesor" class="alert alert-danger object_hidden" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="row form-group text-center">
                          <button id="btn_guardar_edit" type="button" onclick="guardarModificacion()"  class="btn btn-primary"
                            data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Actualizando...">Actualizar</button>
                        </div>
                      </form>
                    </div>
                    <!-- /.col-lg-12 (nested) -->
                  </div>
                  <!-- /.row (nested) -->
                </div>
                  <!-- /.panel-body -->
              </div>
              <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- / Modal Editar usuario -->
