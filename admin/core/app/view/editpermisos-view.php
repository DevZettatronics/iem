<?php 
$rol = $_GET["id"]; 
$rol_nombre =$_GET["name"];
?>
<style>
  /* Header azul fuerte con texto blanco */
  .table thead th {
    background-color: #003366;
    color: white;
    position: sticky;
    top: 0;
    z-index: 10;
  }

  /* Hover azul fuerte en filas */
  .table-hover tbody tr:hover {
    background-color: #003366;
    color: white;
    cursor: pointer;
  }
</style>
<style>
  /* Botones en línea con espacio */
  .btn-group-permisos {
    margin-bottom: 15px;
  }
</style>
<div class="row">
  <div class="col-md-12">
    <h1>Editar Permisos de <?php echo $rol_nombre; ?></h1>
    <br>
    <?php
    $permisos = Permisos::allpermisos($rol);
    ?>
    <?php if (empty($permisos)): ?>
      <div class="alert alert-warning">No se encontraron permisos para este usuario.</div>
    <?php else: ?>
      <form class="form-horizontal" method="post" id="editPermissions" action="index.php?view=updatePermisos" autocomplete="off" role="form">
        <p class="alert alert-info">* Campos obligatorios</p>
        <div class="btn-group-permisos">
          <a href="index.php?view=roles" class="btn  btn-sm text-secondary">Regresar</a>
          <button type="button" id="btnMarcarTodos" class="btn btn-success btn-sm">Marcar Todos</button>
          <button type="button" id="btnDesmarcarTodos" class="btn btn-danger btn-sm">Desmarcar Todos</button>
        </div>
        <div style="max-height: 600px; overflow-y: auto;">
          <table id="tablaPermisos" class="table table-bordered  table-hover" data-page-length="100">
           <thead class="bg-primary text-white" style="position: sticky; top: 0; z-index: 10;">
              <tr>
                <th>ID</th>
                <th>Módulo</th>
                <th>Tipo</th>
                <th>Ver</th>
                <th>Crear</th>
                <th>Editar</th>
                <th>Eliminar</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($permisos as $permiso): ?>
                <tr>
                  <td><?php echo $permiso->id_permiso?></td>
                  <td><?php echo htmlspecialchars($permiso->nombre); ?></td>
                  <td>
                      <?php
                        if ($permiso->es_padre == 1) {
                          echo "<span class='badge bg-success'>Padre</span>";
                        }elseif ($permiso->es_padre == 2) {
                          echo "<span class='badge bg-warning'>Bloque</span>";
                        }elseif ($permiso->es_padre == 0) {
                          echo "<span class='badge bg-danger'>Hijo</span>";
                        }
                      ?>
                  </td>
                  
                  <?php
                    $id = $permiso->id_permiso;
                    $fields = ['puede_ver', 'puede_crear', 'puede_editar', 'puede_eliminar'];
                  ?>

                  <?php foreach ($fields as $field): ?>
                    <?php
                      $checked = $permiso->$field ? 'checked' : '';
                      $input_id = "permiso_{$id}_{$field}";
                    ?>
                    <td class="text-center">
                      <input 
                        type="checkbox" 
                        id="<?php echo $input_id; ?>" 
                        name="permisos[<?php echo $id; ?>][<?php echo $field; ?>]" 
                        value="1" <?php echo $checked; ?>>
                      <label for="<?php echo $input_id; ?>" class="sr-only"><?php echo ucfirst(str_replace('_', ' ', $field)); ?></label>
                    </td>
                  <?php endforeach; ?>

                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <input type="hidden" name="rol_id" value="<?php echo $rol; ?>">
        <input type="hidden" name="rol_nombre" value="<?php echo $rol_nombre; ?>">
        <br><br>
        <div class="text-center mt-3">
          <button type="submit" class="btn btn-success">Actualizar Permisos</button>
        </div>
      </form>
    <?php endif; ?>
  </div>
</div>
<script>
  document.getElementById('btnMarcarTodos').addEventListener('click', function() {
    document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = true);
  });

  document.getElementById('btnDesmarcarTodos').addEventListener('click', function() {
    document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
  });
</script>
<script>
  $(document).ready(function() {
    $('#tablaPermisos').DataTable({
      "order": [],        // para que no ordene automáticamente
      "pageLength": 100   // conserva el paginado que quieres
      "searching": false     // 🔍 desactiva el buscador
    });
  });
</script>
