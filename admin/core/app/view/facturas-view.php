<?php
/* Connect To Database*/
require_once("./config/db.php");
require_once("./config/conexion.php");
require_once("./libraries/inventory.php"); //Contiene funcion que controla stock en el inventario
//Inicia Control de Permisos

//Finaliza Control de Permisos
// $customer_id=intval($_REQUEST['customer_id']);
$tables = "factura,customers";
$campos = "*";
if (empty($customer_id)) {
    $sWhere = "factura.rfc_cli=customers.rfc";
} else {
    $sWhere = "(factura.rfc_cli = '" . $customer_id . "' and customers.rfc = '" . $customer_id . "' )";
}
include './core/app/pagination.php'; //include pagination file

$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
$per_page = 15; //how much records you want to show
$adjacents = 4; //gap between pages after number of adjacents
$offset = ($page - 1) * $per_page;
//Count the total number of row in your table*/
$count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $tables where $sWhere ");
if ($row = mysqli_fetch_array($count_query)) {
    $numrows = $row['numrows'];
} else {
    echo mysqli_error($con);
}
$total_pages = ceil($numrows / $per_page);
//main query to fetch the data
$query_sql = "SELECT $campos FROM  $tables where $sWhere order BY create_added DESC";
$query = mysqli_query($con, $query_sql);
//loop through fetched data

// $timbres = 1000;
$timbres = 0;
// $restantes = $timbres - $numrows-5;
$restantes = $timbres - $numrows;
?>
<div class="row">
    <div class="col-md-12">
       
            <div class="box-header with-border">
                <h3 class="box-title">Listado de Facturas</h3>
            </div>
            
            <a href="./?view=home" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
            <a href="./?view=payments&opt=all" class="btn btn-success"><i class="fa fa-dollar"></i> Realizar otra factura</a>
            
            <!-- /.box-header -->
            <!-- <div>
                <label for="timbrados">Timbrados Restantes:</label>
                <input type="text" id="timbrados" name="timbrados" value=" <?php echo $restantes  ?>" disabled>
            </div> -->
                        
            <!-- Codigo Nuevo Arturo -->
            <div class="box-header with-border">
                <h3 class="box-title">Timbrados Restantes: <?php echo $restantes  ?></h3>
            </div>
            

				<div class="box box-primary">
					<div class="box-body">
						<table class="table table-bordered datatable table-hover">

                        <thead>
								<th class='text-center'>Folio de Factura</th>
								<th style="background: #B3B3B3; color: #545454;">Estudiante</th>
								<th style="background: #0C5585; color: #FFFFFF;">RFC</th>
								<th style="background: #0C5585; color: #FFFFFF;">Receptor</th>
								<th style="background: #E5CC11; color: #646464;">Concepto</th>
								<th>Fecha y Hora</th>
								<th>Control</th>
							</thead>
            <!-- Hasta aquí -->
            
            <!-- Codigo Original 
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-hover table-striped ">
                        <tr>
                            <th> Timbrados Restantes: </th>
                            <th> <?php echo $restantes  ?></th>
                        </tr>
                        <tr>
                            <th class='text-center'>Folio de Factura</th>
                            <th style="background: #B3B3B3; color: #545454;">Estudiante</th>
                            <th style="background: #0C5585; color: #FFFFFF;">RFC</th>
                            <th style="background: #0C5585; color: #FFFFFF;">Receptor</th>
                            <th style="background: #E5CC11; color: #646464;">Concepto</th>
                         
                            <th>Fecha y Hora</th>
                            <th>Control</th>
                        </tr>
             Hasta aquí -->
            
                        <?php
                        if ($numrows > 0) {
                            $finales = 0;
                            while ($row = mysqli_fetch_array($query)) {
                                $t_id = $row['ticket_id'];
                                $date_added = $row['created_at'];
                                $folio = $row['folio'];
                                list($date, $hora) = explode(" ", $date_added);
                                list($Y, $m, $d) = explode("-", $date);
                                $fecha = $d . "-" . $m . "-" . $Y;
                                $sql_tik = mysqli_query($con, "SELECT sale_number from sales where sale_id='" . $t_id . "'");
                                $rw_tik = mysqli_fetch_array($sql_tik);
                                $number_tik = $rw_tik['sale_number'];

                                $sql_tik1 = mysqli_query($con, "SELECT product_id from sale_product where sale_id='" . $folio . "'");
                                $rw_tik1 = mysqli_fetch_array($sql_tik1);
                                $product_id = $rw_tik1['product_id'];

                                $prod = mysqli_query($con, "SELECT * from products where product_id='" . $product_id . "'");
                                $rw_pr = mysqli_fetch_array($prod);
                                $product_name = $rw_pr['product_name'];
                                $product_note = $rw_pr['note'];
                                
                                $customer_rfc = $row['rfc_cli'];
                                $sql_customer = mysqli_query($con, "SELECT name from customers where rfc='" . $customer_rfc . "'");
                                $rw_customer = mysqli_fetch_array($sql_customer);
                                $customer_name = $rw_customer['name'];
                                
                                //Informacion del alumno 
                                $sql_alumn = mysqli_query($con, "SELECT * FROM pagos where order_id=$folio"); 
                                $rw_alm = mysqli_fetch_array($sql_alumn);
                                $idPerson = $rw_alm['idPerson'];
                                $sql_alumn1 = mysqli_query($con, "SELECT * FROM person WHERE id=$idPerson"); 
                                $rw_alm1 = mysqli_fetch_array($sql_alumn1);
                                $codealum = $rw_alm1['code'];
                                $nalum = $rw_alm1['name'];
                                $aalum = $rw_alm1['lastname'];
                                                                
                                // $date_added=$row['sale_date'];
                                // $user_fullname=$row['fullname'];
                                // $subtotal=$row['subtotal'];
                                // $tax=$row['tax'];
                                // $total=$row['total'];
                                // list($date,$hora)=explode(" ",$date_added);
                                // list($Y,$m,$d)=explode("-",$date);
                                // $fecha=$d."-".$m."-".$Y;						
                                // $finales++;							
                                // if ($typeDocument==1) {
                                // 	$typeDocumentName="Factura";
                                // }else{
                                // 	$typeDocumentName="Ticket";
                                // }
                                // if ($paymentMethod==1) {
                                // 	$paymentMethodName = "Efectivo";
                                // }else if($paymentMethod==2){
                                // 	$paymentMethodName = "Cheque";
                                // }else{
                                // 	$paymentMethodName = "Tarjeta";
                                // }
                                ?>
                                <tr>
                                    <td class='text-center'>
                                        <?php echo $folio; ?>
                                    </td>
                                    <td>
                                         <!--Estudiante al que se le aplicó la Factura (Matrícula y Nombre )-->
                                        <?php echo  $codealum . " - " . $aalum ." ". $nalum  ?>
                                    </td>
                                    <td>
                                        <?php echo $customer_rfc; ?>
                                        
                                    </td>
                                    <td>
                                        <?php echo $customer_name; ?>
                                    </td>
                                    <td>
                                        <!--Concepto-->
                                        <strong><?php echo $product_name  ?></strong><br>
                                        <small><?php echo  $product_note  ?></small>
                                    </td>

                                    <td>
                                        <?php echo $fecha . "<br>" . $hora; ?>
                                    </td>
                                    <!-- <td class="col-md-2"> -->
                                        <td>
                                        <a href="#" data-toggle="modal" data-target="#modal_visualizar" title="Ver factura PDF"
                                            onclick="fact(<?php echo $folio; ?>)"><button type="button" class="btn bg-orange"><i
                                                    class="fa fa-eye"></i></button></a>
                                        <a href="#" onclick="downloadFile('<?php echo $folio; ?>', '<?php echo $customer_rfc; ?>')">
                                                <button type="button" class="btn bg-blue"><i class="fa fa-download"></i></button>
                                        </a>
                                        <a href="#" data-toggle="modal" data-target="#modal_consulta_Sat"
                                            title="Consultar estado factura" onclick="consultar(<?php echo $folio; ?>)"><button
                                                type="button" class="btn bg-green" style="border-left:none"><i
                                                    class="fa fa-search"></i></button></a>
                                        <a href="#" data-toggle="modal" data-target="#modal_consulta_Sat"
                                            title="Solicitar cancelación factura"
                                            onclick="cancelar(<?php echo $folio; ?>)"><button type="button"
                                                class="btn bg-red"><i class="fa fa-times"></i></button></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                        
                    </div>
                </div> <!--box-body .box-primary-->
                
                
                
                
                
                
      
        </div><!-- /.col -->
    </div><!-- /.row -->
    <?php
                        }

                        ?>
<script>
    function checkKeyCode(evt) {
        var evt = (evt) ? evt : ((event) ? event : null);
        var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
        if (event.keyCode == 116) {
            evt.keyCode = 0;
            return false
        }
    }
    function fact(id) {
        VentanaCentrada(
            "./tim/factura_pdftim.php?ticket_id=" + id,
            "",
            "1024",
            "768",
            "true"
        )
    }

    function downloadFile(folio, rfc) {
    // Aquí puedes construir la URL de descarga usando PHP para generar la ruta del archivo
    var archivo = "./storage/factura/" + folio + ".xml"; // Reemplaza con la ruta y el nombre correcto del archivo

    // Crear un enlace temporal
    var link = document.createElement('a');
    link.href = archivo;
    link.download = rfc + "_"+ folio +'.xml'; // El nombre con el que se descargará el archivo

    // Añadir el enlace al cuerpo del documento
    document.body.appendChild(link);

    // Simular clic en el enlace para iniciar la descarga
    link.click();

    // Eliminar el enlace del documento después de la descarga
    document.body.removeChild(link);
}

    function consultar(id) {
        //https://craftpip.github.io/jquery-confirm/ documentacion
        var parametros = {
            id: id
        };
        $.ajax({
            dataType: 'json',
            type: "GET",
            url: "./tim/consultar_SAT.php",
            data: parametros,
            beforeSend: function (objeto) {
                //$("#loader").html("<img src='./img/ajax-loader.gif'>");
            },
            success: function (data) {
                var parametros = {
                    Emisor: data.Emisor,
                    Receptor: data.Receptor,
                    Total: data.Total,
                    UUID: data.UUID,
                    opc: 9
                };
                $.ajax({
                    type: "GET",
                    url: "./tim/test4.php",
                    data: parametros,
                    beforeSend: function (data) {
                        /* console.log(parametros);
                        console.log(data); */
                        $("#subtitulo_factura").html('Solicitud de consulta');
                        $(".datos_consulta").html("<center><h3>Cargando...</h3></center>");
                    },
                    success: function (response) {
                        $(".datos_consulta").html("RFC Emisor: " + parametros["Emisor"] + "<br>");
                        $(".datos_consulta").append("RFC receptor: " + parametros["Receptor"] + "<br>");
                        $(".datos_consulta").append("Total compra: " + parametros["Total"] + "<br>");
                        $(".datos_consulta").append("UUID compra: " + parametros["UUID"] + "<br>");
                        $(".datos_consulta").append("<hr>");
                        $(".datos_consulta").append("Nombre operación: <strong>" + response.operacion + "</strong>");
                        $(".datos_consulta").append("<hr>");
                        $(".datos_consulta").append("Codigo del SAT: <strong>" + (response["Codigo del SAT"] === "" ? "No definido" : response["Codigo del SAT"]) + "</strong>");
                        $(".datos_consulta").append("<hr>");
                        $(".datos_consulta").append("Tipo de Cancelación: <strong>" + (response["Tipo de Cancelación"] === "" ? "No definido" : response["Tipo de Cancelación"]) + "</strong>");
                        $(".datos_consulta").append("<hr>");
                        $(".datos_consulta").append("Estado: <strong>" + (response["Estado"] === "" ? "No definido" : response["Estado"]));
                        $(".datos_consulta").append("<hr>");
                        $(".datos_consulta").append("Solicitud de cancelacion: <strong>" + (response["Solicitud de cancelacion"] === "" ? "No definido" : response["Solicitud de cancelacion"]) + "</strong>");
                        $(".datos_consulta").append("<hr>");
                    },
                    error: function (result_facturacion) {
                        console.log(result_facturacion);
                        $(".datos_consulta").html('Se ha obtenido el siguiente error de timbrado:' + JSON.stringify(result_facturacion) + '<br>Se ha enviado la siguiente información: ' + parametros);
                    },
                });
            },
            error: function (ee) {
                console.log(ee);
            }
        });
    }

    function cancelar(id) {
    var parametros_cancelar = { // Renombrar la variable
        id: id
    };
    $.ajax({
        dataType: 'json',
        type: "GET",
        url: "tim/consultar_SAT.php",
        data: parametros_cancelar, // Usar la variable renombrada
        success: function (data) {
            
            var parametros = {
                
                opc: 10,
                Id: id,
                Emisor: data.Emisor,
                Receptor: data.Receptor,
                Total: data.Total,
                UUID: data.UUID
            };
           
            $.ajax({
                type: "GET",
                url: "./tim/test4.php",
                data: parametros,
                beforeSend: function (data) {
                    //$(".datos_consulta").modal("show");
                    $("#subtitulo_factura").html('Solicitud de cancelación');
                    $(".datos_consulta").html("<center><h3>Cargando...</h3></center>");
                },
                success: function (response) {
                    console.log(response);
                    // Obtener el texto del acuse
                    var acuseText = response["acuse"];
                    
                    // Dividir el texto en líneas cada cierta longitud (por ejemplo, 80 caracteres)
                    var maxLength = 50;
                    var acuseLines = [];
                    for (var i = 0; i < acuseText.length; i += maxLength) {
                        acuseLines.push(acuseText.substr(i, maxLength));
                    }
                    var formattedAcuse = acuseLines.join("<br>");
                    $(".datos_consulta").html("RFC Emisor: " + parametros["Emisor"] + "<br>");
                    $(".datos_consulta").append("RFC receptor: " + parametros["Receptor"] + "<br>");
                    $(".datos_consulta").append("Total compra: " + parametros["Total"] + "<br>");
                    $(".datos_consulta").append("UUID compra: " + parametros["UUID"] + "<br>");
                    $(".datos_consulta").append("Motivo: " + response["motivo"] + "<br>");
                    $(".datos_consulta").append("<hr>");
                    $(".datos_consulta").append("Nombre operación: <strong>" + response.operacion + "</strong>");
                    $(".datos_consulta").append("<hr>");
                    $(".datos_consulta").append("Codigo del SAT: <strong>" + (response["codigo"] === "" ? "No definido" : response["codigo"]) + "</strong>");
                    $(".datos_consulta").append("<hr>");
                    $(".datos_consulta").append("Tipo de Cancelación: <strong>" + (response["mensaje"] === "" ? "No definido" : response["mensaje"]) + "</strong>");
                    $(".datos_consulta").append("<hr>");
                    // $(".datos_consulta").append("Estado: <strong>" + (response["acuse"] === "" ? "No definido" : response["acuse"])+ "</strong>");
                    // $(".datos_consulta").append("<hr>");
                    $(".datos_consulta").append("Estado: <strong>" + (formattedAcuse === "" ? "No definido" : formattedAcuse) + "</strong><br>");
                    $(".datos_consulta").append("<hr>");
                    $(".datos_consulta").append("Solicitud de cancelacion: <strong>" + (response["resultado"] === "" ? "No definido" : response["resultado"]) + "</strong>");
                    $(".datos_consulta").append("<hr>");
                    $(".datos_consulta").append("Data obtenida: <strong>" + (response["data"] === "" ? "No definido" : response["data"]) + "</strong>");
                    $(".datos_consulta").append("<hr>");
                },
                error: function (result_facturacion) {
                    console.log(result_facturacion);
                    console.log("Error de timbrado:");
                    console.log(result_facturacion.responseText);
                    $(".datos_consulta").html('Se ha obtenido el siguiente error de timbrado:' + JSON.stringify(result_facturacion) + '<br>Se ha enviado la siguiente información: ' + parametros);
                },
            });
        },
        error: function (ee) {
            console.log(ee);
        }
    });
}

    function VentanaCentrada(theURL, winName, features, myWidth, myHeight, isCenter) { //v3.0
        if (window.screen) if (isCenter) if (isCenter == "true") {
            var myLeft = (screen.width - myWidth) / 2;
            var myTop = (screen.height - myHeight) / 2;
            features += (features != '') ? ',' : '';
            features += ',left=' + myLeft + ',top=' + myTop;
        }
        window.open(theURL, winName, features + ((features != '') ? ',' : '') + 'width=' + myWidth + ',height=' + myHeight);

    };
</script>

<html>
<form class="form-horizontal" method="post" id="new_register" name="new_register">
    <!-- Modal -->
    <div class="modal fade" id="modal_consulta_Sat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Estado de Factura</h4>
                    <p id="subtitulo_factura"></p>
                </div>
                <div class="modal-body">
                    <div class="nav-tabs-custom ">
                        <div class="tab-content ">
                            <div class="datos_consulta" id="datos_consulta">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</form>

</html>