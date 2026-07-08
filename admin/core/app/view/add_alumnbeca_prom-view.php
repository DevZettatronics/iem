<?php
$con = Database::getCon();
if (isset($_GET["opt"]) && $_GET["opt"] == "editb") :
  $a = PersonData::getById($_GET["id"]);
?>
  <div class="row">
    <div class="col-md-12">

      <h3><img src="../storage/posts/beca.png"  width="52px"> <strong>Asignar Beca y Promoción</strong></h3>
		<h5>La información mostrada en este espacio tiene la finalidad de modificar o asignar becas e inscripciones vigentes a cada <strong>estudiante</strong> dado de alta en el sistema. </h5>

      <a href="./?view=alumns" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
      <br>
      <br>
      <form class="form-horizontal" method="post" id="addcategory" action="index.php?action=alumns&opt=editb" role="form">

            <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">PROMOCIÓN EN INSCRIPCIÓN</label>
                <div class="col-md-6">
                <select class="form-control" name="promoc" id="promoc">
                  <option value="<?php echo $a->promocion ?>" selected> <?php echo  $nom_promo ?> - <?php echo $por_promo . "%" ?></option>
                  <?php foreach (BecasData::getPromociones() as $promos) : ?>
                    <option value="<?php echo $promos->id; ?>"><?php echo $promos->name; ?> - <?php echo $promos->porcentaje . "%" ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            
            
        
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">BECA</label>
          <div class="col-md-6">
            <?php
            $sql_beca = "SELECT * FROM becas WHERE id = '" . $a->beca . "'";
            $query_beca = mysqli_query($con, $sql_beca);
            $beca = mysqli_fetch_array($query_beca);
            $id_beca = $beca['id'];
            $nom_beca = $beca['name'];
            $por_beca = $beca['porcentaje'];

            $sql_promo = "SELECT * FROM becas WHERE id = '" . $a->promocion . "'";
            $query_promo = mysqli_query($con, $sql_promo);
            $promo = mysqli_fetch_array($query_promo);
            $id_promo = $promo['id'];
            $nom_promo = $promo['name'];
            $por_promo = $promo['porcentaje'];
            ?>
            <input type="hidden" name="name" id="name" value="<?php echo $a->name; ?>">
            <input type="hidden" name="lastname" id="lastname" value="<?php echo $a->lastname; ?>">
            <input type="hidden" name="code" id="code" value="<?php echo $a->code; ?>">
            <input type="hidden" name="email" id="email" value="<?php echo $a->email; ?>">

            <select class="form-control" name="beca" id="beca">
              <option value="<?php echo $a->beca ?>" selected> <?php echo  $nom_beca ?> - <?php echo $por_beca . "%" ?></option>
              <?php foreach (BecasData::getBeca() as $beca) : ?>
                <option value="<?php echo $beca->id; ?>"><?php echo $beca->name; ?> - <?php echo $beca->porcentaje . "%" ?></option>
              <?php endforeach; ?>
            </select>
            </div></div>
            
            

            
            
            
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <input type="hidden" name="id" value="<?php echo $a->id; ?>"> <!-- actualiza los datos por ID -->
            <button type="submit" class="btn btn-primary">Actualizar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php endif; ?>