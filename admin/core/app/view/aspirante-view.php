<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all"): ?>

    <div class="row">

        <div class="col-md-12">

            

            

            <h4><img src="../storage/posts/nuevo.png"  width="52px"> <strong>Alta de Aspirantes</strong></h4>

		    <h5>La información mostrada en este espacio es para el alta de datos de aspirantes, se requiere validación para ser cambiados a estatus de <strong>estudiante.</strong></h5>



            <a href="./?view=home" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a> 

            <a href="./?view=aspirante&opt=new" class="btn btn-success"><i class='fa fa-th-list'></i> Nuevo Aspirante</a>

            <br>

            <br>

            <?php

            $teams = AspiranteData::getAll();

            if (count($teams) > 0) {

                // si hay usuarios

                ?>

                <div class="box box-primary">

                    <div class="box-body">

                        <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">

                        <table class="table table-bordered datatable table-hover">

                            <thead class="bg-warning font-weight-bold p-3 text-left">

                                <tr>

                                    <!-- <th class="bg-light font-weight-bold p-3 text-left">Matrícula</th> -->

                                    <th>Nombre</th>

                                    <!-- <th class="bg-light font-weight-bold p-3 text-left">Dirección</th> -->

                                    <th >Correo</th>

                                    <th >Teléfono</th>

                                    <th >Programa</th>

                                    <th >Beca</th>

                                    <th >Inscripción</th>

                                    <th >Estatus</th>

                                    <th ></th>

                                </tr>

                            </thead>



                            <?php

                            foreach ($teams as $team) {

                                $car = $team->carrera;

                                $co = EducationalProgramData::getById($car);

                                $b = $team->beca;

                                $b1 = BecasData::getById($b);

                                $p = $team->promocion;

                                $p1 = BecasData::getById($p);

                                $team->status; /* STATUS DE LLAMADAS  */

                                if ($team->status == 0) {

                                    $lbl_status = "Sin Validar";

                                    $lbl_class = 'label label-info';

                                } elseif ($team->status == 2) {

                                    $lbl_status = "call 1";

                                    $lbl_class = 'label label-primary';

                                } elseif ($team->status == 3) {

                                    $lbl_status = "call 2";

                                    $lbl_class = 'label label-success';

                                } elseif ($team->status == 4) {

                                    $lbl_status = "call 3";

                                    $lbl_class = 'label label-warning';

                                } elseif ($team->status == 5) {

                                    $lbl_status = "Sin Localizar";

                                    $lbl_class = 'label label-danger';

                                }

                                ?>

                                <tr>

                                    <!--   <td><?php echo $team->code; ?></td> -->

                                    <td>

                                        <?php echo $team->name . " " . $team->lastname; ?>

                                    </td>

                                    <!--  <td>?php echo $team->address; ?></td> -->

                                    <td>

                                        <?php echo $team->person_email; ?>

                                    </td>

                                    <td>

                                        <?php echo $team->phone; ?>

                                    </td>

                                    <td>

                                        <?php echo $co->name; ?>

                                    </td>

                                    <td>

                                        <?php if ($b1 != null) {

                                            echo $b1->name;

                                        } ?>

                                    </td><!-- cuando el campo esta vacio -->

                                    <td>

                                        <?php echo $p1->name; ?>

                                    </td>

                                    <td>

                                        <span class="<?php echo $lbl_class; ?>"><?php echo $lbl_status; ?></span>

                                    </td>

                                    <td>

                                        <div class="btn-group pull-right">

                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"

                                                aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>

                                            <ul class="dropdown-menu">

                                                <li><a href="index.php?view=aspirante&opt=edit&id=<?php echo $team->id; ?>"><i

                                                            class="fa fa-edit"></i>Editar</a></li>

                                                <li>
                                                    <a href="index.php?action=aspirante&opt=del&id=<?php echo $team->id; ?>" 
                                                    onclick="eliminarAspirante(this); return false;">
                                                    <i class="fa fa-trash text-danger"></i> Eliminar
                                                    </a>
                                                </li>

                                               <li><a href="index.php?view=aspirante&opt=validar&id=<?php echo $team->id; ?>" class="text-success">
                                                <i class="fa fa-check-circle text-success fa-lg"></i> <strong>Validar</strong></a></li>

                                           





                                            </ul>

                                        </div>

                                    </td>

                                </tr>

                                <?php

                            }

                            echo "</table></div></div>";

            } else {

                echo "<p class='alert alert-danger'>No hay Aspirantes</p>";

            }

            ?>

                    </table>

                    </div>

                </div>

            </div>

            <!--Nueva Asignatura -->

        <?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "new"): ?>

            <div class="row">

                <div class="col-md-12">

                    <h1>Nuevo Aspirante</h1>

                    <br>

                    <form class="form-horizontal" method="post" id="addcategory" action="./?action=aspirante&opt=add"

                        role="form">

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>

                            <div class="col-md-6">

                                <input type="text" name="name" required class="form-control" id="name" placeholder="Nombre"

                                    required>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Apellidos*</label>

                            <div class="col-md-6">

                                <input type="text" name="lastname" required class="form-control" id="lastname"

                                    placeholder="Apellidos" required>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Fecha de Nacimiento*</label>

                            <div class="col-md-6">

                                <input type="date" name="fecha_n" required class="form-control" id="fecha_n"

                                    placeholder="Fecha de Nacimiento" required>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Nacionalidad*</label>

                            <div class="col-md-6">

                                <select class="form-control" name="nacionalidad" id="nacionalidad"

                                    onchange="toggleInputs()">

                                    <option value="null">-- SELECCIONE --</option>

                                    <option value="1">Mexicana</option>

                                    <option value="2">Extranjero</option>

                                </select>

                            </div>

                        </div>

                        <div class="form-group" id="curpField" style="display: none;">

                            <label for="inputEmail1" class="col-lg-2 control-label">CURP*</label>

                            <div class="col-md-6">

                                <input type="text" name="curp" class="form-control" maxlength="18" id="curp"

                                    placeholder="CURP">

                            </div>

                        </div>

                        <div class="form-group" id="docExtranjeroField" style="display: none;">

                            <label for="inputEmail1" class="col-lg-2 control-label">Documentos Extranjero*</label>

                            <div class="col-md-6">

                                <input type="text" name="documentos_extranjero" class="form-control"

                                    id="documentos_extranjero" value="EXT" readonly>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Genero*</label>

                            <div class="col-md-6">

                                <input type="radio" name="genero" id="genero" value="FEMENINO"> Femenino

                                <input type="radio" name="genero" id="genero" value="MASCULINO" style="margin-left: 15px;">

                                Masculino<br>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Correo Personal*</label>

                            <div class="col-md-6">

                                <input type="text" name="person_email" class="form-control" id="person_email"

                                    placeholder="@" required>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Telefono*</label>

                            <div class="col-md-6">

                                <input type="text" name="phone" class="form-control" maxlength="10" id="phone"

                                    placeholder="Telefono" required>

                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Carrera*</label>
                            <div class="col-md-6">
                                <select class="form-control" name="carrera" id="carrera" required>
                                    <option value="">-- SELECCIONE --</option>
                                    <?php foreach (EducationalProgramData::getAll() as $al): ?>
                                        <option 
                                            value="<?php echo $al->id; ?>"
                                            data-modalidad="<?php echo $al->type; ?>">
                                            <?php echo $al->name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <!-- <label class="col-lg-2 control-label">Modalidad*</label> -->
                            <div class="col-md-6">
                                <input 
                                    type="hidden" 
                                    name="modalidad"
                                    id="modalidad"
                                    class="form-control"
                                    placeholder="Modalidad de la carrera"
                                    readonly
                                    required>
                            </div>
                        </div>


                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Beca*</label>

                            <div class="col-md-6">

                                <select class="form-control" name="beca" id="beca">

                                    <option value="NULL">-- SELECCIONE --</option>

                                    <?php foreach (BecasData::getBeca() as $beca): ?>

                                        <option value="<?php echo $beca->id; ?>"><?php echo $beca->name . "  " . $beca->porcentaje . "%" ?></option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Promoción*</label>

                            <div class="col-md-6">

                                <select class="form-control" name="promo" id="promo">

                                    <option value="NULL">-- SELECCIONE --</option>

                                    <?php foreach (BecasData::getPromociones() as $promo): ?>

                                        <option value="<?php echo $promo->id; ?>"><?php echo $promo->name . "  " . $promo->porcentaje . "%" ?></option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <div class="col-lg-offset-2 col-lg-10">

                                <button type="submit" class="btn btn-success">Agregar Aspirante</button> 

                               <a href="#" onclick= "mostrarAlerta()" class="btn btn-primary">Cancelar</a>

                                <script>

                                    function mostrarAlerta(){
                                        Swal.fire({
                                            icon: "warning",
                                            title: "Cancelacion",
                                            text: 'Los cambios fueron cancelados.',
                                            showConfirmButton: true, // solo OK
                                            allowOutsideClick: false,
                                            allowEscapeKey: false
                                        }).then(() => {
                                            // Se ejecuta solo al dar OK
                                            window.location.href = "./?view=aspirante&opt=all";
                                        });
                                    }

                                </script>

                            </div>

                        </div>

                        <script>

                            function toggleInputs() {

                                var nacionalidad = document.getElementById("nacionalidad").value;

                                var curpField = document.getElementById("curpField");

                                var docExtranjeroField = document.getElementById("docExtranjeroField");

                                if (nacionalidad === "1") {

                                    curpField.style.display = "block";

                                    docExtranjeroField.style.display = "none";

                                } else if (nacionalidad === "2") {

                                    curpField.style.display = "none";

                                    docExtranjeroField.style.display = "block";

                                }

                            }

                        </script>

                    </form>

                </div>

            </div>

            <!--Actualizar de Aspirante -->

        <?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "edit"):

    $a = AspiranteData::getById($_GET["id"]);

    ?>

            <div class="row">

                <div class="col-md-12">

                    <h1>Editar Aspirante</h1>

                    <br>

                    <form class="form-horizontal" method="post" id="updatecategory" action="./?action=aspirante&opt=update"

                        role="form">

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Nombre</label>

                            <div class="col-md-6">

                                <input type="text" name="name" required class="form-control" id="name"

                                    value="<?php echo $a->name; ?>">

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Apellidos</label>

                            <div class="col-md-6">

                                <input type="text" name="lastname" required class="form-control" id="lastname"

                                    value="<?php echo $a->lastname; ?>">

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Fecha de Nacimiento</label>

                            <div class="col-md-6">

                                <input type="date" name="fecha_n" required class="form-control" id="fecha_n"

                                    value="<?php echo $a->fecha_n; ?>">

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Nacionalidad*</label>

                            <div class="col-md-6">

                                <select class="form-control" name="nacionalidad" id="nacionalidad"

                                    onchange="toggleInputs2()" >

                                    <option value="null">-- SELECCIONE --</option>

                                    <option value="1" <?php if ($a->nacionalidad == "1") echo "selected"; ?>>Mexicana</option>

                                    <option value="2"  <?php if ($a->nacionalidad == "2") echo "selected"; ?>>Extranjero</option>

                                </select>

                            </div>

                        </div>

                        <div class="form-group" id="curpField" style="display: none;">

                            <label for="inputEmail1" class="col-lg-2 control-label">CURP*</label>

                            <div class="col-md-6">

                                <input type="text" name="curp" class="form-control" maxlength="18" id="curp"

                                    value="<?php echo $a->curp; ?>">

                            </div>

                        </div>

                        <div class="form-group" id="docExtranjeroField" style="display: none;">

                            <label for="inputEmail1" class="col-lg-2 control-label">Documentos Extranjero*</label>

                            <div class="col-md-6">

                                <input type="text" name="documentos_extranjero" class="form-control"

                                    id="documentos_extranjero" value="EXT" readonly>

                            </div>

                        </div>

                        <div class="form-group">

                            <?php

                            if ($a->genero == "FEMENINO") {

                                $ck1 = "checked";

                            } else {

                                $ck1 = "";

                            }

                            if ($a->genero == "MASCULINO") {

                                $ck2 = "checked";

                            } else {

                                $ck2 = "";

                            }

                            ?>

                            <label for="inputEmail1" class="col-lg-2 control-label">Genero</label>

                            <div class="col-md-6">

                                <input type="radio" name="genero" id="genero" value="FEMENINO" <?php echo $ck1 ?>> Femenino

                                <input type="radio" name="genero" id="genero" value="MASCULINO" <?php echo $ck2 ?>

                                    style="margin-left: 15px;"> Masculino

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Correo Personal</label>

                            <div class="col-md-6">

                                <input type="text" name="person_email" class="form-control" id="person_email"

                                    value="<?php echo $a->person_email; ?>">

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Telefono</label>

                            <div class="col-md-6">

                                <input type="text" name="phone" class="form-control" id="phone"

                                    value="<?php echo $a->phone; ?>">

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Carrera</label>

                            <?php

                            $con = Database::getCon();

                            $sql_carrera = "SELECT * FROM program WHERE id = '" . $a->carrera . "'";

                            $query_carrera = mysqli_query($con, $sql_carrera);

                            $carrera = mysqli_fetch_array($query_carrera);

                            $id_carrera = $carrera['id'];

                            $nom_carrera = $carrera['name'];
                            $type = $carrera['type'];
                            echo $a->carrera;
                            ?>

                            <div class="col-md-6">
                                <select class="form-control" name="carrera" id="carrera">
                                    <?php foreach (EducationalProgramData::getAll() as $al): ?>
                                        <option
                                            value="<?php echo $al->id; ?>"
                                            data-modalidad="<?php echo $al->type; ?>"
                                            <?php if ($al->id == $a->carrera) echo 'selected'; ?>>
                                            <?php echo $al->name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                        </div>
                        <div class="form-group">
                            <!-- <label class="col-lg-2 control-label">Modalidad</label> -->

                            <div class="col-md-6">
                                <input 
                                    type="hidden"
                                    class="form-control"
                                    name="modalidad"
                                    id="modalidad"
                                    value="<?php echo $type; ?>"
                                    readonly>
                            </div>
                        </div>


                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Beca</label>

                            <?php

                            $sql_beca = "SELECT * FROM becas WHERE id = '" . $a->beca . "' AND tipo = 1";

                            $query_beca = mysqli_query($con, $sql_beca);

                            $beca = mysqli_fetch_array($query_beca);

                            $id_beca = $beca['id'];

                            $nom_beca = $beca['name'];

                            ?>

                            <div class="col-md-6">

                                <select class="form-control" name="beca" id="beca">

                                    <option value="<?php echo $a->beca ?>" selected> <?php echo $nom_beca ?></option>

                                    <?php foreach (BecasData::getBeca() as $beca): ?>

                                        <option value="<?php echo $beca->id; ?>"><?php echo $beca->name; ?></option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Promocion</label>

                            <?php

                            $sql_beca = "SELECT * FROM becas WHERE id = '" . $a->promocion . "' AND tipo = 2";

                            $query_beca = mysqli_query($con, $sql_beca);

                            $beca = mysqli_fetch_array($query_beca);

                            $id_beca = $beca['id'];

                            $nom_beca = $beca['name'];

                            ?>

                            <div class="col-md-6">

                                <select class="form-control" name="promocion" id="promocion">

                                    <option value="<?php echo $a->promocion ?>" selected> <?php echo $nom_beca ?></option>

                                    <?php foreach (BecasData::getPromociones() as $beca): ?>

                                        <option value="<?php echo $beca->id; ?>"><?php echo $beca->name; ?></option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <div class="col-lg-offset-2 col-lg-10">

                                <input type="hidden" name="id" value="<?php echo $a->id; ?>">

                                <!-- actualiza los datos por ID -->

                                <button type="submit" class="btn btn-success">Actualizar Aspirante</button>

                                <a href="javascript:history.back()" onclick="AspiranteEditCancel()" class="btn btn-primary">Cancelar</a>

                                <script>

                                    function AspiranteEditCancel(){

                                        alert("Editar Aspirante cancelado.")

                                    }

                                </script>

                            </div>

                        </div>

                        <script>

                            function toggleInputs2() {

                                // var nacionalidad = document.getElementById("nacionalidad").value;

                                var selectElement = document.getElementById("nacionalidad");

                                var nacionalidad = selectElement.value;

                                var curpField = document.getElementById("curpField");

                                var docExtranjeroField = document.getElementById("docExtranjeroField");

                                if (nacionalidad === "1") {

                                    curpField.style.display = "block";

                                    docExtranjeroField.style.display = "none";

                                    curpField.value = ""; // Limpiar el valor del campo

                                } else if (nacionalidad === "2") {

                                    curpField.style.display = "none";

                                    docExtranjeroField.style.display = "block";

                                }

                            }

                            toggleInputs2();

                        </script>

                    </form>

                </div>

            </div>

            <!--Validar Inforamcion -->

        <?php elseif (isset($_GET["opt"]) && $_GET["opt"] == "validar"):

    $a = AspiranteData::getById($_GET["id"]);

    ?>

            <div class="row">

                <div class="col-md-12">

                    <h1>Validar datos del Aspirante</h1>

                    <br>

                    <form class="form-horizontal" method="post" id="validarecategory" action="./?action=aspirante&opt=validar"

                        role="form">

                        <?php

                        $con = Database::getCon();

                        $year = date("Y");         // Ej: 2025
                        $year_short = date("y");   // Ej: 25
                        $mes = date("m");          // Ej: 04
                        $programa = $a->carrera;   // Ej: 6

                        $prefix = $year_short . $mes . $programa;

                        // Buscar la última matrícula generada con ese prefijo
                        $sql_ultimo = "SELECT code FROM person 
                                    WHERE code LIKE '{$prefix}%' 
                                    ORDER BY CAST(SUBSTRING(code, -3) AS UNSIGNED) DESC 
                                    LIMIT 1";

                        $query_ultimo = mysqli_query($con, $sql_ultimo);
                        $data = mysqli_fetch_assoc($query_ultimo);

                        if ($data && isset($data['code'])) {
                            // Extraer los últimos 3 dígitos
                            $ultimo_consecutivo = intval(substr($data['code'], -3));
                            $nuevo_consecutivo = $ultimo_consecutivo + 1;
                        } else {
                            // Si no hay registros previos
                            $nuevo_consecutivo = 1;
                        }

                        $consecutivo = str_pad($nuevo_consecutivo, 3, "0", STR_PAD_LEFT);

                        // Generar matrícula
                        $matricula = $prefix . $consecutivo;

                        
                        ?>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Matricula Asignada</label>

                            <div class="col-md-6">

                                <input type="text" class="form-control" name="code" id="code"

                                    value="<?php echo $matricula ?>" readonly onmousedown="return false" ;>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Nombre</label>

                            <div class="col-md-6">

                                <input type="text" name="name" required class="form-control" id="name"

                                    value="<?php echo $a->name; ?>" readonly>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Apellidos</label>

                            <div class="col-md-6">

                                <input type="text" name="lastname" required class="form-control" id="lastname"

                                    value="<?php echo $a->lastname; ?>" readonly>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Fecha de Nacimiento</label>

                            <div class="col-md-6">

                                <input type="date" name="fecha_n" required class="form-control" id="fecha_n"

                                    value="<?php echo $a->fecha_n; ?>" readonly>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label"> Nacionalidad</label>

                            <div class="col-md-6">

                                <select name="nacionalidad" id="nacionalidad" class="form-control" readonly>

                                    <option value="1" <?php if ($a->nacionalidad == 1) {

                                        echo "selected";

                                    } ?>>Mexicana</option>

                                    <option value="2" <?php if ($a->nacionalidad == 2) {

                                        echo "selected";

                                    } ?>>Extranjero</option>

                                </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">CURP</label>

                            <div class="col-md-6">

                                <input type="text" name="curp" required class="form-control" maxlength="18" id="curp"

                                    value="<?php echo $a->curp; ?>" readonly>

                            </div>

                        </div>

                        <div class="form-group">

                            <?php

                            if ($a->genero == "FEMENINO") {

                                $ck1 = "checked";

                            } else {

                                $ck1 = "";

                            }

                            if ($a->genero == "MASCULINO") {

                                $ck2 = "checked";

                            } else {

                                $ck2 = "";

                            }

                            ?>

                            <label for="inputEmail1" class="col-lg-2 control-label">Genero</label>

                            <div class="col-md-6">

                                <input type="radio" name="genero" id="genero" value="FEMENINO" <?php echo $ck1 ?>> Femenino

                                <input type="radio" name="genero" id="genero" value="MASCULINO" <?php echo $ck2 ?>

                                    style="margin-left: 15px;"> Masculino

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Correo Personal</label>

                            <div class="col-md-6">

                                <input type="text" name="person_email" class="form-control" id="person_email"

                                    value="<?php echo $a->person_email; ?>" readonly>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Telefono</label>

                            <div class="col-md-6">

                                <input type="text" name="phone" class="form-control" id="phone" maxlength="10"

                                    value="<?php echo $a->phone; ?>" readonly>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Carrera</label>

                            <?php

                            $con = Database::getCon();

                            $sql_carrera = "SELECT * FROM program WHERE id = '" . $a->carrera . "'";

                            $query_carrera = mysqli_query($con, $sql_carrera);

                            $carrera = mysqli_fetch_array($query_carrera);

                            $id_carrera = $carrera['id'];

                            $nom_carrera = $carrera['name'];

                            ?>

                            <div class="col-md-6">

                                <input class="form-control" name="carrera" id="carrera" value="<?php echo $nom_carrera; ?>"

                                    readonly>

                            </div>

                        </div>

                        <!-- Periodo al que pertenece -->

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Nombre de Periodo</label>

                            <div class="col-md-6">

                                <select name="name_periodo" id="name_periodo" data-live-search="true"

                                    class="form-control select" value="<?php echo $name_periodo; ?>" required>

                                    <option value="">-- SELECCIONE --</option>

                                    <?php foreach (PeriodData::getAll() as $peri): ?>

                                        <option value="<?php echo $peri->id; ?>"><?php echo $peri->name; ?></option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                        </div>

                        <!-- Sementre -->

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Periodo</label>

                            <div class="col-md-6">

                                <select name="periodo_as" id="periodo_as" class="form-control select"

                                    value="<?php echo $periodo_as; ?>" readonly>

                                </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Beca</label>

                            <?php

                            $con = Database::getCon();

                            $sql_beca = "SELECT * FROM becas WHERE id = '" . $a->beca . "'";

                            $query_beca = mysqli_query($con, $sql_beca);

                            $beca = mysqli_fetch_array($query_beca);

                            $id_beca = $beca['id'];

                            $nom_beca = $beca['name'];

                            ?>

                            <div class="col-md-6">

                                <input class="form-control" name="beca" id="beca" value="<?php echo $nom_beca; ?>" readonly>

                            </div>

                        </div>

                        <!-- promocion -->

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Promoción</label>

                            <?php

                            $con = Database::getCon();

                            $sql_promo = "SELECT * FROM becas WHERE id = '" . $a->promocion . "'";

                            $query_promo = mysqli_query($con, $sql_promo);

                            $promo = mysqli_fetch_array($query_promo);

                            $id_promo = $promo['id'];

                            $nom_promo = $promo['name'];

                            ?>

                            <div class="col-md-6">

                                <input class="form-control" name="promo" id="promo" value="<?php echo $nom_promo; ?>"

                                    readonly>

                            </div>

                        </div>

                        <!-- correo institucional -->

                        <!--correo -->

                        <?php

                        // $con = Database::getCon();

                        // $years = date("Y");

                        // $sql_correo = "SELECT code FROM person WHERE year(created_at) = $years";

                        // $query_correo = mysqli_query($con, $sql_correo);

                        // $correo = count(mysqli_fetch_all($query_correo));

                        // $correo = str_pad($correo + 1, 3, "0", STR_PAD_LEFT); /* La ventaja de usar str_pad, es que puedes modificar el número de espacios a rellenar con solo cambiar el 2º parámetro, o el carácter de relleno cambiando el 3º parámetro. Además puedes pasar un 4º parámetro con los valores STR_PAD_LEFT, STR_PAD_RIGHT o STR_PAD_BOTH para rellenar por la izquierda, derecha o ambos lados de la cadena original. */

                        ?>

                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 control-label">Correo Institucional</label>

                            <div class="col-md-6">

                                <input type="mail" name="correo" required class="form-control" id="correo"

                                    value="<?php echo $matricula. "" . '@iemueem.edu.mx' ?>" readonly>

                            </div>

                        </div>

                        <!-- -->

                        <div class="form-group">

                            <div class="col-lg-offset-2 col-lg-10">

                                <input type="hidden" name="id" value="<?php echo $a->id; ?>">

                                <!-- actualiza los datos por ID -->

                                <button type="submit" class="btn btn-success">Validar datos</button>

                                <a href="javascript:history.back()" onclick="mostrarAlerta()" class="btn btn-primary">Cancelar</a>

                                <script>

                                    function mostrarAlerta(){

                                        alert("La validacion fue cancelada")

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

    $(document).ready(function () {

        $('#name_periodo').on('change', function () {

            if ($('#name_periodo').val() == "") {

                $('#periodo_as').empty();

                $('<option value = "">-</option>').appendTo('#periodo_as');

                $('#periodo_as').attr('disabled', 'disabled');

            } else {

                $('#periodo_as').removeAttr('disabled', 'disabled');

                $('#periodo_as').load('core/app/ajax/periodo_aspirante.php?name_periodo=' + $('#name_periodo').val());

            }

        });

    });

    // para que no se abra el select

    $('#periodo_as').on('mousedown', function (e) {

        e.preventDefault();

        this.blur();

        window.focus();

    });



</script>

<script>
    //Envio del formulario add
    document.getElementById("addcategory").addEventListener("submit", async (e) => {
        e.preventDefault();

        console.log("Entro add");

        const form = e.target; //Todos los campos
        const accionURL = form.getAttribute("action");

    //    console.log(accionURL);
    //    return
        
        //Capturamos todos los campos del formulario en formato FormData
        const formData = new FormData(form);

        try {
            const response = await fetch(accionURL, {
                method: "POST",
                body: formData
                
            })
            
            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    icon: "success",
                    title: "¡Éxito!",
                    text: data.message
                }).then(() => {
                    window.location.href = "./?view=aspirante&opt=all";
                });
                } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.error || "No se pudo guardar el aspirante"
                });
                }

        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Hubo un problema con la petición"
            });
            console.error(error);
        }
        
    })
</script>
<script>
    //Envio del formulario update
    document.getElementById("updatecategory").addEventListener("submit", async (e) => {
        e.preventDefault();

        console.log("Entro update");

        const form = e.target; //Todos los campos
        const accionURL = form.getAttribute("action");

    //    console.log(accionURL);
    //    return
        
        //Capturamos todos los campos del formulario en formato FormData
        const formData = new FormData(form);

        try {
            const response = await fetch(accionURL, {
                method: "POST",
                body: formData
                
            })
            
            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    icon: "success",
                    title: "¡Éxito!",
                    text: data.message
                }).then(() => {
                    window.location.href = "./?view=aspirante&opt=all";
                });
                } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.error || "No se pudo guardar el aspirante"
                });
                }

        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Hubo un problema con la petición"
            });
            console.error(error);
        }
        
    })
</script>
<script>
    //Envio del formulario update
    document.getElementById("validarecategory").addEventListener("submit", async (e) => {
        e.preventDefault();

        console.log("Entro update");

        const form = e.target; //Todos los campos
        const accionURL = form.getAttribute("action");

    //    console.log(accionURL);
    //    return
        
        //Capturamos todos los campos del formulario en formato FormData
        const formData = new FormData(form);

        try {
            const response = await fetch(accionURL, {
                method: "POST",
                body: formData
                
            })
            
            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    icon: "success",
                    title: "¡Éxito!",
                    text: data.message
                }).then(() => {
                    window.location.href = "./?view=aspirante&opt=all";
                });
                } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.error || "No se pudo guardar el aspirante"
                });
                }

        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Hubo un problema con la petición"
            });
            console.error(error);
        }
        
    })

    function eliminarAspirante(el) {
        // console.log("Entró a la función"); // para verificar que se llama
        // alert("Entró a la función"); // si quieres un popup en vez de console

        const url = el.getAttribute("href");

        Swal.fire({
            title: "⚠️ ¿Estás seguro?",
            text: "Se eliminará este aspirante de forma permanente.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
                if (result.isConfirmed) {
                    // aquí en vez de redirigir, llamamos al backend con fetch
                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "¡Eliminado!",
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(() => {
                                    // redirige después de la alerta
                                    window.location.href = data.redirect;
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: data.message || "No se pudo eliminar el registro."
                                });
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Ocurrió un problema en el servidor."
                            });
                        });
                }
            });
    }

</script>
<script>
    //Opcion agregar nuvo aspirante
    document.getElementById('carrera').addEventListener('change', function () {
        let modalidad = this.options[this.selectedIndex].getAttribute('data-modalidad');
        document.getElementById('modalidad').value = modalidad || '';
    });

    //Actualizar nuevo aspirante
    document.getElementById('carrera').addEventListener('change', function () {
        let modalidad = this.options[this.selectedIndex].getAttribute('data-modalidad');
        document.getElementById('modalidad').value = modalidad || '';
    });


</script>
<!-- FIn del script -->