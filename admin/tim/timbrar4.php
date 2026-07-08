<?php
session_start();
/* Connect To Database*/
//tmpfac=7
//ticket=7
require_once("../config/db.php");
require_once("../config/conexion.php");
//Inicia Control de Permisos
include("../config/permisos.php");
$id_t = $_GET['ticket'];
$tmp = $_GET['tmpfac'];

//Finaliza Control de Permisos
?>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
    window.location.hash = "no-back-button";
    window.location.hash = "Again-No-back-button"; //esta linea es necesaria para chrome
    window.onhashchange = function () {
        window.location.hash = "no-back-button";
    }
</script>
<section class="content-header">
    <h1><i class='fa fa-edit'></i> Generar Timbrado</h1>
    <h2>No. ticket a facturar: <?php echo $id_t ?></h2>
</section>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6" style="height:80px;text-align:center;">
                        <div class="btn-group pull-center">
                            <a href="#" onclick="pdf('<?php echo $id_t ?>')" title="Ver_factura"><button type="button"
                                    class="btn bg-blue ">Ver Documento</button></a>
                        </div><!-- /btn-group -->
                        <div class="btn-group pull-center">
                            <button type="submit" id="timbrar_datos" class="btn btn-success"
                                onclick="op(7,<?php echo $tmp; ?>);">Timbrar</button>
                        </div>
                        <div class="btn-group pull-center">
                            <button type="submit" id="cancelar_datos" class="btn btn-danger"
                                onclick="cancelar('<?php echo $id_t; ?>');">Cancelar</button>
                        </div>
                    </div>
                </div><!-- row -->
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
<script>

    // EVITA USAR EL F5 PARA ACTULIZAR 
    function checkKeyCode(evt) {
        var evt = (evt) ? evt : ((event) ? event : null);
        var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
        if (event.keyCode == 116) {
            evt.keyCode = 0;
            return false
        }
    }
    document.onkeydown = checkKeyCode;
</script>