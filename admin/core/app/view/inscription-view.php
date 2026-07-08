

<head>

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>

<?php







$periods = PeriodData::getAllActive();







?>



<div class="row">



  <div class="col-md-12">



    <h1>Inscribir Alumno</h1>



    <br>



    <?php if (count($periods) == 0) : ?>



      <p class="alert alert-danger">No hay un periodo iniciado, debes <a href="./?view=periods&opt=all">ir a periodos</a> y dar click en iniciar periodo.</p>



    <?php endif; ?>



    <form class="form-horizontal" method="post" id="addcategory" action="index.php?action=addinscription" role="form">







      <div class="form-group">



        <label for="inputEmail1" class="col-lg-2 control-label">Periodo*</label>



        <div class="col-md-6">



          <select class="select2 selectpicker form-control" name="period_id" required>



            <option value="">-- SELECCIONE --</option>



            <?php foreach ($periods as $al) : ?>



              <option value="<?php echo $al->id; ?>"><?php echo $al->name; ?></option>



            <?php endforeach; ?>



          </select>



        </div>



      </div>







      <div class="form-group">



        <label for="inputEmail1" class="col-lg-2 control-label">Alumno*</label>



        <div class="col-md-6">



          <select class="select2 js-example-basic-multiple form-control" name="alumn_id[]" id="select" data-live-search="true"  required multiple="multiple">



            <option value="">-- SELECCIONE --</option>



            <?php foreach (PersonData::getAlumns() as $al) : ?>



              <option value="<?php echo $al->id; ?>"><?php echo $al->code . " - " . $al->name . " " . $al->lastname; ?></option>



            <?php endforeach; ?>



          </select>



        </div>



      </div>







      <div class="form-group">



        <label for="inputEmail1" class="col-lg-2 control-label">Grupo*</label>



        <div class="col-md-6">



          <select class="select2 selectpicker form-control" name="team_id" id="team_id" data-live-search="true" required>



            <option value="" selected>-- SELECCIONE --</option>



            <?php foreach (TeamData::getAll() as $al) : ?>



              <option value="<?php echo $al->id; ?>"><?php echo $al->grade . " - " . $al->letter; ?></option>



            <?php endforeach; ?>



          </select>







        </div>



      </div>







      <div class="form-group">



        <div class="col-lg-offset-2 col-lg-10">



          <button type="submit" class="btn btn-success">Inscribir Alumno</button>
          <a href="javascript:history.back()" onclick="alertaCancelar()" class="btn btn-primary">Cancelar</a>
          <script>
            function alertaCancelar(){
              alert("La inscripción fue cancelada.")
            }
          </script>

        </div>



      </div>



    </form>



  </div>



</div>



<script>

  $(document).ready(function() {

    $('.selectpicker').select2();

    $('#team_id').select2();

    $('.js-example-basic-multiple').select2();

  });

</script>



<style>

.select2-container  {

  max-width: 100%;

  min-width: 100%;

}

</style>