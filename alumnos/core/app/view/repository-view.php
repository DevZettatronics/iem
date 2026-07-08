<?php
$con = Database::getCon();
if (isset($_GET["code"])) {
  $code = intval($_GET["code"]);
  $query = mysqli_query($con, "SELECT * FROM repository WHERE code_person = '$code'");
  $num = mysqli_num_rows($query);
  if ($num > 0) {
?>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
                      <h3><img src="../storage/posts/expediente.png"  width="52px"> <strong>Documentos Cargados</strong></h3>
 
			
			<a href="./?view=edituser&id=<?php if (isset($_SESSION["alumn_id"])) {
                                                            echo PersonData::getById($_SESSION["alumn_id"])->id;
                                                          } ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a> 

<br><br>
          <div class="box box-primary">
            <div class="box-body">
              <table class="table table-bordered datatable table-hover">
                <thead>
                  <th>Nombre</th>
                
                  <th class="text-center">Estatus</th>
                  <th class="text-center">Visualizar</th>
                </thead>
                <?php
                while ($rw = mysqli_fetch_array($query)) {
                  if ($rw['status'] == "1") {
                    $lbl_status = "Sin Validar";
                    $lbl_icon = "fa fa-times-circle";
                    $lbl_class = 'btn label-danger';
                  } elseif ($rw['status'] == "2") {
                    $lbl_status = "Validado";
                    $lbl_icon = "fa fa-check-circle";
                    $lbl_class = 'btn bg-green';
                  }
                ?>
                  <tr>
                    <td style="font-size: 10px;"><?php echo $rw['file']; ?> <strong>Fecha de carga </strong><?php echo $rw['date_added']; ?></td>
             
                    <td class="text-center">
                      <span class="<?php echo $lbl_class ?>"><i class="<?php echo $lbl_icon ?>"> </i> <?php echo $lbl_status ?> </span>
                    </td>
                    <td class="col-md-1 text-center">
                      <div class="btn-group pull-center">
                        <a target="_blank" title="Ver Archivo" href="core/app/repository/<?php echo $code . "/" . $rw['file'] ?>"> <span class="fa fa-eye fa-2x" style="color: #001F3F;" aria-hidden="true"></span> </a>
                      </div>
                    </td>
                  </tr>
                <?php } ?>


              </table>
            </div>
          </div>
        </div>
      </div>
    </section>


<?php
  } else {
    echo "<p class='alert alert-danger'>No haz cargado documentos</p>";
  }
}
?>