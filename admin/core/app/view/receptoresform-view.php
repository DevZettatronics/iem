<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all") : ?>
    <?php
    $receptor = ReceptoresData::getAll();
    $con = Database::getCon();
if (count($receptor) > 0) {

    // si hay usuarios

?>
<h1>Receptores</h1>

<a href="./?view=receptoresform&opt=new" class="btn btn-default"><i class="fa fa-plus"></i> Nuevo Receptor</a>

<br>

<br>
    <div class="box box-primary">

        <div class="box-body">

            <table class="table table-bordered datatable table-hover">

                <thead class="bg-primary font-weight-bold p-3 text-left">

                    <th>Razón Social</th>

                    <th>Dirección</th>

                    <th>Régimen Fiscal</th>

                    <th>Acciones</th>

                </thead>

                <?php

                foreach ($receptor as $recep) {

                    /* id receptor */
                    $id_receptor = $recep->id;
                    /*Nombre completo */

                    $name = $recep->name;
                    $lastname = $recep->last_name;

                    /*****************/

                    /* Direccion */

                    $direccion = $recep->address1;
                    $city = $recep->city;

                    /*****************/

                    /* Alumno */

                    $errefece = $recep->rfc;

                    /*****************/

                    /* Régimen Fiscal */

                    $id_regimen = $recep->regimen;

                    $query = mysqli_query ($con,"SELECT * FROM c_regimenfiscal WHERE idregimenfiscal = '".$id_regimen."' ");

                    $arr = mysqli_fetch_array($query);

                    $descripcion = $arr['Descripcion'];
                    
                    $RegimenFiscal = $arr['c_RegimenFiscal'];

                    /*****************/

                ?>

                    <tr>

                        <td>
                            <p>
                            
                            
                            <strong>
                            <?php echo $name." ".$lastname; ?></strong>
                             <br>
                            RFC: <?php echo $errefece; ?>
                           
                            </p>
                        </td>

                        <td>
                            <p>
                            Calle y Número: <?php echo $direccion; ?> <br>
                            Ciudad: <?php echo $city; ?> <br>
                            Estado: <br>
                            Delegación | Municipio: <br>
                            CP: <br>
                            </p>
                        </td>

                        <td>
                            
                            <?php echo $RegimenFiscal; ?> -
                            <?php echo $descripcion; ?>
                        </td>

                        <td>



                            <!--   <a href="index.php?action=planpago&opt=val&id=?php echo $pay->id; ?>" class="btn btn-success btn-xs"><i class="fa fa-check-circle"></i></a> -->

                            <a href="index.php?view=receptoresform&opt=edit&id=<?php echo $id_receptor; ?>" class="btn btn-warning btn-xs">Editar</a>

                            <a href="index.php?action=receptoresadd&opt=del&id=<?php echo $id_receptor; ?>" class="btn btn-danger btn-xs">Eliminar</a>



                        </td>

                    </tr>

                    <?php

                    /* $con = Database::getCon();

                    $sumaT   = mysqli_query($con, "SELECT sum(importe) as importe FROM $tables where $sWhere"); */ ?>

            <?php

                }

                echo "</table></div></div>";
            } else {

                ?>
                <a href="./?view=receptoresform&opt=new" class="btn btn-default"><i class="fa fa-dollar"></i> Nuevo Receptor</a> <br><br><br>
                <?php
                echo "<p class='alert alert-danger'>No hay receptores registrados</p>";
            }

            ?>

            </table>

            
<?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "new") : ?>
                <?php  $con = Database::getCon(); ?>

                <div class="row">

                    <div class="col-md-12">

                        <h1>Registro</h1>

                        <br>

                        <form class="form-horizontal" method="post" id="addcategory" action="./?action=receptoresadd&opt=add" role="form" enctype="multipart/form-data">

                        <div class="tab-content">

						 <div class="active tab-pane" id="activity">

							<div class="row">

								<div class='col-md-12'>

									<br>

									<div style="font-size:14px;	font-weight:bold;border-bottom: 1px solid #000;padding: 5px 5px 5px 0px;width:100%;margin-bottom:10px">Datos</div>

								</div>

								<div class='col-md-6'>

									<label for="first_name">Nombre(s)*</label>

									<input type="text" class="form-control" id="first_name" maxlength="100" name="first_name" required>

								</div>

								<div class='col-md-6'>

									<label for="last_name">Apellidos*</label>

									<input type="text" class="form-control" id="last_name" maxlength="100" name="last_name" required>

								</div>

								<div class='col-md-12'>

									<div class="row">

										<div class='col-md-6'>

											<label for="rfc">RFC</label>

											<input type="text" class="form-control" minlength="12" maxlength="13" id="rfc" name="rfc" onchange="validarfc();" maxlength="13">

										</div>

										<br>

										<div class='col-md-6'>

											<b>Empresa</b>

											<input type="checkbox" name="check" id="check" onclick="ShowEmpresa()" />

										</div>

									</div>

								</div>

							</div>

							<div class="row" id="tipo" style="display: none;">

								<div class='col-md-12'>

									<div style="font-size:14px;	font-weight:bold;border-bottom: 1px solid #000;padding: 5px 5px 5px 0px;width:100%;margin-bottom:10px">Empresa</div>

									<label for="bussines_name">Nombre del establecimiento y/o Razón Social </label>

									<input type="text" class="form-control" id="bussines_name" name="bussines_name" maxlength="100">

									<div class="row">



									</div>

								</div>

							</div>

							<div class="row">

								<div class='col-md-12'>

									<div style="font-size:14px;	font-weight:bold;border-bottom: 1px solid #000;padding: 5px 5px 5px 0px;width:100%;margin-bottom:10px">Contacto</div>

									<div class="row">

										<div class='col-md-6'>

											<label for="phone">Teléfono *</label>

											<input type="text" class="form-control" id="phone" name="phone" maxlength="10" required>

										</div>



										<div class='col-md-6'>

											<label for="email">Correo Electrónico</label>

											<input type="email" class="form-control" maxlength="100" id="email" name="email" required>

										</div>

										<div class='col-md-6'>

											<label for="descuento">Descuento Porcentaje</label>

											<select required class="form-control" data-live-search="true" name="descuento" id="descuento">

												<option value="">Seleccione</option>

												<?php

												$sql_cu = mysqli_query($con, "SELECT * FROM descuentos ;");

												while ($rwcu = mysqli_fetch_array($sql_cu)) {

													$idd = $rwcu['id'];

													$porcentaje = $rwcu['porcentaje'];

												?>

													<!-- "ID:".$rw['id']." ". -->

													<option class="text-left" value="<?php echo $idd; ?>"><?php echo $porcentaje;   ?></option>

												<?php }

												?>

											</select>

										</div>



										<div class="col-md-6">

											<label for="regimen" class="control-label">Regimen Fiscal</label>

											<?php

											$regSql = mysqli_query($con, "SELECT * FROM c_regimenfiscal;");

											?>

											<select class='form-control select2' name="regimen" id="regimen">

												<option value="">Seleccione</option>

												<?php

												while ($rwReg = mysqli_fetch_array($regSql)) {

													$idReg = $rwReg['idregimenfiscal'];

													$reg = $rwReg['c_RegimenFiscal'];

													$descReg = $rwReg['Descripcion'];

													$fiReg = $rwReg['Fisica'];

													$moReg = $rwReg['Moral'];

												?>

													<option value="<?php echo $idReg ?>"><?php echo $reg . " " . $descReg ?></option>

												<?php



												}

												?>

											</select>

										</div>

									</div>

								</div>
                                            </div>

  					</div><!-- /.tab-pane -->
                      <div class="row">

<div class='col-md-12'>

    <br>

    <div style="font-size:14px;	font-weight:bold;border-bottom: 1px solid #000;padding: 5px 5px 5px 0px;width:100%;margin-bottom:10px">Dirección</div>

</div>

<div class='col-md-6'>

    <label for="country">País</label>

    <input type="text" class="form-control" maxlength="100" id="country" name="country">

</div>

<div class='col-md-6'>

    <label for="state">Estado</label>

    <input type="text" class="form-control" maxlength="100" id="state" name="state">

</div>



</div>



<div class="row">

<div class='col-md-6'>

    <label for="city">Ciudad</label>

    <input type="text" class="form-control" maxlength="100" id="city" name="city">

</div>



<div class='col-md-6'>

    <label for="address1">Calle y número</label>

    <input type="text" class="form-control" maxlength="100" id="address1" name="address1">

</div>



</div>





<div class="row">



<div class='col-md-6'>

    <label for="postal_code">Código Postal</label>

    <input type="text" class="form-control" maxlength="5" id="postal_code" name="postal_code" required>

</div>

<div class='col-md-6'>

    <label for="muni">Municipio</label>

    <input type="text" class="form-control" id="muni" name="muni" required>

</div>



</div>





</div><!-- /.tab-content -->

<br><br>

                            <div class="form-group">

                                <div class="col-lg-2 col-lg-10">

                                    <button type="submit" class="btn btn-primary">Agregar</button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

                <!--Actualizar de Receptor -->


            <?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "edit") : ?>

<?php
$id= $_GET["id"];
$recept = ReceptoresData::getById($id);
$con = Database::getCon();

if ($recept==TRUE) {
// si hay usuarios
foreach($recept as $receptor ){
$nombre = $receptor->name;
$apellido = $receptor->last_name;
$direccion_num = $receptor->address1;
$ciudad = $receptor->city;
$estado = $receptor->state;
$codigo_postal = $receptor->postal_code;
$municipio = $receptor->muni;
$rfc_recep = $receptor->rfc;
$pais = $receptor->country;
$razon_id = $receptor->razon;
$descuento = $receptor->descuento;
$regimen = $receptor->regimen;
$telefono = $receptor->telefono;
$email = $receptor->email;
}

$query = mysqli_query ($con,"SELECT * FROM c_regimenfiscal WHERE idregimenfiscal = '".$regimen."' ");

$arr = mysqli_fetch_array($query);

$name_regimen = $arr['Descripcion'];
?>

            <div class="row">

                <div class="col-md-12">

                    <h1>Editar Receptor</h1>

                    <br>

                    <form class="form-horizontal" method="post" id="addcategory" action="./?action=receptoresadd&opt=update" role="form" enctype="multipart/form-data">

                    <div class="tab-content">

                     <div class="active tab-pane" id="activity">

                        <div class="row">

                            <div class='col-md-12'>

                                <br>

                                <div style="font-size:14px;	font-weight:bold;border-bottom: 1px solid #000;padding: 5px 5px 5px 0px;width:100%;margin-bottom:10px">Datos</div>

                            </div>
                            <input type = "hidden" class="form-control" id="id_customer" maxlength="100" name="id_customer" value="<?php echo $id;?>"required>

                            <div class='col-md-6'>

                                <label for="first_name">Nombre(s)*</label>

                                <input type="text" class="form-control" id="first_name" maxlength="100" name="first_name" value="<?php echo $nombre;?>"required>

                            </div>

                            <div class='col-md-6'>

                                <label for="last_name">Apellidos*</label>

                                <input type="text" class="form-control" id="last_name" maxlength="100" name="last_name" value="<?php echo $apellido;?>"required>

                            </div>

                            <div class='col-md-12'>

                                <div class="row">

                                    <div class='col-md-6'>

                                        <label for="rfc">RFC</label>

                                        <input type="text" class="form-control" minlength="12" maxlength="13" id="rfc" name="rfc" value="<?php echo $rfc_recep?>" maxlength="13">

                                    </div>

                                    <br>

                                    <div class='col-md-6'>

                                        <b>Empresa</b>

                                        <input type="checkbox" name="check" id="check" onclick="ShowEmpresa()" />

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="row" id="tipo" style="display: none;">

                            <div class='col-md-12'>

                                <div style="font-size:14px;	font-weight:bold;border-bottom: 1px solid #000;padding: 5px 5px 5px 0px;width:100%;margin-bottom:10px">Empresa</div>

                                <label for="bussines_name">Nombre del establecimiento y/o Razón Social </label>

                                <input type="text" class="form-control" id="bussines_name" name="bussines_name" value="<?php echo $razon_nombre?>"maxlength="100">

                                <div class="row">



                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class='col-md-12'>

                                <div style="font-size:14px;	font-weight:bold;border-bottom: 1px solid #000;padding: 5px 5px 5px 0px;width:100%;margin-bottom:10px">Contacto</div>

                                <div class="row">

                                    <div class='col-md-6'>

                                        <label for="phone">Teléfono *</label>

                                        <input type="text" class="form-control" id="phone" name="phone" maxlength="10" value="<?php echo $telefono;?>"required>

                                    </div>



                                    <div class='col-md-6'>

                                        <label for="email">Correo Electrónico</label>

                                        <input type="email" class="form-control" maxlength="100" id="email" name="email" value="<?php echo $email;?>" required>

                                    </div>

                                    <?php                                             
                                    $sql_cu = mysqli_query($con, "SELECT * FROM descuentos WHERE id = '$descuento';");

                                    while ($rwcu = mysqli_fetch_array($sql_cu)) {

                                        $iddd = $rwcu['id'];

                                        $porcentaj = $rwcu['porcentaje'];
                                    }
                                    ?>
                                    <div class='col-md-6'>

                                        <label for="descuento">Descuento Porcentaje</label>

                                        <select required class="form-control" data-live-search="true" name="descuento" id="descuento">

                                            <option value="<?php echo $iddd;?>"><?php echo $porcentaj;?></option>

                                            <?php

                                            $sql_cu = mysqli_query($con, "SELECT * FROM descuentos ;");

                                            while ($rwcu = mysqli_fetch_array($sql_cu)) {

                                                $idd = $rwcu['id'];

                                                $porcentaje = $rwcu['porcentaje'];

                                            ?>

                                                <!-- "ID:".$rw['id']." ". -->

                                                <option class="text-left" value="<?php echo $idd; ?>"><?php echo $porcentaje;   ?></option>

                                            <?php }

                                            ?>

                                        </select>

                                    </div>

                                    <div class="col-md-6">

<label for="regimen" class="control-label">Regimen Fiscal</label>

<?php

$regSql = mysqli_query($con, "SELECT * FROM c_regimenfiscal;");
$sql_cu = mysqli_query($con, "SELECT * FROM c_regimenfiscal WHERE idregimenfiscal = '$regimen';");

while ($rwcu = mysqli_fetch_array($sql_cu)) {

    $id = $rwcu['idregimenfiscal'];

    $id_reg = $rwcu['c_RegimenFiscal'];

    $descri = $rwcu['Descripcion'];
}
?>

<select class='form-control select2' name="regimen" id="regimen">

    <option value="<?php echo $id?>"><?php echo "$id_reg"." "."$descri"?></option>

    <?php

    while ($rwReg = mysqli_fetch_array($regSql)) {

        $idReg = $rwReg['idregimenfiscal'];

        $reg = $rwReg['c_RegimenFiscal'];

        $descReg = $rwReg['Descripcion'];

        $fiReg = $rwReg['Fisica'];

        $moReg = $rwReg['Moral'];

    ?>

        <option value="<?php echo $idReg ?>"><?php echo $reg . " " . $descReg ?></option>

    <?php



    }

    ?>

</select>

</div>

                                </div>

                            </div>
                                        </div>

                  </div><!-- /.tab-pane -->
                  <div class="row">

<div class='col-md-12'>

<br>

<div style="font-size:14px;	font-weight:bold;border-bottom: 1px solid #000;padding: 5px 5px 5px 0px;width:100%;margin-bottom:10px">Dirección</div>

</div>

<div class='col-md-6'>

<label for="country">País</label>

<input type="text" class="form-control" maxlength="100" id="country" name="country" value="<?php echo $pais;?>">

</div>

<div class='col-md-6'>

<label for="state">Estado</label>

<input type="text" class="form-control" maxlength="100" id="state" name="state" value="<?php echo $estado;?>">

</div>



</div>



<div class="row">

<div class='col-md-6'>

<label for="city">Ciudad</label>

<input type="text" class="form-control" maxlength="100" id="city" name="city" value="<?php echo $ciudad;?>">

</div>



<div class='col-md-6'>

<label for="address1">Calle y número</label>

<input type="text" class="form-control" maxlength="100" id="address1" name="address1" value="<?php echo $direccion_num;?>">

</div>



</div>





<div class="row">



<div class='col-md-6'>

<label for="postal_code">Código Postal</label>

<input type="text" class="form-control" maxlength="5" id="postal_code" name="postal_code" value="<?php echo $codigo_postal;?>"required>

</div>

<div class='col-md-6'>

<label for="muni">Municipio</label>

<input type="text" class="form-control" id="muni" name="muni" value="<?php echo $municipio;?>" required>

</div>



</div>





</div><!-- /.tab-content -->

<br><br>

                        <div class="form-group">

                            <div class="col-lg-2 col-lg-10">

                                <button type="submit" class="btn btn-primary">Actualizar Datos</button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>



            <?php  } endif; ?>

            <script>

                // para que no se abra el select

                $('#periodo_as').on('mousedown', function(e) {

                    e.preventDefault();

                    this.blur();

                    window.focus();

                });

            </script>



            <script>

                $('[id="select"]').selectpicker();

            </script>

            <script>

                function ShowEmpresa() {
                var checkbox = document.getElementById("check");
                var tipo = document.getElementById("tipo");
                var nombre = document.getElementById("first_name");
                var apellido = document.getElementById("last_name");
                if (checkbox.checked) {
                    tipo.style.display = "block";
                    apellido.removeAttribute('required');
                    nombre.removeAttribute('required');
                } else {
                    tipo.style.display = "none";
                    apellido.setAttribute('required', '');
                    
                }
                }

            </script>

            <!-- FIn del script -->