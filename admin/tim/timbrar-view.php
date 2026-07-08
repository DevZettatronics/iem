<?php
/* Connect To Database*/
//tmpfac=7
//ticket=7
require_once("./config/db.php");
require_once("./config/conexion.php");
//Inicia Control de Permisos
$id_t = $_GET['ticket'];
$id_sale = mysqli_fetch_array(mysqli_query($con, "SELECT order_id FROM pagos where id = '$id_t'"));
$id_sale = $id_sale['order_id'];
$id_sale = mysqli_fetch_array(mysqli_query($con, "SELECT sale_id FROM sales where sale_number = '$id_sale'"));
$id_sale = $id_sale['sale_id'];
$tmp = $_GET['tmpfac'];
//Finaliza Control de Permisos
?>
<script src="https://code.jquery.com/jquery-latest.js"></script>
<script>
    window.location.hash = "no-back-button";
    window.location.hash = "Again-No-back-button"; //esta linea es necesaria para chrome
    window.onhashchange = function () {
        window.location.hash = "no-back-button";
    }
</script>
<section class="content-header">
    <h1><i class='fa fa-edit'></i> Generar Timbrado</h1>
    <h2>No. ticket a facturar:
        <?php echo $id_t?>
    </h2>
</section>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
            </div><!-- /.box-header -->
            <div class="box-body">
                <div id="resultados_ajax"></div>
                <div id="resultados_ajax2"></div>
                <div id="resultados_ajax3"></div>
                <div class="row">
                    <div class="col-md-6" style="height:80px;text-align:center;">
                        <div class="btn-group pull-center">
                            <a href="#" onclick="pdf('<?php echo $id_sale ?>')" title="Ver_factura"><button type="button" class="btn bg-blue ">Ver Pre-Factura</button></a>
                        </div><!-- /btn-group -->
                        <div class="btn-group pull-center">
                            <button type="submit" id="timbrar_datos" class="btn btn-success" onclick="op(7,<?php echo $id_t; ?>);">Timbrar</button>
                        </div>
                        <div class="btn-group pull-center">
                            <button type="submit" id="cancelar_datos" class="btn btn-danger" onclick="cancelar('<?php echo $id_t; ?>');">Cancelar</button>
                        </div>
                    </div>
                </div><!-- row -->
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
<script>
    function pdf(id) {
        VentanaCentrada(
            "./pdf/factura_pdf.php?ticket_id=" + id,
            "",
            "1024",
            "768",
            "true"
        )
    }
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

<script>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
</script>

<script>
    function op(opc, tmp) {
        var parametros = { opc: opc, tmp: tmp };
        $.ajax({
            type: "GET",
            url: "./tim/test4.php",
            data: parametros,
            //dataType: "json", This cant be json, cause on default switch option it defines ECHO but JSON data-type return
            beforeSend: function (objeto) {
                /* $("#resultados_ajax").html("<img src='./img/ajax-loader.gif'>"); */
            },
            success: function (data) {
                $("#resultados_ajax").html(data);
                $("#loader").html("");
                // alert(data.mensaje);
                if (data.codigo != 200) {
                    $("#resultados_ajax").html('Se ha obtenido el siguiente error:' + "<br> <strong>Operación: </strong>" + data.operacion + "<br><strong>Código: </strong>" + data.codigo + "<br><strong>Mensaje: </strong>" + data.mensaje + "<br><strong>Datos: </strong>" + data.datos);
                    console.log(data)
                    //window.setTimeout(window.location.reload(), 1000); Wont reload page
                } else {
                    /* Mensaje de respuesta */
                    $("#resultados_ajax").html('Exito, se ha obtenido el siguiente mensaje:' + "<br> <strong>Operación: </strong>" + data.operacion + "<br><strong>Código: </strong>" + data.codigo + "<br><strong>Mensaje: </strong>" + data.mensaje + "<br><br>");
                    /* console.log(data) */
                    $("#timbrar_datos").addClass("hidden");
                    $("#cancelar_datos").addClass("hidden");
                    var dato = JSON.parse(data.datos);
                    //console.log(dato); //muestra los datos ya separados del json que nos envian
                    var parametros = { tmp: tmp, codigo: data.codigo };
                    $.ajax({
                        type: "POST",
                        url: "./tim/crearFacturas.php",
                        // data: parametros,
                        data: parametros,
                        beforeSend: function (objeto) {
                            
                        },
                        success: function (response) {
                            $("#resultados_ajax3").html(response);
                            // alert(data.mensaje);
                            window.setTimeout(window.location.replace("./?view=facturas&opt=all"), 4000);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $("#resultados_ajax3").html("Error en la solicitud AJAX:");
                            $("#resultados_ajax3").append("<br>Status: " + textStatus);
                            $("#resultados_ajax3").append("<br>Error: " + JSON.stringify(errorThrown));
                            $("#resultados_ajax3").append("<br>" + JSON.stringify(jqXHR));
                            console.log("Error en la solicitud AJAX:");
                            console.log("\nStatus: " + textStatus);
                            console.log("\nError: " + errorThrown);
                            console.log("\n" + jqXHR);
                        },
                    })
                };
            },
            error: function (result) {
                $("#resultados_ajax2").html('Se ha obtenido el siguiente error de ejecución:' + JSON.stringify(result) + '<br><br> Se ha enviado la siguiente información: ' + JSON.stringify(parametros))
                console.log(result)
            },
        });
    }
</script>