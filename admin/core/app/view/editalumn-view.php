<?php
$user = PersonData::getById($_GET["id"]);
if ($user->kind != 3) {
  Core::redir("./");
}
$con = Database::getCon();

?>
<h1>Expediente del Estudiante</h1>
<br>
<a href="./?view=alumns" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a> 
<!-- action="index.php?action=alumns&opt=upd" -->
<section class="content">
  <div class="row">
    <form class="form-horizontal" method="post" id="addcategory" action="index.php?action=alumns&opt=upd" role="form">

      <div class="col-md-12">

        <div class="small-box bg-navy">
          <div class="inner">
            <h5 align="left"><i class="fa fa-university"></i> <strong>Informacion Escolar</strong></h5>
          </div>
        </div>


        <div class="nav-tabs-custom">

          <ul class="nav nav-tabs">
            <li class="active"><a href="#acceso" data-toggle="tab" aria-expanded="false">Informacion Escolar</a></li>
          </ul>

          <div class="tab-content">

            <div class="tab-pane active" id="acceso">


              <div class="form-group">

                <label for="inputEmail1" class="col-lg-3 control-label">Matricula*</label>
                <div class="col-md-3">
                  <input type="text" name="code" value="<?php echo $user->code; ?>" class="form-control" id="code" placeholder="Nombre de usuario" disabled="disabled">
                </div>

                <label for="curp" class="col-lg-3 control-label">CURP*</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" disabled="disabled" value="<?php echo $user->curp ?>" maxlength="18" id="curp" name="curp" placeholder="CURP">
                </div>

              </div>

              <div class="form-group">

                <label for="inputEmail1" class="col-lg-3 control-label">Nombre*</label>
                <div class="col-md-3">
                  <input type="text" name="name" value="<?php echo $user->name; ?>" class="form-control" id="name" placeholder="Nombre">
                </div>

                <label for="inputEmail1" class="col-lg-3 control-label">Apellido*</label>
                <div class="col-md-3">
                  <input type="text" name="lastname" value="<?php echo $user->lastname; ?>" class="form-control" id="lastname" placeholder="Apellido">
                </div>

              </div>

              <div class="form-group">

                <label for="inputEmail1" class="col-lg-3 control-label">Correo Institucional*</label>
                <div class="col-md-3">
                  <input type="text" name="email" value="<?php echo $user->email; ?>" class="form-control" id="email" placeholder="Email">
                </div>



                <label for="inputEmail1" class="col-lg-3 control-label">Esta activo</label>
                <div class="col-md-3">
                  <input type="radio" name="is_active" <?php if ($user->is_active) {
                                                          echo "checked";
                                                        } ?>>
                </div>

              </div>

              <div class="form-group">
                <label for="inputEmail1" class="col-lg-3 control-label">Password*</label>
                <div class="col-md-3">
                  <input type="password" name="password" autocomplete="off" class="form-control" id="password" placeholder="Password">
                </div>
                <!-- periodo -->
                <label for="inputEmail1" class="col-lg-3 control-label">Periodo</label>
                <?php
                $sql_peri = "SELECT * FROM period WHERE id = '" . $user->name_periodo . "'";
                $query_peri = mysqli_query($con, $sql_peri);
                $period = mysqli_fetch_array($query_peri);
                $id_peri = $period['id'];
                $nom_peri = $period['name'];
                ?>
                <div class="col-md-3">
                  <select class="form-control" name="name_periodo" id="name_periodo">
                    <option value="<?php echo$user->name_periodo ?>" selected> <?php echo  $nom_peri ?></option>
                    <?php foreach (PeriodData::getALL() as $p_e) : ?>
                      <option value="<?php echo $p_e->id; ?>"><?php echo $p_e->name; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="small-box bg-navy">
            <div class="inner">
              <h5 align="left"><i class="fa fa-graduation-cap"></i> <strong>Datos Básicos del Estudiante <br> <u>* Campos Obligatorios</u></strong></h5>
            </div>
          </div>

          <div class="nav-tabs-custom">

            <ul class="nav nav-tabs">
              <li class="active"><a href="#datos_personales" data-toggle="tab" aria-expanded="false">Datos Personales</a></li>
              <li><a href="#direccion" data-toggle="tab" aria-expanded="false">Direccion</a></li>
              <li><a href="#contacto" data-toggle="tab" aria-expanded="false">Contacto</a></li>
            </ul>

            <div class="tab-content">

              <div class="tab-pane active" id="datos_personales">

                <div class="form-group">

                  <?php
                  if ($user->gender == "FEMENINO") {
                    $ck1 = "checked";
                  } else {
                    $ck1 = "";
                  }
                  if ($user->gender == "MASCULINO") {
                    $ck2 = "checked";
                  } else {
                    $ck2 = "";
                  }

                  ?>

                  <label for="genero" class="col-lg-3 control-label">Género*</label>
                 <div class="col-sm-3">
                    <input type="radio" name="genero" id="genero_f" value="FEMENINO" <?php echo $ck1 ?>> Femenino<br>
                    <input type="radio" name="genero" id="genero_m" value="MASCULINO" <?php echo $ck2 ?>> Masculino<br>
                  </div>

                  <label for="f_nacimiento" class="col-lg-3 control-label">Fecha De Nacimiento*</label>
                  <div class="col-sm-3">
                    <input type="date" class="form-control" value="<?php echo $user->f_nacimiento; ?>" id="f_nacimiento" name="f_nacimiento" placeholder="Fecha De Nacimineto">
                  </div>

                </div>

                <div class="form-group">

                  <label for="nacionalidad" class="col-lg-3 control-label">Nacionalidad*</label>
                  <div class="col-sm-3">
                    <!-- <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" placeholder="Nacionalidad" value="<?php echo $nacionalidad; ?>"> -->
                    <select name="nacionalidad" class="form-control" id="nacionalidad">
                      <option value="1" <?php echo ($user->nationality == 1) ? 'selected' : ''; ?>>Mexicana</option>
                      <option value="2" <?php echo ($user->nationality == 2) ? 'selected' : ''; ?>>Extranjera</option>
                  </select>
                  </div>

                  <label for="phone" class="col-lg-3 control-label">Telefono*</label>
                  <div class="col-sm-3">
                    <input type="tel" class="form-control" id="phone" value="<?php echo $user->phone; ?>" name="phone" placeholder="Telefono con LADA" maxlength="10">
                  </div>

                </div>

                <div class="form-group">

                  <label for="correo" class="col-lg-3 control-label">Correo Personal*</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" id="correo" value="<?php echo $user->person_email; ?>" name="correo" placeholder="Correo Personal">
                  </div>


                  <label for="civil" class="col-lg-3 control-label">Estado Civil*</label>
                  <div class="col-sm-3">
                    <select name="civil" class="form-control" id="civil">
                      <option value="<?php echo $user->civil ?>" selected><?php echo $user->civil ?></option>
                      <option value="Soltero">Soltero</option>
                      <option value="Casado">Casado</option>
                      <option value="Divorciado">Divorciado</option>
                      <option value="Viudo">Viudo</option>
                      <option value="Union Libre">Union Libre</option>
                    </select>
                  </div>

                </div>

              </div>

              <div class="tab-pane" id="direccion">

                <?php

                if (!empty($user->address)) {
                  list($calle, $numero, $numero_exterior, $colonia, $estado, $alcaldia, $cp) = explode(",", $user->address);
                } elseif (empty($user->address)) {
                  $calle = "";
                  $numero = "";
                  $numero_exterior = "";
                  $colonia = "";
                  $estado = "";
                  $alcaldia = "";
                  $cp = "";
                }

                if (!empty($estado)) {

                  $query_estado = mysqli_query($con, "SELECT * FROM estados WHERE nombre = '" . $estado . "' ");
                  $row_estado = mysqli_fetch_array($query_estado);
                  $id_estado = $row_estado['id'];
                }

                if (!empty($alcaldia)) {

                  $query_alcaldia = mysqli_query($con, "SELECT * FROM municipios WHERE nombre = '" . $alcaldia . "' ");
                  $row_alcaldia = mysqli_fetch_array($query_alcaldia);
                  $id_alcaldia = $row_alcaldia['id'];
                }

                ?>

                <div class="form-group ">

                  <div class="col-sm-1"></div>


                  <label for="estado" class="col-lg-2 control-label">Estado*</label>
                  <div class="col-sm-2">
                    <select name="estado" class="form-control" id="estado">
                      <?php if (!empty($estado)) { ?>
                        <option value="<?php echo $id_estado ?>" selected><?php echo $estado ?></option>
                      <?php } else { ?>
                        <option value="" selected>--SELECCIONA--</option>
                      <?php }
                      $sql = "SELECT * FROM estados";
                      $query = mysqli_query($con, $sql);
                      while ($row = mysqli_fetch_array($query)) {
                      ?>
                        <option value="<?php echo $row['id'] ?>"><?php echo ($row['nombre']) ?></option>
                      <?php
                      }

                      ?>
                    </select>
                  </div>

                  <label for="alcaldia" class="col-lg-2 control-label">Alcaldía/Municipio*</label>
                  <div class="col-sm-2">
                    <select name="alcaldia" class="form-control" id="alcaldia">
                      <?php if (!empty($alcaldia)) { ?>
                        <option value="<?php echo $id_alcaldia ?>" selected><?php echo $alcaldia ?></option>
                      <?php } else { ?>
                        <option value="" selected>--SELECCIONA--</option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="col-sm-1"></div>

                </div>

                <div class="form-group ">

                  <div class="col-sm-1"></div>

                  <label for="colonia" class="col-lg-2 control-label">Colonia*</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="colonia" name="colonia" value="<?php echo $colonia ?>" placeholder="Colonia">
                  </div>

                  <label for="calle" class="col-lg-2 control-label">Calle*</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="calle" value="<?php echo $calle ?>" name="calle" placeholder="Calle">
                  </div>

                  <div class="col-sm-1"></div>

                </div>

                <div class="form-group ">

                  <div class="col-sm-1"></div>

                  <label for="numero" class="col-lg-2 control-label">Numero Exterior*</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="numero" value="<?php echo $numero ?>" name="numero" placeholder="Numero Exterior">
                  </div>

                  <label for="numero" class="col-lg-2 control-label">Numero Interior</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="numero_exterior" value="<?php echo $numero_exterior ?>" name="numero_exterior" placeholder="Numero Interior">
                  </div>



                  <div class="col-sm-1"></div>


                </div>

                <div class="form-group ">

                  <div class="col-sm-1"></div>


                  <label for="cp" class="col-lg-2 control-label">Codigo Postal*</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="cp" name="cp" value="<?php echo $cp ?>" maxlength="5" placeholder="Codigo Postal">
                  </div>

                </div>

              </div>

              <div class="tab-pane" id="contacto">

                <div class="form-group ">


                  <label for="telemergencia" class="col-lg-2 control-label">Telefono de Emergencia*</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="telemergencia" maxlength="10" name="telemergencia" placeholder="Telefono Emergencia" value="<?php echo $user->phone_contact ?>">
                  </div>

                  <label for="namecontacto" class="col-lg-2 control-label">Nombre del contacto*</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="namecontacto" name="namecontacto" placeholder="Contacto" value="<?php echo $user->name_contact ?>">
                  </div>

                  <div class="col-sm-1"></div>

                </div>

                <div class="form-group">

                  <label for="inputEmail1" class="col-lg-2 control-label">Padre o Tutor</label>
                  <div class="col-md-10">
                    <select class="form-control" name="parent_id">
                      <option value="">-- SELECCIONE --</option>
                      <?php foreach (PersonData::getParents() as $parent) : ?>
                        <option value="<?php echo $parent->id; ?>" <?php if ($user->parent_id == $parent->id) {
                                                                      echo "selected";
                                                                    } ?>><?php echo $parent->opcion; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="col-lg-5"></div>
          <div class="col-lg-2">
            <input type="hidden" name="alumn_id" value="<?php echo $_GET["id"]; ?>">
            <button type="submit" class="btn bg-navy">Actualizar Alumno</button>
          </div>
          <div class="col-lg-5"></div>
    </form>
  </div>
</section>


<script>
  $(document).ready(function() {
    $('#estado').on('change', function() {
      if ($('#estado').val() == "") {
        $('#alcaldia').empty();
        $('<option value = "">Alcaldia/Municipio</option>').appendTo('#alcaldia');
        $('#alcaldia').attr('disabled', 'disabled');
      } else {
        $('#alcaldia').removeAttr('disabled', 'disabled');
        $('#alcaldia').load('core/app/action/municipio-action.php?estado=' + $('#estado').val());
      }
    });
  });
</script>