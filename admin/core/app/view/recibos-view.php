<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all") : ?>
    <div class="row">
        <div class="col-md-12">
            <h1>Recibos</h1>
            <!-- <a href="./?view=recibos&opt=new" class="btn btn-default"><i class='fa fa-th-list'></i> Nuevo Recibo</a>
            <br>
            <br> -->
            <?php

            $teams = RecibosData::getAll();
            if (count($teams) > 0) {
                // si hay usuarios
            ?>
                <div class="box box-primary">
                    <div class="box-body">
                        <table id="datatable_hpagos" class="table table-bordered table-hover">
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
                            foreach ($teams as $team) {

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
                                } elseif ($team->status == 3) {
                                    $lbl_status = "Correo Enviado";
                                    $lbl_class = 'label label-warning';
                                }
                                    $id = $team->id;
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
                                    }else {echo $team->folio;}
                                    ?></td>
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

                                                    <!-- <li><a href="index.php?view=recibos&opt=edit&id=<?php echo $team->id; ?>"><i class="fa fa-edit"></i>Editar</a></li> -->
                                                    <!-- deatalles -->
                                                    <li><a href="index.php?view=recibos&opt=detalles&id=<?php echo $team->id; ?>"><i class="glyphicon glyphicon-eye-open"></i>Visualizar</a></li>
                                                   
                                                    <?php if ($team->status == 0) { ?>
                                                        <!-- <li><a href="index.php?action=recibos&opt=del&id=<?php echo $team->id; ?>"><i class="fa fa-trash"></i>Eliminar</a></li> -->
                                                        <!-- <li><a href="index.php?action=recibos&opt=validar&id=<?php echo $team->id; ?>" onclick="return confirm('¿Estás seguro de que deseas validar el recibo?')"><i class="fa fa-check-circle"></i>Validar</a></li> -->
                                                        <!-- <li><a href="index.php?action=recibos&opt=rechazar&id=<?php echo $team->id; ?>" onclick="return confirm('¿Estás seguro de que deseas rechazar el recibo?')"><i class="glyphicon glyphicon-remove"></i> Rechazar</a></li> -->
                                                        <li><a href="#" onclick="confirmAndRejectRecibo(<?php echo $team->id; ?>)"><i class="glyphicon glyphicon-remove"></i> Rechazar</a></li>
                                                    <?php } ?>
                                                    
                                                   
                                                   <!--  <li><a href="#" onclick="recorr('<?php echo $id ?>')"><i class="fa fa-envelope"></i>Correo</i></a></li> -->

                                                </ul>
                                            </div>
                                            <script>
                                                function recorr(id) {
                                                    var id = id;
                                                    VentanaCentrada('../../../correo_recibo.php?id=' + id, '', '1024', '768', 'true');
                                                    load(1);
                                                }

                                                function confirmAndRejectRecibo(id) {
                                                    var motivo = prompt("Por favor, ingrese el motivo del rechazo:");
                                                    if (motivo != null && motivo.trim() !== "") {
                                                        // Si el usuario proporciona un motivo válido, enviar la solicitud al servidor
                                                        var url = "index.php?action=recibos&opt=rechazar&id=" + id + "&motivo=" + encodeURIComponent(motivo);
                                                        window.location.href = url;
                                                    }
                                                }
                                            </script>
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
                <!--Nueva Asignatura -->

            <?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "new") : ?>
                <?php
                    $planPago = PlandepagoData::planesactivos();
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <h1>Registro</h1>
                        <br>
                        <form class="form-horizontal" method="post" id="addcategory" action="./?action=recibosadd" role="form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 control-label">Alumno*</label>
                                <div class="col-md-6">
                                    <select type="text" id="description" name="description" data-live-search="true" class="form-control select2" required>
                                        <option value="">-- SELECCIONE --</option>
                                        <?php foreach ($planPago as $pl) {
                                            $product = ProductsData::getCambio($pl->concepto);
                                            $fecha = date('d-m-Y', strtotime($pl->fecha_inicio_pago));
                                            $nombre = PersonData::getById($pl->alumno);
                                            echo "<option value='$pl->id'>$nombre->code, $product->product_name, $fecha </option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="alumn_id" id="alumn_id" class="form-group" value="<?php echo $nombre->code; ?>">
                            <div class="form-group">
                                 <label for="inputEmail1" class="col-lg-2 control-label">Cantidad</label>
                                <div class="col-md-6">
                                    <!-- <input type="text" name="cantidad" id="cantidad" class="form-control" placeholder="Cantidad" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required> -->
                                    <input class="form-control" placeholder="Precio con descuento de beca y/o promoción" type="text" name="total" id="total" value="" onmousedown="return false;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 control-label">Folio</label>
                                <div class="col-md-6">
                                    <input type="text" name="folio" required class="form-control" id="folio" placeholder="Folio" required>
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
                                    <button type="submit" class="btn btn-success">Agregar</button>
                                    <a href="./?view=recibos&opt=all"  onclick="mostrarAlerta()" class="btn btn-primary">Cancelar</a>

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
                                    <select name="alumn_id" id="select" data-live-search="true" class="form-control">
                                        <option value="<?php echo $a->code_user ?>" selected> <?php echo  $code_person . " - " . $nom_person . "" . $apellido_person ?></option>
                                        <?php foreach (PersonData::getAlumns() as $al) : ?>
                                            <option value="<?php echo $al->code; ?>"><?php echo $al->code . " - " . $al->name . " " . $al->lastname; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 control-label">Cantidad</label>
                                <div class="col-md-6">
                                    <input type="text" name="cantidad" id="cantidad" class="form-control" value="<?php echo $a->importe; ?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
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
                                                <img class="img-responsive center" src="<?php echo  $url; ?>" alt="Comprobante de pago">
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
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Detalles -->
            <?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "detalles") :
            $a = RecibosData::getById($_GET["id"]);
            ?>
                <div class="row">
                    <div class="col-md-12">
                        <h1>Detalles</h1>
                        <br>
                        <a href="./?view=recibos&opt=all&id=<?php echo $a->id; ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
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
                                    }else {echo $a->folio;} ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 control-label"></label>
                                <div class="col-md-6">
                                    <?php if ($a->status === '1'): ?>
                                        <button class="btn btn-secondary form-control" disabled>
                                            <i class="fa fa-check-circle"></i>
                                            Está validado
                                        </button>
                                    <?php elseif ($a->status === '2'): ?>
                                        <button class="btn btn-danger form-control" disabled>
                                            <i class="fa fa-times-circle"></i>
                                            Rechazado
                                        </button>
                                    <?php else: ?>
                                        <a href="index.php?action=recibos&opt=validar&id=<?php echo $idValidar; ?>" 
                                        class="btn btn-success form-control"
                                        onclick="return confirm('¿Estás seguro de que deseas validar el recibo?')">
                                            <i class="fa fa-check-circle"></i>
                                            Validar
                                        </a>
                                    <?php endif; ?>
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
                // para que no se abra el select
                $('#periodo_as').on('mousedown', function(e) {
                    e.preventDefault();
                    this.blur();
                    window.focus();
                });
            </script>

            <script>
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

                $('.select2').select2();

                $('[id="select"]').selectpicker();

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

            </script>
             <script>
                // Función para verificar si ambos campos están llenos
                function checkFields() {
                    const conceptoSelect = document.getElementById("description2").value;
                    const alumnoSelect = document.getElementById("alumno2").value;

                    // Si ambos campos tienen valores
                    if (conceptoSelect !== '' && alumnoSelect !== '') {
                        // Habilitar los selects de "Aplica Promocion" y "Aplica Beca"
                        document.getElementById("aplicaPromocion").removeAttribute('disabled');
                        document.getElementById("aplicaBeca").removeAttribute('disabled');
                    }
                    if ((conceptoSelect !== '' && alumnoSelect == '') || (conceptoSelect == '' && alumnoSelect !== '')) {
                         // Si alguno de los campos está vacío, deshabilitar los selects
                        document.getElementById("aplicaPromocion").setAttribute('disabled', true);
                        document.getElementById("aplicaBeca").setAttribute('disabled', true);
                    }
                }



                $('#description2').on('change', function() {
                    if ($('#description2').val() == "") {
                        $('#monto').val("");
                        $('#total').val("");
                    } else {
                        $.ajax({
                            url: './core/app/ajax/descripcion_sinplan.php',
                                type: 'GET',
                                data: {
                                idProducto2: $('#description2').val(),
                                // porcentajeBeca: $('#becas').val(),
                                // porcentajePromocion: $('#promocion').val()
                            },
                            success: function(data) {
                                $('#total2').val("");
                                try {
                                    // var json = JSON.parse(data); // Parsea el string JSON a un objeto
                                    console.log("Info:", data); // Muestra el objeto JSON en la consola
                                        
                                    // $('#cantidad2').val(json.precioLista);
                                    $('#total2').val(data);

                                    // Obtener el valor seleccionado (id del concepto)
                                    const codAlumno = $('#description2').val();

                                    console.log("Código del producto: " + codAlumno);

                                    //ponemos el monto del concepto en el campo total
                                    $("#Cpagar").val(data);

                                    checkFields();
                                } catch (e) {
                                    console.log(e);
                                }
                            }
                        });
                    }
                });

                

                // // Escuchar el cambio en el select (beca)
                // $('#aplicaBeca').on('change', function() {
                //     // Obtener el valor seleccionado
                //     const selectedValue = this.value;

                //     // Obtener los valores de los campos 'Concepto' y 'Alumno'
                //     const conceptoSelect = document.getElementById("description2").value;
                //     const alumnoSelect = document.getElementById("alumno2").value;

                //     // Imprimir el valor en la consola si todo está correcto
                //     console.log(selectedValue);
                // });

                function selectsDesceuntos(status) {
                    
                }
                $(document).ready(function() {
                    // Escuchar el cambio en el select (promoción)
                    $('#aplicaPromocion').on('change', function() {
                        // Obtener el valor seleccionado
                        const selectedValue = this.value;

                        // Imprimir el valor en la consola
                        // console.log('Promoción seleccionada:', selectedValue);

                       
                            // Realizar la solicitud AJAX
                            $.ajax({
                                url: './core/app/ajax/promocion_splan.php',
                                type: 'POST',
                                data: {
                                    promocion_status: selectedValue,
                                    alumn_id2: $('#alumn_id2').val() // Asegúrate de que alumn_id2 está definido
                                },
                                success: function(data) {
                                    try {
                                        // Muestra el objeto JSON en la consola
                                        console.log('Info:', data);
                                        let porcentajePormo = data;

                                        
                                        if (selectedValue == "SI") {
                                            //Hacemos el descuento de promocion
                                            let totalConcepto = document.getElementById("Cpagar").value;
                                            let descuento = (totalConcepto * porcentajePormo) / 100;
                                            let total = totalConcepto - descuento;

                                            //limpiamos el campo total y ponemos el descuento
                                            document.getElementById("Cpagar").value = '';
                                            document.getElementById("Cpagar").value = total; 
                                            // console.log('desceunto:', descuento);
                                            // console.log('Total:', total);

                                            document.getElementById("Dpromocion").value = descuento;
                                        }else{
                                            const total_conepto1 = document.getElementById("total2").value;
                                            const total_conepto2 = parseFloat(document.getElementById("Cpagar").value);
                                            if (total_conepto1 == total_conepto2) {
                                                // console.log("Priemr No");
                                                  /*Importante el if ya que con este no marca err
                                                or el cmapo total si se le póne NO por primeraves a lso selectores */
                                                return
                                            }
                                            // console.log('Promoción seleccionada:', selectedValue);
                                            let Dpromocion_int = parseFloat(document.getElementById("Dpromocion").value); //cantidad del descuento 
                                            let concepto_total = document.getElementById("total2").value;
                                            
                                            //tomamos el valor actual de total
                                            let totalConcepto2 = parseFloat(document.getElementById("Cpagar").value);
                                            let quitamos_descuento = totalConcepto2 + Dpromocion_int;
                                            //limpiamos el campo total y ponemos el descuento
                                            document.getElementById("Cpagar").value = '';
                                            document.getElementById("Cpagar").value = quitamos_descuento;  
                                            document.getElementById("Dpromocion").value = '';
                                        }

                                    } catch (e) {
                                        console.log('Error al procesar datos:', e);
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log('Error en la solicitud AJAX:', textStatus, errorThrown);
                                }
                            });
                       
                        
                    });

                    // Escuchar el cambio en el select (beca) si es necesario
                    $('#aplicaBeca').on('change', function() {
                        const selectedValue = this.value;
                        // console.log('Beca seleccionada:', selectedValue);
                            // Realizar la solicitud AJAX
                            $.ajax({
                                url: './core/app/ajax/promocion_splan.php',
                                type: 'POST',
                                data: {
                                    beca_status: selectedValue,
                                    alumn_id2: $('#alumn_id2').val() // Asegúrate de que alumn_id2 está definido
                                },
                                success: function(data) {
                                    try {
                                        // Muestra el objeto JSON en la consola
                                        console.log('Info:', data);
                                        let porcentajeBeca = data;

                                        if (porcentajeBeca == 'campo_vacio') {
                                            alert("El usuario no tiene Beca asignada, por favor regresa el campo a 'NO'");
                                            return
                                        }

                                        if (selectedValue == "SI") {
                                            //Hacemos el descuento de promocion
                                            let totalConcepto2 = document.getElementById("Cpagar").value;
                                            let descuento2 = (totalConcepto2 * porcentajeBeca) / 100;
                                            let total2 = totalConcepto2 - descuento2;

                                            //limpiamos el campo total y ponemos el descuento
                                            document.getElementById("Cpagar").value = '';
                                            document.getElementById("Cpagar").value = total2; 
                                            console.log('desceunto:', descuento2);
                                            console.log('Total:', total2);

                                            document.getElementById("Dbeca").value = descuento2;
                                        }else{
                                            const total_conepto1 = document.getElementById("total2").value;
                                            const total_conepto2 = parseFloat(document.getElementById("Cpagar").value);
                                            if (total_conepto1 == total_conepto2) {
                                                // console.log("Primer NO");
                                                /*Importante el if ya que con este no marca err
                                                or el cmapo total si se le póne NO por primeraves a lso selectores */
                                                return
                                            }
                                            // Imprimir el valor en la consola
                                            console.log('Beca seleccionada:', selectedValue); 
                                            let Dbeca_int = parseFloat(document.getElementById("Dbeca").value); //cantidad del descuento 
                                            let concepto_total = document.getElementById("total2").value;
                                    
                                            
                                            //tomamos el valor actual de total
                                            let totalConcepto2 = parseFloat(document.getElementById("Cpagar").value);
                                            let quitamos_descuento = totalConcepto2 + Dbeca_int;
                                            //limpiamos el campo total y ponemos el descuento
                                            document.getElementById("Cpagar").value = '';
                                            document.getElementById("Cpagar").value = quitamos_descuento; 

                                            document.getElementById("Dbeca").value = '';
                                        }
                                        
                                    } catch (e) {
                                        console.log('Error al procesar datos:', e);
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log('Error en la solicitud AJAX:', textStatus, errorThrown);
                                }
                            });
                    });
                });



                $("#alumno2").on('change', function() {
                    var selectedOption = $(this).find('option:selected'); // Obtiene la opción seleccionada
                    var code = selectedOption.data('code'); // Captura el valor de data-code
                    console.log("Código del alumno seleccionado:", code); // Muestra el código en la consola

                    const codeAlumno = document.getElementById("alumn_id2");
                    codeAlumno.value = ""
                    codeAlumno.value = code;
                    checkFields();
                })

                const descuento_total = document.getElementById("Cpagar").value;

                document.getElementById("Dadicional").addEventListener("click", (e) => {
                    e.preventDefault();
                    const total = document.getElementById("Cpagar").value;
                    const descuento_adicional = document.getElementById("Descuento").value;

                    if (descuento_adicional != '' || descuento_adicional != '0') {
                        let total_add_finish = (total - ((total * descuento_adicional) / 100));

                        document.getElementById("Cpagar").value = '';
                        document.getElementById("Cpagar").value = total_add_finish; 
                    }
                   
                    
                })
                const DesceuntoProd = () => {
                    //traemos el valor escrito por el input
                    const descuento = document.getElementById("descuento_total").value;
                    console.log("Descuento: " + descuento);
                    
                    //Traemos el precio del producto
                    const producto_precio = document.getElementById("total2").value;
                    console.log("producto_precio: " + producto_precio);
                    
                    if (producto_precio == "" || producto_precio == "0") {
                        console.log("No hay concepto seleccionado.");
                        document.getElementById("Descuento").value = '';
                        
                    }else{
                        const descuento_final = (producto_precio * descuento)/100;
                        const Total = producto_precio - descuento_final;
                        document.getElementById("Cpagar").value = '';//limpiamos el campo total
                        //colocamos el monto ocn descxuento en total
                        document.getElementById("Cpagar").value = Total;
                        console.log("Pago Final: " + Total);
                        
                    }
                }

                function limpiarCamposFormulario1() {
                    const form1 = document.querySelector('.option1_formL');
                    form1.reset(); // Limpia todos los campos del formulario
                }

                function limpiarCamposFormulario2() {
                    const form2 = document.querySelector('.option2_formL');
                    form2.reset(); // Limpia todos los campos del formulario
                }
               
                const radios = document.querySelectorAll('input[type="radio"]');
                radios.forEach(radio => {
                    radio.addEventListener('change', (event) => {
                        // Reset colors for all labels
                        document.querySelectorAll('.radio-label').forEach(label => {
                            label.style.color = '#1777d8'; // Color por defecto
                        });

                        // Set the selected label to green
                        const selectedLabel = document.querySelector(`label[for="${event.target.id}"]`);
                        selectedLabel.style.color = 'green';

                        // alert(`Has seleccionado: ${event.target.value}`);

                        const option = event.target.value;

                        if (option === "Libre") {
                            // console.log("Libre");
                            document.querySelector(".option2_form").classList.remove('hidden'); // Mostrar el div
                            document.querySelector(".option1_form").classList.add('hidden'); // Ocultar el div // Limpiar campos del formulario con la clase formulario_1
                            // Limpiar formulario 1
                            limpiarCamposFormulario1();
                        }

                        if (option === "Con plan") {
                            // console.log("Con plan");
                            document.querySelector(".option1_form").classList.remove('hidden'); // Mostrar el div
                            document.querySelector(".option2_form").classList.add('hidden'); // Ocultar el div
                            // Limpiar formulario 2
                            limpiarCamposFormulario2();
                        }
                    });
                });


                
            </script>
            <script>
                $(document).ready(function() {
                    // Filtro personalizado
                    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                        var status = data[6]; // 👈 columna "Estatus" (texto)
                        var search = $('#datatable_hpagos_filter input').val();

                        // Si hay búsqueda -> mostrar todo
                        if (search && search.length > 0) {
                            return true;
                        }

                        // Si no hay búsqueda -> mostrar solo "Sin Validar"
                        return (status === "Sin Validar");
                    });

                    var table = $('#datatable_hpagos').DataTable({
                        ordering: false,
                        pageLength: 10,
                        stateSave: true // ✅ mantiene búsqueda, página, etc.
                    });

                    // Redibujar cuando el usuario busca
                    $('#datatable_hpagos_filter input').on('keyup change', function() {
                        table.draw();
                    });
                });




            </script>
            <!-- FIn del script -->
            <style>
.select2-container  {
  max-width: 100%;
  min-width: 100%;
}
</style>
