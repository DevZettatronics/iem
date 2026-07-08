<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<?php
if (isset($_GET["code"])) {
    $code = intval($_GET["code"]);
    $alumn = PersonData::getByCodeAlumn($code);
    $recibos = RecibosData::getByCodeId($alumn->code);
?>
    <!-- Inicio de tabla   -->
   
    
    <h4><img src="../storage/posts/factura.png"  width="52px"> <strong>Recibos / Comprobantes de Pago</strong></h4>
	<h5>Si realizaste un pago por: <strong>Transferencia Electrónica o Depósito Bancario </strong> es necesario que subas tu comprobante en este espacio. Cualquier duda comunícate al (713) 133 52 38.</h5>
	
	<a href="./?view=home" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a> 
	
    <!-- Button trigger modal -->
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="./?view=recibos&opt=new&id=<?php echo $alumn->code; ?>" class="btn btn-warning btn-lg"><i class='fa fa-th-list'></i> Nuevo Recibo</a>
    <!--Fin Button trigger modal -->
    <br><br>
    <?php
    if (count($recibos) > 0) {
    ?>
        <section class="content">
            <!-- <div class="row">
                <div class="col-md-12"> -->
                    <div class="box box-primary">
                        <div class="box-body">
                        <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                            <table class="table table-bordered datatable table-hover">
                                <thead>
                                    <th>Estudiante</th>
                                    <th>Concepto</th>
                                    <th>Cantidad</th>
                                    <th>Folio</th>
                                    <th>Fecha de inicio</th>
                                    <th>Fecha</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </thead>
                                <?php
                                foreach ($recibos as $team) {

                                    $b = $team->code_user;
                                    $b1 = PersonData::getByCodeAlumn($b);
                                    $team->status;
                                    if ($team->status == 0) {
                                        $lbl_status = "Sin Validar";
                                        $lbl_class = 'label label-warning';
                                    } elseif ($team->status == 1) {
                                        $lbl_status = "Validado";
                                        $lbl_class = 'label label-primary';
                                    } elseif ($team->status == 2) {
                                        $lbl_status = "Rechazado";
                                        $lbl_class = 'label label-danger';
                                    }
                                    $idp = intval($team->id_plan);
                                    // echo "<script>console.log('" . $idp . "');</script>";
                                    $plan = PlandepagoData::getById($idp);
                                    $fi = $plan->fecha_inicio_pago;
                                    $conc = $plan->concepto;
                                    $concepto = ProductsData::getByIdd($conc);
                                    $nconc = $concepto->product_name;
                                    ?>
                                    <tr>
                                        <td><?php echo $team->code_user . "-" . $b1->name . " " . $b1->lastname; ?></td>
                                        <td><?php echo $nconc ?></td>
                                        <td><?php echo '$' . $team->importe; ?></td>
                                        <td><?php
                                        if($team->folio==Null)
                                        {
                                            echo $team->foliorechz;
                                        }else {echo $team->folio;}  ?></td>
                                        <td><?php echo $fi; ?></td>
                                        <td><?php echo $team->created_at; ?> </td>
                                        <td>
                                            <span class="<?php echo $lbl_class; ?>"><?php echo $lbl_status; ?></span>
                                        </td>
                                        <td>
                                            <?php if ($team->status == 1 || $team->status == 2 || $team->status == 0) { ?>
                                                <div class="btn-group pull-right">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <?php if ($team->status == 0) { ?>
                                                            <li><a href="index.php?view=recibos&opt=edit&id=<?php echo $team->id; ?>"><i class="fa fa-edit"></i>Editar</a></li>
                                                            <!-- deatalles -->
                                                        <?php } ?>
                                                       
                                                        <?php if ($team->status == 2 || $team->status == 1) { ?>
                                                            <li><a href="index.php?view=recibos&opt=detalles&id=<?php echo $team->id; ?>"><i class="glyphicon glyphicon-eye-open"></i>Visualizar</a></li>
                                                        <?php } ?>
                                                        <!-- <?php if ($team->status == 2) { ?>
                                                            <li><a href="index.php?action=recibos&opt=del&id=<?php echo $team->id; ?>"><i class="fa fa-trash"></i>Eliminar</a></li>
                                                        <?php } ?> -->
                                                    </ul>
                                                </div>
                                            <?php } ?>
                                        </td>
                                    </tr>
                            <?php
                                }
                                echo "</table></div></div>";
                            } else {
                                echo "<p class='alert alert-danger'>No hay Recibos</p>";
                            }
                            ?>
                            </table>
                        </div>
                        </div>
                    </div>
                <!-- </div>
            </div> -->
        </section>
        <!-- fin de tabla -->
    <?php
}
    ?>
    <?php if (isset($_GET["opt"]) && $_GET["opt"] == "new") : ?>
        <div class="row">
            <div class="col-md-12">
               
                
                <h4><img src="../storage/posts/archivo.png"  width="52px"> <strong>Nuevo Registro de Pago</strong></h4>
	<h5>En este espacio podrás subir tus comprobantes de pago efecturados por <strong>vía transferencia o depósito bancario.</strong> </h5>
	
	
                <br>
                <form class="form-horizontal" method="post" id="addcategory" action="./?action=recibosadd" role="form" enctype="multipart/form-data" href="./?view=alumnhistory&id=<?php echo $alumn->id; ?>">
                    <!-- enctype="multipart/form-data" envia archivos-->
                    <?php
                    $user = PersonData::getByCodeAlumn($_GET["id"]);
                    $con = Database::getCon();
                    $planPago = PlandepagoData::getPlanPagoByAlumno($user->id);
                    ?>
                    <input type="hidden" name="alumn_id" id="alumn_id" class="form-group" value="<?php echo $user->code; ?>">
                    <div class="form-group">
							<label class="col-lg-2 control-label">Concepto</label>
                            <div class="col-md-6">
							<select type="text" name="description" id="description"  data-live-search="true" class="form-control select2" required>
								<option value="">-- SELECCIONE --</option>
								<?php foreach ($planPago as $pl) {
									$product = ProductsData::getCambio($pl->concepto);
									$fecha = date('d-m-Y', strtotime($pl->fecha_inicio_pago));
									echo "<option value='$pl->id'> $fecha, $product->product_name</option>";
								} ?>
							</select>
                            </div>
						</div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Cantidad Pagada</label>
                        <div class="col-md-6">
                            <!-- <input type="text" name="cantidad" id="cantidad" class="form-control" placeholder="Cantidad"  onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required> -->
                            <input class="form-control" placeholder="Precio con descuento de beca y/o promoción" type="text" name="total" id="total" value="" onmousedown="return false;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Folio</label>
                        <div class="col-md-6">
                            <input type="text" name="folio" required class="form-control" id="folio" placeholder="Folio - (otorgado por el banco y SPEI)" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Comprobante de Pago</label>
                        <div class="col-md-6">
                            <!-- <input type="file" class='form-control' id="filename" name="filename" accept="image/*"> -->
                            <input type="file" class='form-control' id="filename" name="filename" accept="image/*, application/pdf">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-success btn-lg">Subir Comprobante</button>
                            <a href="./?view=recibos&code=<?php echo $user->code; ?>"  onclick="mostrarAlerta()" class="btn btn-primary">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--Actualizar de Aspirante -->
    <?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "edit") :
        $a = RecibosData::getById($_GET["id"]);
        
    ?>
        <div class="row">
            <div class="col-md-12">
                <h1>Editar</h1>
                <br>
                <form class="form-horizontal" method="post" id="addcategory" action="./?action=recibos&opt=update" role="form">

                    <input type="hidden" name="alumn_id" id="alumn_id" class="form-control" value="<?php echo $a->code_user; ?>">

                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Cantidad</label>
                        <div class="col-md-6">
                            <input type="text" name="cantidad" id="cantidad" class="form-control" value="<?php echo $a->importe; ?>"  onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Folio</label>
                        <div class="col-md-6">
                            <input type="text" name="folio" required class="form-control" id="folio" value="<?php echo $a->folio; ?>">
                        </div>
                    </div>
                    <!-- ver imagen -->
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Comprobante de Pago</label>
                        <div class="col-md-6">
                            <?php $url = "../storage/recibos/" . $a->code_user . "/" . $a->filename; ?>
                            <div class="box box-primary">
                                <div class="box-body box-profile">
                                    <div class="center-block">
                                    <object data="<?php echo $url; ?>" type="application/pdf" width="100%" height="600px">
                                                    <img src="<?php echo $url; ?>" alt="Comprobante de pago"  style="width: auto%; height: auto;">
                                    </object>
                                       <!-- <img class="img-responsive center" src="<?php echo  $url; ?>" alt="Comprobante de pago"> -->
                                        <br>
                                        <input type="file" class='form-control' id="filename" name="filename" value="<?php echo $a->filename; ?>" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <input type="hidden" name="id" value="<?php echo $a->id; ?>"> <!-- actualiza los datos por ID -->
                            <button type="submit" class="btn btn-success">Actualizar</button>
                            <a href="./?view=recibos&code=<?php echo $a->code_user; ?>"  onclick="mostrarAlerta2()" class="btn btn-primary">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- validar -->
    <?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "detalles") :
        $a = RecibosData::getById($_GET["id"]);
    ?>
        <div class="row">
            <div class="col-md-12">
                <h1>Detalles</h1>
                <br>
                <a href="./?view=recibos&opt=all&code=<?php echo $a->code_user; ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
                <br>
                <form class="form-horizontal" method="post" id="addcategory" action="" role="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <?php
                        $con = Database::getCon();
                        $sql_person = "SELECT * FROM person WHERE code = '" . $a->code_user . "'";
                        $query_person = mysqli_query($con, $sql_person);
                        $per = mysqli_fetch_array($query_person);
                        $code_person = $per['code'];
                        $nom_person = $per['name'];
                        $apellido_person = $per['lastname'];
                        ?>
                        <label for="inputEmail1" class="col-lg-2 control-label">Alumno*</label>
                        <div class="col-md-6">
                            <input name="alumn_id" id="alumn_id" class="form-control" value="<?php echo $code_person . "-" . $nom_person . " " . $apellido_person; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Cantidad</label>
                        <div class="col-md-6">
                            <input type="text" name="cantidad" id="cantidad" class="form-control" value="<?php echo $a->importe; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Folio</label>
                        <div class="col-md-6">
                            <input type="text" name="folio" required class="form-control" id="folio" value="<?php
                                    if($a->folio==Null)
                                    {
                                        echo $a->foliorechz;
                                    }else {echo $a->folio;}  ?>" readonly>
                        </div>
                    </div>
                    <!-- ver imagen -->
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Comprobante de Pago</label>
                        <div class="col-md-6">
                            <?php $url = "../storage/recibos/" . $a->code_user . "/" . $a->filename; ?>
                            <div class="box box-primary">
                                <div class="box-body box-profile">
                                    <div class="center-block">
                                        <!-- <img class="img-responsive center" src="<?php echo     $url; ?>" alt="Comprobante de pago"> -->
                                        <object data="<?php echo $url; ?>" type="application/pdf" width="100%" height="600px">
                                                    <img src="<?php echo $url; ?>" alt="Comprobante de pago"  style="width: auto%; height: auto;">
                                                </object>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($a->motivorech !== null) { ?>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 control-label">Motivo del rechazo</label>
                                <div class="col-md-6">
                                    <input type="text" name="folio" required class="form-control" id="Motivo de rechazo" value="<?php 
                                    echo $a->motivorech
                                    ?>" readonly>
                                </div>
                            </div>
                            <?php } ?>
                    <input type="hidden" name="id" value="<?php echo $a->id; ?>"> <!-- actualiza los datos por ID -->
                </form>
            </div>
        </div>
    <?php endif; ?>
    <script>
        document.getElementById('addcategory').addEventListener('submit', function(event) {
        var fileInput = document.getElementById('filename');
        var file = fileInput.files[0];

        if (!file) {
            event.preventDefault(); // Detener el envío del formulario
            alert('Por favor, selecciona un archivo antes de enviar el formulario.');
        }
    });

        function mostrarAlerta() {
                                    alert("El nuevo registro de recibo fue cancelado.");
                                }
        function mostrarAlerta2() {
                                    alert("la edicion del recibo fue cancelado.");
                                }
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
        /* validar que la captura sea una imagen */
        $("#filename").change(function() {
                        var maxSize = 8096;  // Tamaño máximo permitido (4MB)
                        var file = this.files[0];
                        var fileType = file.type;
                        var fileSize = file.size;
                        var sizeKilo = parseInt(fileSize / 1024);

                        // Verificar si el archivo es una imagen o un PDF
                        var isImage = fileType.includes("image/");
                        var isPDF = fileType === "application/pdf";

                        // Verificar el tamaño y tipo de archivo
                        if (isImage) {
                            // Verificar si es una imagen
                            var match = ["image/jpeg", "image/png", "image/jpg"];
                            if (!match.includes(fileType)) {
                                alert("Favor de escoger una imagen en formato (JPEG/JPG/PNG).");
                                $(this).val("");
                                return false;
                            }
                        } else if (isPDF) {
                            // Verificar si es un PDF
                            if (sizeKilo > maxSize) {
                                alert("El tamaño del PDF excede los 8MB.");
                                $(this).val("");
                                return false;
                            }
                        } else {
                            // Archivo no válido
                            alert("Formato de archivo no compatible. Favor de escoger una imagen (JPEG/JPG/PNG) o un PDF.");
                            $(this).val("");
                            return false;
                        }
                    });

            $(document).ready(function() {
                $('.select2').select2();
                
            });
            
	$(document).ready(function() {
		$('#description').on('change', function() {
			if ($('#description').val() == "") {
				$('#monto').val("");
				$('#total').val("");
			} else {
				$.ajax({
					url: './core/app/ajax/description_planpago.php',
					type: 'GET',
					data: {
						idProducto: $('#description').val(),
						// porcentajeBeca: $('#becas').val(),
						// porcentajePromocion: $('#promocion').val()
					},
					success: function(data) {
						try {
							var json = JSON.parse(data);
							$('#cantidad').val(json.precioLista);
							$('#total').val(json.precioFinal);
						} catch (e) {
							console.log(e);
						}
					}
				});
			}
		});
	});
</script>

<style>
.select2-container  {
  max-width: 100%;
  min-width: 100%;
}
</style>
    <!-- FIn del script -->
    