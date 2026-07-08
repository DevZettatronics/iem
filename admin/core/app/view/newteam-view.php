<div class="row">

  <div class="col-md-12">

    <h1>Nuevo Grupo</h1>

    <br>

    <form class="form-horizontal" method="post" id="addcategory" action="index.php?view=addteam" role="form">

      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Programa*</label>
        <div class="col-md-3">
          <select name="programa" id="programa" data-live-search="true" class="form-control select" required>
            <option value="">-- SELECCIONE --</option>
            <?php foreach (EducationalProgramData::getAll() as $al): ?>
              <option value="<?php echo $al->id; ?>"><?php echo $al->name; ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-3" hidden>
          <select name="name" id="name" class="form-control select">
            <option value=""></option>
          </select>
        </div>
        <label for="inputEmail1" class="col-lg-2 control-label no-arrow">Tipo de modalidad*</label>
        <div class="col-md-3">
          <select name="ti" id="ti" class="form-control select">
            <option value=""></option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label no-arrow">Nivel*</label>
        <div class="col-md-3">
          <select name="li" id="li" class="form-control select">
            <option value=""></option>
          </select>
        </div>
        
        <label for="inputEmail1" class="col-lg-2 control-label no-arrow">Modalidad del grupo*</label>
        <div class="col-md-3">
          <select name="modalidadBD" id="modalidadBD" class="form-control select">
            <option value="0">Selecciona una modalidad</option>
            <?php foreach (EducationalProgramData::getAllTeam() as $al): ?>
              <option value="<?php echo $al->id_modalidad; ?>"><?php echo $al->nombre; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Grupo*</label>
        <div class="col-md-3">
          <input type="text" name="letter" required class="form-control" id="letter" placeholder="SIGLAS-###">
        </div>

        <label for="inputEmail1" class="col-lg-2 control-label">Historial al que sera asignado*</label>
        <div class="col-md-3">
          <select class="form-control" name="historial_asg" id="historial_asg" required>
            <option value="">Seleccione</option>
            <?php
            $con = Database::getCon();
            $sql1 = "SELECT * FROM historiales_categoria";
            $query1 = mysqli_query($con, $sql1);
            while ($row1 = mysqli_fetch_array($query1)) {
              ?>
              <option value="<?php echo $row1['id_identificador']; ?>"><?php echo $row1['name']; ?></option>
              <?php
            }
            ?>
          </select>
        </div>
      </div>

      <label class="col-lg-2 control-label">Activación de Cuatrimestre</label>
      <div class="col-sm-6">
        <div class="box box-success">
          <div class="box-body">
            <div class="table-responsive ">
              <table class="table table-condensed table-hover table-striped">
                <th class='text-center'>Cuatrimestre </th>
                <th class='text-center'>Seleccione</th>
                <tr>
                  <td>Primero</td>
                  <td class='text-center'><input type="radio" name="ck" value="1" checked></td>
                </tr>
                <tr>
                  <td>Segundo</td>
                  <td class='text-center'><input type="radio" name="ck" value="2"></td>
                </tr>
                <tr>
                  <td>Tercero</td>
                  <td class='text-center'><input type="radio" name="ck" value="3"></td>
                </tr>
                <tr>
                  <td>Cuarto</td>
                  <td class='text-center'><input type="radio" name="ck" value="4"></td>
                </tr>
                <tr>
                  <td>Quinto</td>
                  <td class='text-center'><input type="radio" name="ck" value="5"></td>
                </tr>
                <tr>
                  <td>Sexto</td>
                  <td class='text-center'><input type="radio" name="ck" value="6"></td>
                </tr>
                <tr>
                  <td>Septimo</td>
                  <td class='text-center'><input type="radio" name="ck" value="7"></td>
                </tr>
                <tr>
                  <td>Octavo</td>
                  <td class='text-center'><input type="radio" name="ck" value="8"></td>
                </tr>
                <tr>
                  <td>Noveno</td>
                  <td class='text-center'><input type="radio" name="ck" value="9"></td>
                </tr>
                <tr>
                  <td>Decimo</td>
                  <td class='text-center'><input type="radio" name="ck" value="10"></td>
                </tr>
                <tr>
                  <td>Onceavo</td>
                  <td class='text-center'><input type="radio" name="ck" value="11"></td>
                </tr>
                <tr>
                  <td>Doceavo</td>
                  <td class='text-center'><input type="radio" name="ck" value="12"></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
          <button type="submit" class="btn btn-primary">Agregar Grupo</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  // $(document).ready(function() {
  //   $('#programa').on('change', function() {
  //     if ($('#programa').val() == "") {
  //       $('#nca').empty();
  //       $('<option value = "">Nomenclatura</option>').appendTo('#nca');
  //       $('#nca').attr('disabled', 'disabled');
  //     } else {
  //       $('#nca').removeAttr('disabled', 'disabled');
  //       $('#nca').load('core/app/action/listar_programas.php?programa=' + $('#programa').val());
  //     }
  //   });
  // });
  // // para que no se abra el select
  // $('#nca').on('mousedown', function(e) {
  //   e.preventDefault();
  //   this.blur();
  //   window.focus();
  // });


  $(document).ready(function () {
    $('#programa').on('change', function () {
      if ($('#programa').val() == "") {
        $('#li').empty();
        $('<option value = "">Nivel</option>').appendTo('#li');
        $('#li').attr('disabled', 'disabled');
      } else {
        $('#li').removeAttr('disabled', 'disabled');
        $('#li').load('core/app/action/listar_licenciatura.php?programa=' + $('#programa').val());
      }
    });
  });
  // para que no se abra el select
  $('#li').on('mousedown', function (e) {
    e.preventDefault();
    this.blur();
    window.focus();
  });

  $(document).ready(function () {
    $('#programa').on('change', function () {
      if ($('#programa').val() == "") {
        $('#ti').empty();
        $('<option value = "">Tipo</option>').appendTo('#ti');
        $('#ti').attr('disabled', 'disabled');
      } else {
        $('#ti').removeAttr('disabled', 'disabled');
        $('#ti').load('core/app/action/listar_tipo.php?programa=' + $('#programa').val());
      }
    });
  });
  // para que no se abra el select
  $('#ti').on('mousedown', function (e) {
    e.preventDefault();
    this.blur();
    window.focus();
  });

  $(document).ready(function () {
    $('#programa').on('change', function () {
      if ($('#programa').val() == "") {
        $('#name').empty();
        $('<option value = "">Tipo</option>').appendTo('#name');
        $('#name').attr('disabled', 'disabled');
      } else {
        $('#name').removeAttr('disabled', 'disabled');
        $('#name').load('core/app/action/listar_nombreP.php?programa=' + $('#programa').val());
      }
    });
  });
  // para que no se abra el select
  $('#name').on('mousedown', function (e) {
    e.preventDefault();
    this.blur();
    window.focus();
  });
</script>
<script>
  // $('.select').selectpicker();
  $('[id="programa"]').selectpicker();
</script>