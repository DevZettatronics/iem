<?php
$user = PersonData::getById($_GET["id"]);
$con = Database::getCon();
?>
            <h3><img src="../storage/posts/expediente.png"  width="52px"> <strong>Expediente del Estudiante</strong></h3>
 
			
			<a href="./?view=home" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a> 
		
<br><br>

<!-- action="index.php?action=alumns&opt=upd" -->
<section class="content">
  <div class="row">
    <form class="form-horizontal" method="post" id="new_register" action="" role="form" autocomplete="off">

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
                <label for="inputEmail1" class="col-lg-2 control-label">Matricula*</label>
                <div class="col-md-2">
                  <input type="text" name="code" value="<?php echo $user->code; ?>" class="form-control" id="code" placeholder="Nombre de usuario" readonly onmousedown="return false;">
                </div>

                <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
                <div class="col-md-2">
                  <input type="text" name="name" value="<?php echo $user->name; ?>" class="form-control" id="name" placeholder="Nombre" disabled="disabled">
                </div>

                <label for="inputEmail1" class="col-lg-2 control-label">Apellido*</label>
                <div class="col-md-2">
                  <input type="text" name="lastname" value="<?php echo $user->lastname; ?>" class="form-control" id="lastname" placeholder="Apellido" disabled="disabled">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Correo Institucional*</label>
                <div class="col-md-2">
                  <input type="text" name="email" value="<?php echo $user->email; ?>" class="form-control" id="email" placeholder="Email" disabled="disabled">
                </div>

                <label for="inputEmail1" class="col-lg-2 control-label">Esta activo</label>
                <div class="col-md-2">
                  <input type="radio" name="is_active" disabled="disabled" <?php if ($user->is_active) {
                                                                              echo "checked";
                                                                            } ?>>
                </div>

                <label for="inputEmail1" class="col-lg-2 control-label">Contrase&ntilde;a</label>
                <div class="col-md-2">
                  <input type="password" name="password" class="form-control" id="inputEmail1" placeholder="Contrase&ntilde;a">
                  <p class="help-block">La contrase&ntilde;a solo se modificara si escribes algo, en caso contrario no se modifica.</p>
                </div>
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
                // $user->gender || $user->curp || $user->nationality || $user->f_nacimiento || $user->civil || $user->adress || $user->civil || $user->adress != ""
                if ($user->curp != "") {
                  $readonly_curp = "readonly";
                } else {
                  $readonly_curp = "";
                }
                if ($user->gender != "") {
                  $readonly_gender = "readonly";
                } else {
                  $readonly_gender = "";
                }
                if ($user->nationality != "") {
                  $readonly_nationality = "readonly";
                } else {
                  $readonly_nationality = "";
                }
                if ($user->f_nacimiento != "") {
                  $readonly_f_nacimiento = "readonly";
                } else {
                  $readonly_f_nacimiento = "";
                }
                if ($user->address != "") {
                  $readonly_address = "readonly";
                } else {
                  $readonly_address = "";
                }
                if ($user->phone_contact != "") {
                  $readonly_phone_contact = "readonly";
                } else {
                  $readonly_phone_contact = "";
                }
                if ($user->name_contact != "") {
                  $readonly_name_contact = "readonly";
                } else {
                  $readonly_name_contact = "";
                }

  


                ?>

                <label for="genero" class="col-lg-2 control-label">Género*</label>
                <div class="col-sm-2">
                  <input type="radio" <?php echo $readonly_gender ?> name="genero" id="genero" value="femenino" <?php echo $ck1 ?>> Femenino<br>
                  <input type="radio" <?php echo $readonly_gender ?> name="genero" id="genero" value="masculino" <?php echo $ck2 ?>> Masculino<br>
                </div>

                <label for="curp" class="col-lg-2 control-label">CURP*</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" <?php //echo $readonly_curp ?> value="<?php echo $user->curp ?>" maxlength="18" id="curp" name="curp" placeholder="CURP">
                </div>

                <label for="nacionalidad" class="col-lg-2 control-label">Nacionalidad*</label>
                <div class="col-sm-2">
                    <!-- Este es el campo de solo lectura que muestra "Mexicana" o "Extranjera" -->
                    <input type="text" class="form-control" id="nacionalidad" name="nacionalidad_display" value="<?php echo ($user->nationality == 1) ? 'Mexicana' : 'Extranjera'; ?>" readonly>
                    
                    <!-- Este es el campo oculto que guarda el valor real (1 o 2) -->
                    <input type="hidden" name="nacionalidad" value="<?php echo $user->nationality; ?>">
                </div>


              </div>

              <div class="form-group">

                <label for="f_nacimiento" class="col-lg-2 control-label">Fecha De Nacimiento*</label>
                <div class="col-sm-2">
                  <input type="date" class="form-control" <?php //echo $readonly_f_nacimiento ?> value="<?php echo $user->f_nacimiento; ?>" id="f_nacimiento" name="f_nacimiento" placeholder="Fecha De Nacimineto">
                </div>

                <label for="telefono" class="col-lg-2 control-label">Telefono*</label>
                <div class="col-sm-2">
                  <input type="tel" class="form-control" id="telefono" value="<?php echo $user->phone; ?>" name="telefono" placeholder="Telefono con LADA" maxlength="10">
                </div>

                <label for="correo" class="col-lg-2 control-label">Correo Personal*</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="correo" value="<?php echo $user->person_email; ?>" name="correo" placeholder="Correo Personal">
                </div>

              </div>

              <div class="form-group">


                <label for="civil" class="col-lg-2 control-label">Estado Civil*</label>
                <div class="col-sm-2">
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
                list($calle, $numero, $numero_interior, $colonia, $estado, $alcaldia, $cp) = explode(",", $user->address);
              } elseif (empty($user->address)) {
                $calle = "";
                $numero = "";
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
                <?php
                if ($estado != "") {
                  $disabled_estado = "disabled";
                } else {
                  $disabled_estado = "";
                }
                if ($alcaldia != "") {
                  $disabled_alcaldia = "disabled";
                } else {
                  $disabled_alcaldia = "";
                }

                ?>

                <label for="estado" class="col-lg-2 control-label">Estado*</label>
                <div class="col-sm-2">
                  <?php if (!empty($estado)) { ?>
                    <input type="hidden" id="estado" name="estado" value="<?php echo $id_estado ?>">
                  <?php } ?>
                  <select name="estado" <?php echo $disabled_estado ?> class="form-control" id="estado">
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
                  <?php if (!empty($alcaldia)) { ?>
                    <input type="hidden" name="alcaldia" id="alcaldia" value="<?php echo $id_alcaldia ?>">
                  <?php } ?>
                  <select name="alcaldia" <?php echo $disabled_alcaldia ?> class="form-control" id="alcaldia">
                    <?php if (!empty($alcaldia)) { ?>
                      <option value="<?php echo $id_alcaldia ?>" selected><?php echo $alcaldia ?></option>
                    <?php } else { ?>
                      <option value="" selected>--SELECCIONA--</option>
                    <?php } ?>
                  </select>
                </div>

                <label for="colonia" class="col-lg-2 control-label">Colonia*</label>
                <div class="col-sm-2">
                  <input type="text" <?php echo $readonly_address ?> class="form-control" id="colonia" name="colonia" value="<?php echo $colonia ?>" placeholder="Colonia">
                </div>

              </div>

              <div class="form-group ">

                <label for="calle" class="col-lg-2 control-label">Calle*</label>
                <div class="col-sm-2">
                  <input type="text" <?php echo $readonly_address ?> class="form-control" id="calle" value="<?php echo $calle ?>" name="calle" placeholder="Calle">
                </div>

                <label for="numero" class="col-lg-2 control-label">Numero Exterior*</label>
                <div class="col-sm-2">
                  <input type="text" <?php echo $readonly_address ?> class="form-control" id="numero" value="<?php echo $numero ?>" name="numero" placeholder="Numero">
                </div>

                <label for="cp" class="col-lg-2 control-label">Numero Interior</label>
                <div class="col-sm-2">
                  <input type="text" <?php echo $readonly_address ?> class="form-control" id="numero_interior" name="numero_interior"value="<?php echo !empty($numero_interior) ? $numero_interior : ''; ?>" placeholder="Numero Interior">
                </div>

              </div>

              <div class="form-group ">

                <label for="cp" class="col-lg-2 control-label">Codigo Postal*</label>
                <div class="col-sm-2">
                  <input type="text" <?php echo $readonly_address ?> class="form-control" id="cp" name="cp" value="<?php echo $cp ?>" maxlength="5" placeholder="Codigo Postal">
                </div>

              </div>

            </div>

            <div class="tab-pane" id="contacto">

              <div class="form-group ">

                <div class="col-lg-2"></div>

                <label for="telemergencia" class="col-lg-2 control-label">Telefono de Emergencia*</label>
                <div class="col-sm-2">
                  <input type="text" <?php echo $readonly_phone_contact ?> class="form-control" id="telemergencia" maxlength="10" name="telemergencia" placeholder="Telefono Emergencia" value="<?php echo $user->phone_contact ?>">
                </div>

                <label for="namecontacto" class="col-lg-2 control-label">Nombre del contacto*</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" <?php echo $readonly_name_contact ?> id="namecontacto" name="namecontacto" placeholder="Contacto" value="<?php echo $user->name_contact ?>">
                </div>

                <div class="col-lg-2"></div>

              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="col-md-12">

        <div class="small-box bg-navy">
          <div class="inner">
            <h5 align="left"><i class='fa fa-file'></i> <strong>Documentacion <br><br> Toda la documentacion tendra que venir en formato PDF</strong></h5>
            <h5 class="text-center"><strong>LOS ARCHIVOS, DEBERAN TENER EL MISMO NOMBRE COMO SON SOLICITADOS</strong></h5>
          </div>
        </div>


        <div class="nav-tabs-custom">

          <ul class="nav nav-tabs">
            <li class="active"><a href="#documentacion" data-toggle="tab" aria-expanded="false">Documentacion</a></li>
            <li class=""><a href="#controlAcademico" data-toggle="tab" aria-expanded="false">Control de Estatus Académico</a></li>
            <li class="pull-right"><a href="./?view=repository&code=<?php echo  $user->code ?>" class="btn bg-red"><i class='fa fa-th-list'></i> Ver Mis Documentos Cargados</a></li>
          </ul>

          <div class="tab-content">

            <div class="form-group">

              <div class="col-md-12">
                <div class="col-md-4"></div>
                <div class="col-md-4" style="width: 100%;">
                  <!-- <select id="status" class="col-lg-2 form-control" name="status" onChange="mostrar(this.value);"> -->
                  <select id="status" class="col-lg-2 form-control" name="status" onchange="GradoAcademico($(this));">
                    <option value="">--SELECCIONA--</option>
                    <!-- <option value="1">Bachillerato</option> -->
                    <option value="2">Licenciatura</option>
                    <option value="3">Maestria</option>
                    <option value="5">Especialidad</option>
                    <option value="6">Doctorado</option>
                  </select>
                </div>
                <div class="col-md-4"></div>
              </div>
            </div>

            <div class="tab-pane" id="controlAcademico">

              <!------------------- CONTROL ACADEMICO DOCUMENTACION---------------->

              <div class="col-md-12">

                <div class="form-group anyAcademico">

                  <div class="col-md-12">
                    <label for="codigoEtico" class="col-lg-3 control-label codigoEtico">Codigo Ético</label>
                    <div class="col-md-3">
                      <input type="file" id="codigoEtico" accept=".pdf" multiple name="docs[]" class="form-control">
                    </div>
                    <label for="cartaBeca" class="col-lg-3 control-label cartaBeca">Carta Aceptación de Beca</label>
                    <div class="col-md-3">
                      <input type="file" id="cartaBeca" accept=".pdf" multiple name="docs[]" class="form-control">
                    </div>
                    
                    <label for="contrato" class="col-lg-3 control-label contrato">Contrato</label>
                    <div class="col-md-3">
                      <input type="file" id="contrato" accept=".pdf" multiple name="docs[]" class="form-control">
                    </div>

                  </div>
                  <div class="col-md-12">
                    <label for="sesionesMeet" class="col-lg-3 control-label sesionesMeet">Aviso de Sesiones en Google Meet</label>
                    <div class="col-md-3">
                      <input type="file" id="sesionesMeet" accept=".pdf" multiple name="docs[]" class="form-control">
                    </div>
                    <label for="grabacionesMeet" class="col-lg-3 control-label grabacionesMeet">Aviso de Grabaciones en Meet</label>
                    <div class="col-md-3">
                      <input type="file" id="grabacionesMeet" accept=".pdf" multiple name="docs[]" class="form-control">
                    </div>
                  </div>
                </div>

                <div class="form-group superiores">
                  <div class="col-md-12">
                    <label for="idioma" class="col-lg-3 control-label idioma">Certificado de Liberación de Idioma</label>
                    <div class="col-md-3">
                      <input type="file" id="idioma" accept=".pdf" multiple name="docs[]" class="form-control">
                    </div>
                    <label for="hAcademico" class="col-lg-3 control-label hAcademico">Historial Académico </label>
                    <div class="col-md-3">
                      <input type="file" id="hAcademico" accept=".pdf" multiple name="docs[]" class="form-control">
                    </div>
                  </div>
                </div>


    

                <div class="form-group sSocial">
                  <div class="col-md-12">
                    <label for="servicio" class="col-lg-3 control-label servicio">Liberación de Servicio Social</label>
                    <div class="col-md-3">
                      <input type="file" id="servicio" accept=".pdf" multiple name="docs[]" class="form-control">
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <div class="tab-pane active" id="documentacion">

              <!------------------- DOCUMENTACION----------------->

              <div class="form-group any">

                <p for="textBachillerato" class="text-center col-lg-12 textBachillerato">La <b>Identificacion Oficial y Comprobante de Domicilio </b> tendra que ser del padre o tutor*</p>

                <div class="col-md-12">
                  <label for="identificacion" class="col-lg-2 control-label identificacion">Identificacion Oficial</label>
                  <div class="col-md-2">
                    <input type="file" id="identificacion" accept=".pdf" multiple name="docs[]" class="form-control">
                  </div>
                  <label for="comprobanteD" class="col-lg-2 control-label comprobanteD">Comprobante de Domicilio</label>
                  <div class="col-md-2">
                    <input type="file" id="comprobanteD" accept=".pdf" multiple name="docs[]" class="form-control">
                  </div>
                  <label for="curpDocumentacion" class="col-lg-2 control-label curpDocumentacion">CURP</label>
                  <div class="col-md-2">
                    <input type="file" id="curpDocumentacion" accept=".pdf" multiple name="docs[]" class="form-control">
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="actaNacimiento" class="col-lg-2 control-label actaNacimiento">Acta de Nacimiento</label>
                  <div class="col-md-2">
                    <input type="file" id="actaNacimiento" accept=".pdf" multiple name="docs[]" class="form-control">
                  </div>
                  <label for="certificado" class="col-lg-2 control-label certificado"></label>
                  <div class="col-md-2">
                    <input type="file" id="certificado" accept=".pdf" multiple name="docs[]" class="form-control">
                  </div>
                  <label for="titulo" class="col-lg-2 control-label titced titulo"></label>
                  <div class="col-md-2">
                    <input type="file" id="titulo" accept=".pdf" multiple name="docs[]" class="form-control titced">
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="cedula" class="col-lg-2 control-label titced cedula"></label>
                  <div class="col-md-2">
                    <input type="file" id="cedula" accept=".pdf" multiple name="docs[]" class="form-control titced">
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="col-lg-5"></div>
        <div class="col-lg-2" style="text-align: center;">
            
            
          <button type="submit" class="btn bg-navy" style="font-size: 18px;"><i class='fa fa-upload'></i> Actualizar Información</button>
        </div>

        <div class="col-lg-5"></div>
    </form>
  </div>
</section>

<div class="modal" tabindex="-1" role="dialog" id="modalMensaje">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Mensaje Del Sistema</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="mensaje"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<script>
  function GradoAcademico(Select) {
    let val = Select.val();
    LimpiaForm();

    if (val == 1) {
      /**  Bachillerato **/
      $('.any,.anyAcademico').fadeIn('slow');
      $('.textBachillerato').show()
      $('.titced').hide()
      $('.certificado').html("Certificado de Secundaria ");
    } else if (val == 2) {
      /**  Licenciatura **/
      $('.any,.anyAcademico,.superiores,.sSocial').fadeIn('slow')
      $('.textBachillerato').hide()
      $('.titced').hide()
      $('.certificado').html("Certificado de Bachillerato ");
    } else if (val == 3) {
      /**  maestria psicoterapia**/
      $('.any,.anyAcademico,.superiores,.maestriaPsicoterapia,.aDidacticas').fadeIn('slow');
      $('.textBachillerato').hide()
      $('.titced').show()
      $('.certificado').html("Certificado Total de Licenciatura ");
      $('.titulo').html("Título de Licenciatura");
      $('.cedula').html("Cedula de Licenciatura");
    } else if (val == 4) {
      /**  maestria educacion **/
      $('.any,.anyAcademico,.superiores').fadeIn('slow');
      $('.textBachillerato').hide()
      $('.titced').show()
      $('.certificado').html("Certificado Total de Licenciatura ");
      $('.titulo').html("Título de Licenciatura");
      $('.cedula').html("Cedula de Licenciatura");
    } else if (val == 5) {
      /**  especialidad **/
      $('.any,.anyAcademico,.superiores,.aDidacticas').fadeIn('slow');
      $('.textBachillerato').hide()
      $('.titced').show()
      $('.certificado').html("Certificado Total de Licenciatura ");
      $('.titulo').html("Título de Licenciatura");
      $('.cedula').html("Cedula de Licenciatura");
    } else if (val == 6) {
      /**  doctorado **/
      $('.any,.anyAcademico,.superiores').fadeIn('slow');
      $('.textBachillerato').hide()
      $('.titced').show()
      $('.certificado').html("Certificado de Maestría ");
      $('.titulo').html("Titulo de Maestría ");
      $('.cedula').html("Cedula de Maestría ");
    }
  }

  function LimpiaForm() {
    $(".any,.anyAcademico,.superiores,.maestriaPsicoterapia,.aDidacticas,.sSocial").hide();
    $("#identificacion,#comprobanteD,#curpDocumentacion,#actaNacimiento,#certificado,#codigoEtico,#cartaBeca,#sesionesMeet,#grabacionesMeet,#idioma,#hAcademico,#nHorizonte,#cLiberacion,#didacticas,#servicio,#cedula,#titulo").val('');
  }
  LimpiaForm();


  $(document).ready(function() {
    $('[name="docs[]"]').change(function() {
      var maxSize = 2048;

      var file = this.files[0];
      var imageType = file.type;
      var match = ["application/pdf"];

      var fileSize = file.size;
      var sizeKilo = parseInt(fileSize / 1024);
      if (!match.includes(imageType)) {
        $("#modalMensaje").modal('show');
        $("#mensaje").html('Favor de escoger su documento en formato PDF');
        $(this).val("");
        return false;
      }
      if (sizeKilo > maxSize) {
        $("#modalMensaje").modal('show');
        $("#mensaje").html('Cada Documento Debe Tener Un Peso Maximo De 2MB');
        $(this).val("");
        return false;
      }
    });


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

  $("#new_register").submit(function(event) {

    var parametros = $(this).serialize();
    var formData = new FormData(document.getElementById("new_register"));
    $.ajax({
      type: "POST",
      url: "core/app/action/alumns-action.php",
      dataType: "html",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function(objeto) {
        $("#modalMensaje").modal('show');
        $("#mensaje").html('Enviando Datos......');
      },
      success: function(datos) {
        $("#modalMensaje").modal('show');
        $("#mensaje").html(datos);
      }
    });
    event.preventDefault();
  });
</script>