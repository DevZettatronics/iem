<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all") : ?>
<div class="row">
  <div class="col-md-12">
   
    
    <h3><img src="../storage/posts/beca.png"  width="52px"> <strong>Catálogo de Beca</strong></h3>
	<h5>La información mostrada en este espacio tiene la finalidad de dar de alta, modificar o eliminar <strong>becas</strong> dadas de alta en el sistema. </h5>

    <a href="./?view=alumns" class="btn btn-default"><i class="fa fa-arrow-left"></i> Ir a Estudiantes</a>
    <a href="./?view=becas&opt=new" class="btn btn-default"><i class='fa fa-th-list'></i> Nueva Beca</a>
    <br>
    <br>
    <?php
    $teams = BecasData::getType1();
    if (count($teams) > 0) {
      // si hay usuarios
    ?>
      <div class="box box-primary">
        <div class="box-body">
          <table class="table table-bordered datatable table-hover" data-page-length="100">
            <thead class="bg-warning font-weight-bold p-3 text-left">
              <th>Nombre</th>
              <th>Porcentaje</th>
              <th>Descripcion</th>
              <th>Estado</th>
              <th></th>
            </thead>
            <?php
            foreach ($teams as $team) {
              if ($team->state == 1) {
                $lbl_status = "Activo";
              } elseif ($team->state == 2) {
                $lbl_status = "Inactivo";
              }
            ?>
              <tr>
                <td><?php echo $team->name; ?></td>
                <td> <?php echo $team->porcentaje; ?>%</td>
                <td> <?php echo $team->descripcion; ?></td>
                <td> <?php echo $lbl_status; ?></td>
                <td style="width:130px;"><a href="index.php?view=becas&opt=edit&id=<?php echo $team->id; ?>" class="btn btn-warning btn-xs">Editar</a> <a href="index.php?action=becas&opt=del&id=<?php echo $team->id; ?>" class="btn btn-danger btn-xs">Eliminar</a></td>
              </tr>
          <?php
            }
            echo "</table></div></div>";
          } else {
            echo "<p class='alert alert-danger'>No hay Becas</p>";
          }
          ?>
        </div>
      </div>
      
      
      
      
      
    <?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "new") : ?>
      <div class="row">
        <div class="col-md-12">
          <h1>Nueva Beca</h1>
          <br>
          <form class="form-horizontal" method="post" id="addcategory" action="./?action=becas&opt=add" role="form">
            <div class="form-group">
              <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
              <div class="col-md-6">
                <input type="text" name="name" required class="form-control" id="name" placeholder="Nombre">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail1" class="col-lg-2 control-label">Porcentaje*</label>
              <div class="col-md-6">
                <input type="number" step="any" name="porcentaje" required class="form-control" id="name" placeholder="Descuento" min="0" max="100">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail1" class="col-lg-2 control-label">Descripcion*</label>
              <div class="col-md-6">
                <input type="text" name="descripcion" required class="form-control" id="name" placeholder="Descripcion">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6">
                <input type="hidden" name="tipo" required class="form-control" id="tipo" placeholder="Tipo" value="1" readonly>
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail1" class="col-lg-2 control-label">Estado*</label>
              <div class="col-md-6">
                <select name="state" id="state" required class="form-control">
                  <option value="NULL">-- SELECCIONA --</option>
                  <?php
                  $con = Database::getCon();
                  $sql_1 = "SELECT * FROM estatus";
                  $query_1 = mysqli_query($con, $sql_1);
                  while ($row_1 = mysqli_fetch_array($query_1)) {
                  ?>
                    <option value="<?php echo $row_1['id'] ?>"><?php echo ($row_1['name']) ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-offset-2 col-lg-10">
              <button type="submit" class="btn btn-success">Agregar Beca </button>
                <a href="javascript:history.back()" onclick="mostrarAlerta()" class="btn btn-primary">Cancelar</a>
                <script>
                  function mostrarAlerta() {
                    alert("Los cambios fueron cancelados.");
                  }
                </script>
              </div>
            </div>
          </form>
        </div>
      </div>
    <?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "edit") :
    $a = BecasData::getById($_GET["id"]);
    ?>
      <div class="row">
        <div class="col-md-12">
          <h1>Editar Beca</h1>
          <br>
          <form class="form-horizontal" method="post" id="addcategory" action="./?action=becas&opt=update" role="form">
            <div class="form-group">
              <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
              <div class="col-md-6">
                <input type="text" name="name" value="<?php echo $a->name; ?>" required class="form-control" id="name" placeholder="Nombre">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail1" class="col-lg-2 control-label">Porcentaje*</label>
              <div class="col-md-6">
                <input type="number" step="any" name="porcentaje" value="<?php echo $a->porcentaje; ?>" required class="form-control" id="name" placeholder="Porcentaje" min="0" max="100">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail1" class="col-lg-2 control-label">Descripcion*</label>
              <div class="col-md-6">
                <input type="text" name="descripcion" value="<?php echo $a->descripcion; ?>" required class="form-control" id="name" placeholder="Descripcion">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail1" class="col-lg-2 control-label">Estado*</label>
              <?php
              $con = Database::getCon();
              $s1l2 = "SELECT * FROM estatus WHERE id = '" . $a->state . "'";
              $qyery2 = mysqli_query($con, $s1l2);
              $row2 = mysqli_fetch_array($qyery2);
              $estatus_name = $row2['name'];
              ?>
              <div class="col-md-6">
                <select name="state" id="state" class="form-control">
                  <option value="<?php echo $a->state; ?>" selected><?php echo $estatus_name; ?></option>
                  <?php
                  $con = Database::getCon();
                  $sql_1 = "SELECT * FROM estatus";
                  $query_1 = mysqli_query($con, $sql_1);
                  while ($row_1 = mysqli_fetch_array($query_1)) {
                  ?>
                    <option value="<?php echo $row_1['id'] ?>"><?php echo ($row_1['name']) ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-offset-2 col-lg-10">
              
                <input type="hidden" name="id" value="<?php echo $a->id; ?>">
                <button type="submit" class="btn btn-success">Actualizar Beca</button>
                
                <a href="javascript:history.back()" onclick="mostrarAlerta()" class="btn btn-primary">Cancelar</a>
                <script>
                  function mostrarAlerta() {
                    alert("Los cambios fueron cancelados.");
                  }
                </script>
              </div>
            </div>
          </form>
        </div>
      </div>
    <?php endif; ?>