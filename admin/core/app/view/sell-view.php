<?php if(isset($_GET["opt"]) && $_GET["opt"]=="alumn"):?>
  <div class="row">
  <div class="col-md-12">
  <h1>Nueva Venta</h1>
  <br>
    <form class="form-horizontal" method="post" id="addcategory" action="./?action=sell&opt=add" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Alumno*</label>
    <div class="col-md-6">
    <select name="alumn_id" class="form-control" required>
    <option value="">-- SELECCIONE --</option>
      <?php foreach(PersonData::getAlumns() as $al):?>
    <option value="<?php echo $al->id;?>"><?php echo $al->code." - ".$al->name." ".$al->lastname; ?></option>
      <?php endforeach;?>
    </select>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Concepto*</label>
    <div class="col-md-6">
    <select name="concept_id" class="form-control" required>
    <option value="">-- SELECCIONE --</option>
      <?php foreach(ConceptData::getAll() as $al):?>
    <option value="<?php echo $al->id;?>"><?php echo $al->name." ($".$al->price.")"; ?></option>
      <?php endforeach;?>
    </select>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Estado*</label>
    <div class="col-md-6">
    <select name="status" class="form-control" required>
    <option value="">-- SELECCIONE --</option>
    <option value="1">Pagado</option>
    <option value="0">Pendiente</option>
    </select>
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-primary">Nueva Venta</button>
    </div>
  </div>
</form>
  </div>
</div>
<?php endif; ?>