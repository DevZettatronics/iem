
<head>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<?php  if (isset($_GET["opt"]) && $_GET["opt"] == "all") : 
         
?>
    <div class="row">
        <div class="col-md-12">
          
            <h3><img src="../storage/posts/calendario.png"  width="52px"> <strong>Planes de Pago</strong></h3>
	        <h5>La información mostrada en este espacio tiene la finalidad de dar de alta, modificar o eliminar <strong>Planes de Pago</strong> dados de alta en el sistema. </h5>

            <a href="./?view=home" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>

            <?php if (Permisos::puede(Core::$user->kind, 'control_planes', 'crear')): ?>
                <a href="./?view=planpago&opt=new" class="btn btn-success"><i class="fa fa-dollar"></i> Nuevo Plan De Pago</a>
            <?php endif; ?>
    
            <br>
            <br>
            <?php
            $payments = PlandepagoData::getAll();
            if (count($payments) > 0) {
                // si hay usuarios
            ?>
                <div class="box box-primary">
                    <div class="box-body">
                    <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                        <table class="table table-bordered datatable table-hover" data-page-length="100">
                            <thead class="bg-warning font-weight-bold p-3 text-left">
                                <th>Periodo</th>
                                <!-- <th>Programa</th>-->
                                <th>Estudiante</th>
                                <th>Concepto</th>
                                <th style="background-color: #8C8C8C; color: white;">Precio Base</th> 
                                <th style="background-color: #762110; color: white;">Descuento de </th>
                                <th style="background-color: #179B61; color: white;">Cantidad a Pagar</th> 
                                <!--<th>Beca Asignada</th>-->
                                <!--<th>Promo Inscripción</th>-->
                                <th>Periodo de Pago </th>
                                 <!--   <th>Fin de pago </th> -->
                                <th>Estado</th>
                                <th>Acciones</th>
                            </thead>
                            <?php
                            $con = Database::getCon();

                            foreach ($payments as $pay) {
                                /* Periodo */
                                $p = $pay->periodo;
                                $pe = PeriodData::getById($p);
                                /*****************/
                                /* Carrera */
                                $carr = $pay->carrera;
                                $catt = TeamData::getById($carr);
                                /*****************/
                                /* Alumno */
                                $al = $pay->alumno;
                                $alum = PersonData::getById($al);
                                /*****************/
                                /* precio */
                                 $prod = $pay->concepto;
                                 $pdt = ProductsData::getByIdd($prod);
                                $queryBeca = "SELECT * FROM products, plan_de_pago, person, becas WHERE person.promocion=becas.id AND plan_de_pago.alumno=person.id AND plan_de_pago.id = $pay->id And plan_de_pago.concepto=products.product_id";
                                $sql = mysqli_query($con, $queryBeca);
                                while ($row = mysqli_fetch_array($sql)) {
                                    $porcentajePromocion = $row ['porcentaje'];
                                }
                                // echo $pay->alumno;}
                                // IMPORTANTE SUI EN CANTIDAD DE PAGO NO APARECE NADA E SPOR QUE EL ALUMNO en la tabla person no tiene los ids asignados de beca y promocion correctos 
                                $queryPlanPago = mysqli_query($con,"SELECT * FROM products, plan_de_pago, person, becas WHERE person.beca=becas.id AND plan_de_pago.alumno=person.id AND plan_de_pago.id = $pay->id And plan_de_pago.concepto=products.product_id");
                                if ($queryPlanPago->num_rows > 0) {

                                    $data = mysqli_fetch_array($queryPlanPago);
                                    $porcentajeBeca = $data['porcentaje'];
                                    $idProducto = $data['concepto'];
                                    $cbeca = $data['cuenta_beca'];
                                    $cprom = $data['cuenta_promocion'];
                                    $query = "SELECT * FROM products WHERE product_id = $idProducto";
                                    $queryProducto = mysqli_query($con, $query);
                                    if ($queryProducto->num_rows > 0) {
                                        $row = mysqli_fetch_array($queryProducto);
                                        $precio = $row['selling_price'];
                                        if ($row==TRUE) {
                                            if($cprom == "SI" && $cbeca == "SI"){
                                                $precioFinal = $precio - (( ($precio * ($porcentajeBeca / 100) ) ) + ( ($precio * ($porcentajePromocion / 100) ) ));
                                            }
                                            if($cbeca == "SI" &&  $cprom == "NO"){
                                                $precioFinal = $precio - ( ($precio * ($porcentajeBeca / 100) ) );
                                            }if($cbeca == "NO" &&  $cprom == "SI"){
                                                $precioFinal = $precio - ( ($precio * ($porcentajePromocion / 100) ) );
                                            }
                                            if($cprom == "NO" && $cbeca == "NO"){
                                                $precioFinal = $precio;
                                            }
                                                //$precioFinal = $precio - (( ($precio * ($porcentajeBeca / 100) ) ) + ( ($precio * ($porcentajePromocion / 100) ) ));
                                        }
                                    }
                                }
                                        
                                    $CantidadConDescuento = $precio - $precioFinal;
                                    

                                    
                                /*****************/
                                /* Beca */
                                $con = Database::getCon();
                                // $sql_1 = "SELECT * FROM becas WHERE id = '" . $alum->beca . "' AND tipo = 1";
                                // $query_1 = mysqli_query($con, $sql_1);
                                // $con_1 = mysqli_fetch_array($query_1);
                                $sql_1 = "SELECT *  FROM plan_de_pago WHERE alumno = '" . $alum->id . "' AND id = '" . $pay->id . "'";
                                $query_1 = mysqli_query($con, $sql_1);
                                $con_1 = mysqli_fetch_array($query_1);
                                // echo $con_1['cuenta_beca'] ;

                                if ($con_1['cuenta_beca'] === "NO") {
                                    $becaf = "Sin Beca Asiganda";
                                } else {
                                $sql_1 = "SELECT * FROM becas WHERE id = '" . $alum->beca . "' AND tipo = 1";
                                $query_1 = mysqli_query($con, $sql_1);
                                $con_1 = mysqli_fetch_array($query_1);
                                    $name_beca = $con_1['name'];
                                    //$becaf = $name_beca  . " %" . $porcentajeBeca; // Linea original
                                    $becaf = $name_beca; // Linea modificada
                                }
                                /*****************/
                                // $sql_1 = "SELECT * FROM becas WHERE id = '" . $alum->promocion . "'";
                                // $query_1 = mysqli_query($con, $sql_1);
                                // $con_1 = mysqli_fetch_array($query_1);
                                $sql_1 = "SELECT *  FROM plan_de_pago WHERE alumno = '" . $alum->id . "' AND id = '" . $pay->id . "'";
                                $query_1 = mysqli_query($con, $sql_1);
                                $con_1 = mysqli_fetch_array($query_1);
                                // echo $con_1['cuenta_promocion'] ."<br>";

                                if ($con_1['cuenta_promocion'] == "NO") {
                                    $promof = "Sin Promoción Asiganda";
                                } else {
                                    $sql_1 = "SELECT * FROM becas WHERE id = '" . $alum->promocion . "'";
                                    $query_1 = mysqli_query($con, $sql_1);
                                    $con_1 = mysqli_fetch_array($query_1);
                                    $name_promo = $con_1['name'];
                                    //$promof = $name_promo . " %" . $porcentajePromocion; // Línea Original 
                                    $promof = $name_promo; // Línea Modificada
                                }
                                /*****************/
                                //fechas
                                $ip = $pay->fecha_inicio_pago;
                                $fechaNueva = new DateTime($ip);
                                $fp = $pay->fecha_fin_pago;
                                $fechaNueva1 = new DateTime($fp);
                                $pay->status;
                                if ($pay->status == 1) {
                                    $lbl_status = "Pendiente";
                                    $lbl_class = 'label label-danger';
                                } elseif ($pay->status == 2) {
                                    $lbl_status = "Pagado";
                                    $lbl_class = 'label label-primary';
                                } elseif ($pay->status == 3) {
                                    $lbl_status = "Pagado con retraso";
                                    $lbl_class = 'label label-warning';
                                }elseif ($pay->status == 4) {
                                    $lbl_status = "Adeudo";
                                    $lbl_class = 'label label-danger';
                                }
                                elseif ($pay->status == 5) {
                                    $lbl_status = "Sin validar";
                                    $lbl_class = 'label label-warning';
                                }
                                elseif ($pay->status == 6) {
                                    $lbl_status = "Vencido";
                                    $lbl_class = 'label label-default';
                                }elseif ($pay->status == 7) {
                                        $lbl_status = "Cancelado";
                                        $lbl_class = 'label label-default';
                                    }
                                /******************/
                               
                            ?>
                                <tr>
                                    <td style="font-size: 10px; font-weight: bold;"><?php echo $pe->name; ?></td>
                                    <!-- <td style="font-size: 10px; font-weight: bold;"><?php echo $catt->grade; ?></td> -->
                                    <td style="font-size: 10px; font-weight: bold;">
                                        
                                        <?php echo  $alum->code . " - " . $alum->name; ?>
                                        <br>
                                        <?php echo $alum->lastname; ?>
                                        <br>
                                        <span style="color: #2875B4;"><?php echo $catt->grade; ?></span>
                                        
                                    </td>
                                    <td style="font-size: 10px; font-weight: bold;"><?php echo $pdt->product_name; ?><br><br>
                                    
                                    <small>Promoción: <?php echo $promof ?></small><br><br>
                                    <small>Béca: <?php echo $becaf ?></small>
                                    </td>
                                    
                                    <td style="font-size: 10px; font-weight: bold; text-align: center; vertical-align: middle;"><?php echo '$' . $pdt->selling_price; ?></td> 
                                    
                                    <td style="font-size: 10px; font-weight: bold; text-align: center; vertical-align: middle;">
                                        <span style="color: #FF0000;"><?php echo '$' . $CantidadConDescuento ?></span>
                                    </td> 
                                    
                                    <td style="font-size: 13px; font-weight: bold; text-align: center; vertical-align: middle; background-color: #A8E8AF;">
                                        <span style="color: #096913;"><?php echo '$' . $precioFinal ?></span>
                                    </td>


                                    
                                    <!-- <td style="font-size: 10px; font-weight: bold;"><?php echo $becaf ?></td> cuando el campo esta vacio -->
                                    <!-- <td style="font-size: 10px; font-weight: bold;"><?php echo $promof ?></td>cuando el campo esta vacio -->
                                    
                                    <td style="font-size: 10px; font-weight: bold; text-align: left;">
                                        
                                        <small>Inicio:</small> <?php echo $fechaNueva->format("d-m-Y"); ?><br><br>
                                        <small>Término: </small><?php echo $fechaNueva1->format("d-m-Y"); ?>
                                    </td>
                                   
                                    <td><span class="<?php echo $lbl_class; ?>"><?php echo $lbl_status; ?></span></td>
                                    <td>
                                        <?php 
                                            if (Permisos::puede(Core::$user->kind, 'control_planes', 'editar')):
                                                if ($pay->status != 6 and $pay->status != 2 and $pay->status != 7 ) : ?>
                                                    <!--   <a href="index.php?action=planpago&opt=val&id=?php echo $pay->id; ?>" class="btn btn-success btn-xs"><i class="fa fa-check-circle"></i></a> -->
                                                    <a href="index.php?view=planpago&opt=edit&id=<?php echo $pay->id; ?>" class="btn btn-warning btn-xs">Editar</a>   
                                        <?php 
                                                endif; 
                                            endif;
                                        ?>

                                        <?php 
                                            if (Permisos::puede(Core::$user->kind, 'control_planes', 'eliminar')):
                                                if ($pay->status != 2 and $pay->status != 7) :  ?>
                                                       <a href="#" 
                                                            class="btn btn-danger btn-xs btn-eliminar" 
                                                            data-id="<?php echo $pay->id; ?>" 
                                                            onclick="eliminaPlan(this); return false;">
                                                            Eliminar
                                                        </a>
                                                        <!--   <a href="index.php?action=planpago&opt=val&id=?php echo $pay->id; ?>" class="btn btn-success btn-xs"><i class="fa fa-check-circle"></i></a> -->
                                                            <!-- <a href="index.php?action=planpago&opt=del&id=<?php echo $pay->id; ?>" class="btn btn-danger btn-xs">Eliminar</a> -->
                                        <?php 
                                                endif; 
                                            endif;
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                /* $con = Database::getCon();
                                $sumaT   = mysqli_query($con, "SELECT sum(importe) as importe FROM $tables where $sWhere"); */ ?>
                        <?php
                            }
                            echo "</table></div></div>";
                        } else {
                            echo "<p class='alert alert-danger'>No hay un plan de trabajo registrado</p>";
                        }
                        ?>
                        </table>
                    </div>
                        <?php
                        $con = Database::getCon();
                        $sumaT   = mysqli_query($con, "SELECT sum(selling_price) as selling FROM products ");
                        $st = mysqli_fetch_array($sumaT);
                        $nombre_ST = $st['selling'];
                        ?>
                        <h2>
                            <?php
                            /*   echo $nombre_ST; */
                            ?>
                        </h2>
                    </div>
                </div>
                <!--Nueva Asignatura -->
    <?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "new") : ?>
                <div class="row">
                    <div class="col-md-12">
                        <h1>Nuevo Plan De Pago</h1>
                        <br>
                        <form class="form-horizontal" method="post" id="addcategory" action="./?action=planpago&opt=add" role="form"  onsubmit="return validarFormulario()">
                        <!-- Periodo al que pertenece -->
                        <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">Nombre de Periodo</label>
                            <div class="col-md-6">
                                <select name="periodo" id="periodo" data-live-search="true" class="form-control select2" required>
                                    <option value="">-- SELECCIONE --</option>
                                    <?php foreach (PeriodData::getAlll() as $pe) : ?>
                                        <option value="<?php echo $pe->id; ?>"><?php echo $pe->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- Sementre -->
                        <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">Grupo</label>
                            <div class="col-md-6">
                                <select name="grupo" id="grupo" data-live-search="true" class="form-control select2" required></select>
                            </div>
                        </div>
                        <!-- Alumno -->
                        <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">Alumno</label>
                            <div class="col-md-6">
                                <select multiple name="alumn_id[]" id="alumn_id" data-live-search="true" class="form-control js-example-basic-multiple" required></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">Productos</label>
                            <div class="col-md-6">
                                <select name="productos[]" id="productos" data-live-search="true" multiple class="form-control" required>
                                    <?php foreach (ProductsData::getAll() as $prod) : ?>
                                        <option value="<?php echo $prod->product_id; ?>"><?php echo $prod->product_code. " - ".$prod->product_name. " - $".$prod->selling_price; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- Aplica beca -->
                        <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">Aplica beca</label>
                            <div class="col-md-6">
                                <select name="cuen_beca" id="cuen_beca" data-live-search="true" class="form-control select2" required>
                                    <option value="">-- SELECCIONE --</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <!-- Aplica promoción -->
                        <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">Promoción inscripción</label>
                            <div class="col-md-6">
                                <select name="cuen_prom" id="cuen_prom" data-live-search="true" class="form-control select2" required>
                                    <option value="">-- SELECCIONE --</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <!-- Meses del año con campos de fecha -->
                        <div class="">
                            <label for="inputEmail1" class="col-lg-2 control-label">Meses del año</label>
                            <div class="col-md-6">
                                    <div class="row">
                                        <?php
                                        $currentYear = date('Y');
                                        foreach (DateData::getAll() as $date) :
                                        ?>
                                            <label>
                                                <input type="checkbox" id="meses_<?php echo $date->Id_mes; ?>" name="meses[]" value="<?php echo $date->Id_mes; ?>">
                                                <?php echo $date->mes; ?>
                                            </label>
                                            <br>
                                            <?php
                                            if ($date->Id_mes <9 && $date->Id_mes >= 0) {
                                            ?>
                                                <label class="fecha-label fecha-label-<?php echo $date->Id_mes; ?>">
                                                Fecha Inicio:
                                                    <input class="col" type="date" id="fechaInput" name="fecha_inicio_<?php echo $date->Id_mes; ?>" value="<?php echo $currentYear; ?>-0<?php echo $date->Id_mes+1; ?>-01" min="<?php echo $currentYear; ?>-01-01" onchange="actualizarFecha()">
                                                    Fecha Fin:
                                                    <input class="col" type="date" id="fechaInput" name="fecha_fin_<?php echo $date->Id_mes; ?>" value="<?php echo $currentYear; ?>-0<?php echo $date->Id_mes+1; ?>-01" min="<?php echo $currentYear; ?>-01-01" onchange="actualizarFecha()">
                                                </label>
                                            <?php } if($date->Id_mes <=12 && $date->Id_mes >= 9){ ?>
                                                <label class="fecha-label fecha-label-<?php echo $date->Id_mes; ?>">
                                                Fecha Inicio:
                                                    <input class="col" type="date" id="fechaInput" name="fecha_inicio_<?php echo $date->Id_mes; ?>" value="<?php echo $currentYear; ?>-<?php echo $date->Id_mes+1; ?>-01" min="<?php echo $currentYear; ?>-01-01" onchange="actualizarFecha()">
                                                    Fecha Fin:
                                                    <input class="col" type="date" id="fechaInput" name="fecha_fin_<?php echo $date->Id_mes; ?>" value="<?php echo $currentYear; ?>-<?php echo $date->Id_mes+1; ?>-01" min="<?php echo $currentYear; ?>-01-01" onchange="actualizarFecha()">
                                                </label>
                                            <?php } ?>
                                        <?php endforeach; ?>
                                    </div>
                            </div>
                        </div>
                        <script>
                            function validarFormulario() {
                                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                                var alMenosUnoSeleccionado = false;

                                // Verificar si al menos uno de los checkboxes está seleccionado
                                checkboxes.forEach(function (checkbox) {
                                    if (checkbox.checked) {
                                        alMenosUnoSeleccionado = true;
                                    }
                                });

                                // Mostrar mensaje de error si no hay ningún checkbox seleccionado
                                if (!alMenosUnoSeleccionado) {
                                    alert("Debe seleccionar al menos un mes");
                                    return false; // Evitar el envío del formulario
                                }

                                // Si se ha seleccionado al menos un checkbox, enviar el formulario
                                return true;
                            }
                            // Obtener todas las etiquetas con la clase "fecha-label"
                            const fechaLabels = document.querySelectorAll('.fecha-label');
                            // Ocultar todas las etiquetas inicialmente
                            fechaLabels.forEach(function (label) {
                            label.style.display = 'none';
                            });
                            // Obtener todas las casillas de verificación
                            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
                            // Asignar un evento "change" a cada casilla de verificación
                            checkboxes.forEach(function (checkbox) {
                            checkbox.addEventListener('change', function () {
                                // Obtener el ID del mes correspondiente a la casilla de verificación
                                const mesId = checkbox.id.split('_')[1];
                                // Obtener la etiqueta correspondiente al mes
                                const fechaLabel = document.querySelector('.fecha-label-' + mesId);
                                // Mostrar u ocultar el elemento <label> según el estado de la casilla de verificación
                                if (checkbox.checked) {
                                fechaLabel.style.display = 'block';
                                } else {
                                fechaLabel.style.display = 'none';
                                }
                            });
                            });
                            function actualizarFecha() {
                            var fechaInput = event.target;
                            var fechaSeleccionada = new Date(fechaInput.value + 'T00:00:00');
                            var dia = fechaSeleccionada.getUTCDate();
                            var mes = parseInt(fechaInput.name.split('_')[2]);
                            //UTC (Tiempo Universal Coordinado) y creamos una nueva fecha sin ajustar la zona horaria
                            var anio = fechaSeleccionada.getUTCFullYear();

                            // Crear una nueva fecha con el año, mes y día seleccionados
                            var nuevaFecha = new Date(anio, mes, dia);

                            var nuevoValor = nuevaFecha.toISOString().substring(0, 10);
                            fechaInput.value = nuevoValor;

                            var fechaInicioInput = fechaInput.parentElement.querySelector('input[name^="fecha_inicio"]');
                            var fechaInicio = new Date(fechaInicioInput.value);

                            var fechaFinInput = fechaInput.parentElement.querySelector('input[name^="fecha_fin"]');
                            var fechaFin = new Date(fechaFinInput.value);

                            // Validar que la fecha de fin no sea menor a la fecha de inicio
                            if (nuevaFecha < fechaInicio) {
                                alert("La fecha de fin no puede ser menor a la fecha de inicio");
                            }

                            // Validar que la fecha de inicio no sea mayor a la fecha de fin
                            if (fechaInicio > fechaFin) {
                                alert("La fecha de inicio no puede ser mayor a la fecha de fin");
                            }
                            }
                        </script>
                                                    <!-- Boton para registrar -->
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" class="btn btn-success">Registrar</button>
                                <a href="./?view=planpago&opt=all"  onclick="mostrarAlerta()" class="btn btn-primary">Cancelar</a>
                                <script>
                                function mostrarAlerta() {
                                    alert("El nuevo del plan de pago fue cancelado.");
                                }
                                </script>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
                <!--Actualizar de Aspirante -->
            <?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "edit") :
            $a = PlandepagoData::getById($_GET["id"]);
            ?>
                <div class="row">
                    <div class="col-md-12">
                        <h1>Editar</h1>
                        <br>
                        <form class="form-horizontal" method="post" id="addcategory" action="./?action=planpago&opt=edit" role="form">
                            <?php
                            $con = Database::getCon();
                            $sql_periodo = "SELECT * FROM period WHERE id = '" . $a->periodo . "'";
                            $query_periodo = mysqli_query($con, $sql_periodo);
                            $pe = mysqli_fetch_array($query_periodo);
                            $id_periodo = $pe['id'];
                            $name_periodo = $pe['name'];
                            ?>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 control-label">Nombre de Periodo</label>
                                <div class="col-md-6">
                                    <input class="form-control" name="periodo" id="periodo" value="<?php echo $name_periodo; ?>" readonly>
                                </div>
                            </div>
                            <!--CARRERA-->
                            <?php
                            $sql_carrera = "SELECT * FROM team WHERE id = '" . $a->carrera . "'";
                            $query_carrera = mysqli_query($con, $sql_carrera);
                            $ca = mysqli_fetch_array($query_carrera);
                            $id_carrera = $ca['id'];
                            $name_carrera = $ca['grade'];
                            ?>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 control-label">Grupo</label>
                                <div class="col-md-6">
                                    <input class="form-control" name="carrera" id="carrera" value="<?php echo $name_carrera; ?>" readonly>
                                </div>
                            </div>
                            <!-- ALUMNOS -->
                            <?php
                            $sql_alumno = "SELECT * FROM person WHERE id = '" . $a->alumno . "'";
                            $query_alumno = mysqli_query($con, $sql_alumno);
                            $al = mysqli_fetch_array($query_alumno);
                            $id_alumno = $al['id'];
                            $name_alumno = $al['name'];
                            $apellidos_alumno = $al['lastname'];
                            $id_beca = $al['beca'];
                            $id_promo = $al['promocion'];
                            ?>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 control-label">Alumnos</label>
                                <div class="col-md-6">
                                    <input class="form-control" name="alumn_id" id="alumn_id" value="<?php echo $name_alumno . " " . $apellidos_alumno; ?>" readonly>
                                </div>
                            </div>
                            <!-- CONCEPTOS -->
                            <?php
                            $sql_products = "SELECT * FROM products WHERE product_id = '" . $a->concepto . "'";
                            $query_products = mysqli_query($con, $sql_products);
                            $pr = mysqli_fetch_array($query_products);
                            $name_products = $pr['product_name'];
                            ?>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 control-label">Producto</label>
                                <div class="col-md-6">
                                    <label class="form-control" name="concepto1" id="concepto1" readonly>
                                        <option value="<?php echo $a->concepto ?>" selected> <?php echo  $name_products ?></option>
<!-- 
                                        <?php foreach (ProductsData::getAll() as $prod) : ?>
                                            <option value="<?php echo $prod->product_id; ?>"><?php echo $prod->product_name; ?></option>
                                        <?php endforeach; ?> -->
                                    </select>
                                </div>
                            </div>
                            <!-- Cuentas con beca -->
                            <?php
                            $sql_1 = "SELECT * FROM becas WHERE id = '" . $id_beca . "'";
                            $query_1 = mysqli_query($con, $sql_1);
                            $con_1 = mysqli_fetch_array($query_1);
                            if ($id_beca == null) {
                                $name_beca = "Sin Beca Asiganda";
                            } else {
                                $name_beca = $con_1['name'];
                            }
                            ?>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 control-label">Aplica beca</label>
                                <div class="col-md-6">
                                    <input class="form-control" name="cuenta_beca" id="cuenta_beca" value="<?php echo $name_beca; ?>" readonly>
                                </div>
                            </div>
                            <?php
                            $sql_1 = "SELECT * FROM becas WHERE id = '" . $id_promo . "' AND tipo = 2";
                            $query_1 = mysqli_query($con, $sql_1);
                            $con_1 = mysqli_fetch_array($query_1);
                            if ($id_promo == null) {
                                $name_promo = "Sin Promoción Asiganda";
                            } else {
                                $name_promo = $con_1['name'];
                            }
                            ?>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 control-label">Aplica promoción</label>
                                <div class="col-md-6">
                                    <input class="form-control" name="cuenta_beca" id="cuenta_beca" value="<?php echo $name_promo; ?>" readonly>
                                </div>
                            </div>
                            <!--Fecha de pago  -->
                            <?php
                            $ip = $a->fecha_inicio_pago;
                            $fp = $a->fecha_fin_pago;
                            ?>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 control-label">Fechas de pago</label>
                                <div class="col-md-2">
                                    <Label>Fecha de inicio</Label>
                                    <input class="form-control" type="date" name="concepto" id="concepto" value="<?php echo $ip; ?>" >
                                </div>
                                <div class="col-md-2">
                                    <Label>Fecha de fin</Label>
                                    <input class="form-control" type="date" name="concepto2" id="fecha_fin" value="<?php echo $fp ?>" >
                                </div>
                                
                            </div>
                            <label for="inputEmail1" class="col-lg-2 control-label">Fechas de pago</label>
                            <!-- Actializar Datos  -->
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <input type="hidden" name="id" value="<?php echo $a->id; ?>"> <!-- actualiza los datos por ID -->
                                    <button type="submit" class="btn btn-success">Actualizar</button>
                                    <a href="./?view=planpago&opt=all"  onclick="mostrarAlerta()" class="btn btn-primary">Cancelar</a>
                                    <script>
                                    function mostrarAlerta() {
                                        alert("Los cambios del plan de pago fueron cancelados.");
                                    }
                                    </script>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
<?php endif; ?>
<!-- selecione el periodo -->
<script>
    $(document).ready(function() {
        $('#periodo').on('change', function() {
            if ($('#periodo').val() == "") {
                $('#grupo').empty();
                $('<option value = "">-</option>').appendTo('#grupo');
                $('#grupo').attr('disabled', 'disabled');
            } else {
                $('#grupo').removeAttr('disabled', 'disabled');
                $('#grupo').load('core/app/ajax/periodo_planpago.php?periodo=' + $('#periodo').val());
            }
        });
    });
    // para que no se abra el select
    /*  $('#periodo_as').on('mousedown', function(e) {
         e.preventDefault();
         this.blur();
         window.focus();
     }); */
</script>
<!-- FIn del script -->
<!-- Sellecion del alumno por medio del grupo -->
<script>
    $(document).ready(function() {
        $('#grupo').on('change', function() {
            if ($('#grupo').val() == "", $('#periodo').val() == "") {
                $('#alumn_id').empty();
                $('<option value = "">-</option>').appendTo('#alumn_id');
                $('#alumn_id').attr('disabled', 'disabled');
            } else {
                $('#alumn_id').removeAttr('disabled', 'disabled');
                $('#alumn_id').load('core/app/ajax/grupo_planpago.php?grupo=' + $('#grupo').val(), 'periodo=' + $('#periodo').val());
            }
        });
    });
</script>
<!-- Seleccion multiple alumnos -->
<script>
    /*   $('[id="alumn_id"]').selectpicker(); */ /* alumnos */
    $('[id="productos"]').selectpicker(); /* productos */
</script>
<script>
  $(document).ready(function() {
    $('.select2').select2();
    $('.js-example-basic-multiple').select2();
  });
</script>
<script>
function eliminaPlan(boton) {
    const id_pago = boton.getAttribute('data-id');
           "index.php?action=planpago&opt=del&id=<?php echo $pay->id; ?>"
 
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`index.php?action=planpago&opt=del&id=${id_pago}`, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Eliminado',
                        text: data.message,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Opcional: eliminar fila de la tabla
                        const fila = boton.closest('tr');
                        if (fila) fila.remove();

                        // Redirigir si hay redirect
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    });
                } else {
                    Swal.fire('Error', data.error, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error al eliminar el plan.', 'error');
            });
        }
    });
}
</script>
<style>
.select2-container  {
  max-width: 100%;
  min-width: 100%;
}
</style>
<!-- Fin  -->
