<?php include "header.php"; ?>
<script type="text/javascript" src="js/mis_electivas.js?n=<?= time() ?>"></script>
<div id="page-wrapper">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-user fa-fw"></i> Mis Electivas</h1>
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row" id="datos">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <button id="btn_agregar" type="button" class="btn btn-default btn-circle btn-lg" onclick="abrirNuevoElectiva()">
            <i class="fa fa-plus"></i>
          </button> Registrar electiva
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <div class="dataTable_wrapper table-responsive">
            <table class="table table-striped table-bordered table-hover " id="tabla_electivas">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Profesor</th>
                  <th>Cupos Disponibles</th>
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
  <!-- Modal Registro electiva -->
  <div class="modal fade" id="modalRegistroElectiva" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-users fa-fw"></i> Registrar Electiva</h4>
        </div>
        <div class="modal-body">
            <div class="col">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  Nuevo Electiva
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <form id="form_registro_electiva" role="form">
                        <div class="row form-group">
                          <label class="col-sm-3" for="new_perfil">Electiva:</label>
                          <div class="col-sm-9">
                            <select id="new_electiva" name="new_electiva">
                            </select>
                            <div id="msg_error_electiva" class="alert alert-danger object_hidden" role="alert">Campo requerido</div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div id="info_electiva" class="panel panel-success object_hidden">
                            <div class="panel-heading">
                              <h3 class="panel-title">Información</h3>
                            </div>
                            <div class="panel-body">
                            </div>
                          </div>
                        </div>
                        <div class="row form-group text-center">
                          <button id="btn_guardar_nuevo" type="button" onclick="guardarNuevo()"  class="btn btn-primary"
                            data-loading-text="<i class='fa fa-spinner fa-pulse fa-fw'></i> Guardando...">Registrar</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Cancelar</button>
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
</div>
