<!-- Modal -->
<div class="modal fade" id="modalEstadoview" tabindex="-1" role="dialog" aria-labelledby="modalEstadoview">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        
            <div class="modal-header">
                <h5 class="modal-title">Estado del alumno</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                    <input type="hidden" id="alumno_id">

                <!-- Estado del alumno (OBLIGATORIO) -->
                <div class="form-group">
                    <label for="estado_alumno">Estado del alumno</label>
                    <select class="form-control" id="estado_alumno" name="estado_alumno" required>
                        <option value="">Seleccione una opción</option>
                        <option value="1">Baja administrativa</option>
                        <option value="2">Baja temporal</option>
                        <option value="3">Baja definitiva</option>
                        <option value="4">Baja académica</option>
                        <option value="5">Activo</option>
                        <option value="6">Egresados titulado</option>
                        <option value="7">Egresados en vía de titulación</option>
                    </select>
                </div>

                <!-- Comentario (NO obligatorio) -->
                <div class="form-group">
                    <label for="comentario">Comentario</label>
                    <textarea id="comentario" name="comentario" class="form-control" rows="3"></textarea>
                </div>

                <!-- Fecha (OBLIGATORIA) -->
                <div class="form-group">
                    <label for="fecha_estado">Fecha de actualización</label>
                    <input type="date" id="fecha_estado" name="fecha_estado" class="form-control" required>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-success" id="guardar_estado">
                    Guardar
                </button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal para mostrar historial de estatus -->
<div class="modal fade" id="modalMensaje" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Historial del estatus del alumno</h5>
        <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <!-- 📌 TABLA DE HISTORIAL -->
        <div class="table-responsive mb-4 tabla-scroll">
          <table class="table table-bordered table-striped" id="tablaHistorial">
            <thead class="thead-light">
              <tr>
                <th>ID</th>
                <th>Estado</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th style="width: 40%;">Mensaje</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>

