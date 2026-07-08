<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all") : ?>
  <div class="row">
    <div class="col-md-12">
      <div class="btn-group pull-right">
    <!--    <a href="./?view=posts&opt=new" class="btn btn-default"><i class='fa fa-th-list'></i> Nuevo Aviso</a>  -->
      </div>
      <h1>Notificaciones</h1>
      <br>

      <?php
      $teams = NotificacionesData::getAll();
      if (count($teams) > 0) {
        // si hay usuarios
      ?>
        <div class="box box-primary">
          <div class="box-body">
            <table class="table table-bordered datatable table-hover">
              <thead>
                <th>Mensaje</th>
                <th>Matricula</th>
                <th>Fecha</th>
                <th></th>
              </thead>
              <?php
              foreach ($teams as $team) {
              ?>
                <tr>
                  <td><?php echo $team->mensaje; ?></td>
                  <td> <?php echo $team->user_id; /* va ser igual al valor de la variable */ ?></td>
                  <td><?php echo $team->fecha; ?></td>
                  
               <!--   <td style="width:130px;"><a href="index.php?view=posts&opt=edit&id=<?php //echo $team->id; ?>" class="btn btn-warning btn-xs">Editar</a> <a href="index.php?action=posts&opt=del&id=<?php //echo $team->id; ?>" class="btn btn-danger btn-xs">Eliminar</a></td> -->
                  <td style="width:130px;"> <a href="index.php?action=notificaciones&opt=del&id=<?php echo $team->id; ?>" class="btn btn-danger btn-xs">Eliminar</a></td>
                </tr>
            <?php
              }
              echo "</table></div></div>";
            } else {
              echo "<p class='alert alert-danger'>No hay Notificaciones</p>";
            }
            ?>
            
          </div>
        </div>
      <?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "new") : ?>
        <div class="row">
          <div class="col-md-12">
            <h1>Nuevo Aviso</h1>
            <br>
            <form class="form-horizontal" enctype="multipart/form-data" method="post" id="addcategory" action="./?action=posts&opt=add" role="form">
              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Tipo*</label>
                <div class="col-md-6">
                  <select name="kind" required class="form-control">
                    <option value="1">General</option>
                    <option value="2">Maestros</option>
                    <option value="3">Padres</option>
                    <option value="4">Alumnos</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Titulo*</label>
                <div class="col-md-6">
                  <input type="text" name="title" required class="form-control" id="name" placeholder="Titulo">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Contenido*</label>
                <div class="col-md-6">
                  <textarea name="content" required rows="6" class="form-control" id="name" placeholder="Contenido"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Imagen*</label>
                <div class="col-md-6">
                  <input type="file" name="image" id="name" placeholder="Imagen">
                </div>
              </div>


              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">PDF(opcional)</label>
                <div class="col-md-6">
                  <input type="file" name="pdf" id="name" placeholder="pdf">
                </div>
              </div>



              <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                  <button type="submit" class="btn btn-primary">Agregar Aviso</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      <?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "edit") :
      $a = PostData::getById($_GET["id"]);
      ?>
        <div class="row">
          <div class="col-md-12">
            <h1>Editar Aviso</h1>
            <br>
            <form class="form-horizontal" enctype="multipart/form-data" method="post" id="addcategory" action="./?action=posts&opt=update" role="form">

              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Tipo*</label>
                <div class="col-md-6">
                  <select name="kind" required class="form-control">
                    <option value="1" <?php if ($a->kind == 1) {
                                        echo "selected";
                                      } ?>>General</option>
                    <option value="2" <?php if ($a->kind == 2) {
                                        echo "selected";
                                      } ?>>Maestros</option>
                    <option value="3" <?php if ($a->kind == 3) {
                                        echo "selected";
                                      } ?>>Padres</option>
                    <option value="4" <?php if ($a->kind == 4) {
                                        echo "selected";
                                      } ?>>Alumnos</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Titulo*</label>
                <div class="col-md-6">
                  <input type="text" name="title" value="<?php echo $a->title; ?>" required class="form-control" id="name" placeholder="Titulo">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Contenido*</label>
                <div class="col-md-6">
                  <textarea name="content" required class="form-control" rows="6" id="name" placeholder="Contenido"><?php echo $a->content; ?></textarea>
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Imagen*</label>
                <div class="col-md-6">
                  <input type="file" name="image" id="name" placeholder="Imagen">
                  <br>
                  <img src="../storage/posts/<?php echo $a->image; ?>" class="img-responsive">
                </div>
              </div>




              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">PDF*</label>
                <div class="col-md-6">
                  <input type="file" name="pdf" id="name" placeholder="pdf">
                  <br>
                  Nombre del Documento Cargado: <?php echo $a->pdf; ?>
                </div>
              </div>


              <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                  <input type="hidden" name="id" value="<?php echo $a->id; ?>">
                  <button type="submit" class="btn btn-success">Actualizar Aviso</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      <?php endif; ?>