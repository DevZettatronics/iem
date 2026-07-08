<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>


<?php

include("../../../config/db.php");
include("../../../config/conexion.php");



//$user_id=$_SESSION['id'];

//Variables por GET
	$atencion=$_GET['atencion'];
	$tel1=$_GET['tel1'];
	$empresa=$_GET['empresa'];
	$tel2=$_GET['tel2'];
	$email=$_GET['correo'];
	$condiciones=$_GET['condiciones'];
	$validez=$_GET['validez'];
	$entrega=$_GET['entrega'];

//Fin de variables por GET
$sql_cotizacion=mysqli_query($con, "SELECT LAST_INSERT_ID(numero_cotizacion) AS LAST FROM cotizaciones ORDER BY id_cotizacion desc limit 0,1 ");
$rwC=mysqli_fetch_array($sql_cotizacion);
$numero_cotizacion=$rwC['LAST']+1;

?>





<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >

	<page_footer>
        <table class="page_footer">
            <tr>

                <td style="width: 50%; text-align: left">
                    P&aacute;gina [[page_cu]]/[[page_nb]]
                </td>
                <td style="width: 50%; text-align: right">
                    &copy; <? echo "Zettatronics "; echo  $anio=date('Y'); ?>
                </td>
            </tr>
        </table>
    </page_footer>

    <table cellspacing="0" style="width: 100%;">
        <tr>

            <td style="width: 25%; color: #444444;">
                <img style="width: 100%;" src="../../../img/logo/logoRetina.png" alt="Logo"><br>
                
            </td>
			<td style="width: 75%;text-align:right">
			COTIZACION Nº <? echo $numero_cotizacion;?>
			</td>
			
        </tr>
    </table>

	<br>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
		<tr>
		<td style="width:50%; "><strong>Dirección:</strong> <br>San Nicolás 4, Albarrada,Delegacion Iztapalapa, C.P 09350,CDMX.<br> Teléfono: (55) 8790-6624 / (55) 8790-6625</td>
		
		</tr>
	</table>
	
	<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
		<tr>
			<td style="width: 89%;text-align:right">
			Fecha: <? echo date("d-m-Y");?>
			</td>
		</tr>
	</table>

	<br>

    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           
            <td style="width:15%; ">Atención:</td>
            <td style="width:50%"><strong><? echo $atencion;?></strong> </td>
			<td style="width:15%;text-align:right"> Teléfono:</td>
            <td style="width:20%">&nbsp;<strong><? echo $tel1; ?></strong></td>
        </tr>
        <tr>
            
            <td style="width:15%; ">Empresa:</td>
            <td style="width:50%"><strong><? echo $empresa; ?></strong></td>
			<td style="width:15%;text-align:right"> Teléfono:</td>
            <td style="width:20%">&nbsp;<strong> <? echo $tel2; ?></strong> </td>
        </tr>
        <tr>
            
            <td style="width:15%; ">Email:</td>
            <td style="width:50%"><strong><? echo $email; ?></strong></td>
        </tr>
   
    </table>
	<br>
	<table cellspacing="0" style="width: 100%; text-align: left;font-size: 11pt">
        <tr>
             <td style="width:100%; ">A continuación presentamos nuestra oferta que esperamos sea de su conformidad.</td>		 
        </tr>
    </table>

	<br>
	
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: center; font-size: 10pt;padding:1mm;">
        <tr>
            <th style="width: 10%">CANT.</th>
            <th style="width: 30%">ARTICULO</th>
            <th style="width: 30%">MARCA</th>            
            <th style="width: 15%">PRECIO UNIT.</th>
            <th style="width: 15%">PRECIO TOTAL</th>
            
        </tr>
    </table>

<?php
    
//$sql=mysqli_query($con, "SELECT * FROM products,product_tmp WHERE products.product_id = product_tmp.product_id AND product_tmp.user_id = '".$user_id ."' ");
    
    
$sumador_total=0;
$sql=mysqli_query($con, "SELECT * FROM products,product_tmp WHERE products.product_id = product_tmp.product_id");
while ($row=mysqli_fetch_array($sql))
{
	$id_tmp=$row["id_tmp"];//TABLA TEMPORALES
	$id_producto=$row["product_id"];//AMABAS
	$codigo_producto=$row['product_code'];//TABLA PRODUCTOS
	$cantidad=$row['qty'];//AMBAS
	$nombre_producto=$row['product_name'];//TABLA PRODUCTOS
	$marca_producto=$row['marca'];//TABLA PRODUCTOS

	$precio_venta=$row['unit_price'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador

	?>
	<table cellspacing="0" style="width: 100%; border: solid 1px black;  text-align: center; font-size: 11pt;padding:1mm;">
        <tr>
            <td style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
            <td style="width: 30%; text-align: center"><? echo $nombre_producto;?></td>
            <td style="width: 30%; text-align: center"><? echo $marca_producto;?></td>            
            <td style="width: 15%; text-align: center"><? echo $precio_venta_f;?></td>
            <td style="width: 15%; text-align: right"><? echo $precio_total_f;?></td>
            
        </tr>
    </table>
<?php   
//Insert en la tabla detalle_cotizacion
$insert_detail=mysqli_query($con, "INSERT INTO detalle_cotizacion VALUES ('','$numero_cotizacion','$id_producto','$cantidad','$precio_venta_r')");
//Insert en la tabla cotizacion
$date=date("Y-m-d H:i:s");
$insert=mysqli_query($con,"INSERT INTO cotizaciones VALUES ('','$numero_cotizacion','$date','$atencion','$tel1','$empresa','$tel2','$email','$condiciones','$validez','$entrega')");
//Borrado de productos temporales
$delete=mysqli_query($con,"DELETE FROM product_tmp");    
}
?>

	<table cellspacing="0" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: center; font-size: 11pt;padding:1mm;">
        <tr>
            <th style="width: 87%; text-align: right;">TOTAL : </th>
            <th style="width: 13%; text-align: right;">&#36; <? echo number_format($sumador_total,2);?></th>
        </tr>
    </table>
	*** Precios incluyen IVA ***	 
	<br> 

	<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
            <tr>
                <td style="width:50%;text-align:right">Condiciones de pago: </td>
                <td style="width:50%; ">&nbsp;<strong><? echo $condiciones; ?></strong></td>
            </tr>
			<tr>
                <td style="width:50%;text-align:right">Validez de la oferta: </td>
                <td style="width:50%; ">&nbsp;<strong><? echo $validez; ?></strong></td>
            </tr>
			<tr>
                <td style="width:50%;text-align:right">Tiempo de entrega: </td>
                <td style="width:50%; ">&nbsp;<strong><? echo $entrega; ?></strong></td>
            </tr>
        </table>
		<br><br><br><br>

		<table cellspacing="10" style="width: 100%; text-align: left; font-size: 11pt;">
			 <tr>
                <td style="width:33%;text-align: center;border-top:solid 1px">Vendedor</td>
               <td style="width:33%;text-align: center;border-top:solid 1px">Cotizado</td>
               <td style="width:33%;text-align: center;border-top:solid 1px">Aceptado Cliente</td>
            </tr>
        </table>
	</page>
	
<?php



?>



   