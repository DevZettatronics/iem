<style type="text/css">
<!--
div.zone
{
    border: solid 0.5mm red;
    border-radius: 2mm;
    padding: 1mm;
    background-color: #FFF;
    color: #440000;
}
div.zone_over
{
    width: 30mm;
    height: 20mm;
    
}
.bordeado
{
	border: solid 0.5mm #eee;
	border-radius: 1mm;
	padding: 0mm;
	font-size:12px;
}
.table {
  border-spacing: 0;
  border-collapse: collapse;
}
.table-bordered td, .table-bordered th {
  padding: 3px;
  text-align: left;
  vertical-align: top;
}
.table-bordered {
  border: 0px solid #eee;
  border-collapse: separate;
  
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
}
.left{
	border-left: 1px solid #eee;
	
}
.top{
	border-top:dashed 1px;
}
.bottom{
	border-bottom: dashed 1px;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
.page-header {
    margin: 10px 0 20px 0;
    font-size: 16px;
}
</style>
<?php 
	include('num_letras.php');
?>
<page backtop="0mm" backbottom="0mm" backleft="4mm" backright="4mm" style="font-size: 11px; font-family: helvetica" backimg="">
		
		<table border=0 style="width:100%;margin:5mm 0px" cellspacing=0>
			<tr>
				<td style="width:100%; text-align:center"><?php echo $bussines_name;?></td>
			</tr>
			<tr>
				<td style="width:100%; text-align:center"><?php echo $address." ".$city;?></td>
			</tr>
			
			<tr>
				<td style="width:100%; text-align:center"><?php //echo " NRC: "//.$number_id;?></td>
			</tr>
			<tr>
				<td style="width:100%; text-align:center;font-size:13pt">TICKET # <?php echo $sale_number;?></td>
			</tr>
			<tr>
				<td style="width:100%; text-align:center"><?php // echo $branch_office_name;?></td>
			</tr>
			<tr>
				<td style="width:100%; text-align:center"><?php // echo $branch_office_address;?></td>
			</tr>
		</table>
		
		<table border=0 style="width:100%;margin:5mm 0px" cellspacing=0>
			
			<tr>
				<td style="width:100%;" class='top'>FECHA: <?php echo $sale_date;?></td>
			</tr>
			<tr>
				<td style="width:100%;" class='bottom'>CLIENTE: <?php echo $customer_name;?><br></td>
			</tr>
			
		</table>
		<table border=0 style="width:100%;margin:2mm 0px;font-size:10px" cellspacing=0>
			<tr>
				<td style="width:7mm;text-align:center;" class=''>Cant.</td>
				<td style="width:10mm;text-align:left;" class=''>Cód</td>
				<td style="width:22mm;text-align:left;" class=''>Descripción</td>
				<td style="width:10mm;text-align:left;" class=''>P.U</td>
				<td style="width:10mm;text-align:center;" class=''>TOTAL</td>
			</tr>
		
		<?php
		$sumador_total=0;
		$sql=mysqli_query($con, "SELECT * FROM products, sale_product WHERE products.product_id=sale_product.product_id AND sale_product.sale_id='$sale_id'");
		while ($row=mysqli_fetch_array($sql)){
			$product_code=$row['product_code'];
			$qty=$row['qty'];
			$product_name=$row['product_name'];
			$unit_price=number_format($row['unit_price'],$currency_format['precision_currency'],'.','');
			$precio_total=$unit_price*$qty;
			$precio_total=number_format($precio_total,$currency_format['precision_currency'],'.','');//Precio total formateado
			$sumador_total+=$precio_total;//Sumador
			
			?>
			<tr>
				<td style="width:7mm;text-align:center; font-size:85%;" ><?php  echo $qty;?></td>
				<td style="width:10mm;text-align:left; font-size:80%;"><?php  echo wordwrap($product_code, 6, " ", TRUE);?></td><!-- campo que solo se vea en una columna -->
				<td style="width:22mm;text-align:left; font-size:80%;"><?php echo wordwrap($product_name, 10, " ", TRUE);?></td>
				<td style="width:10mm;text-align:left; font-size:85%;" ><?php echo number_format($unit_price,$currency_format['precision_currency'],$currency_format['decimal_separator'],$currency_format['thousand_separator']);?></td>
				<td style="width:10mm;text-align:center; font-size:85%;"><?php echo number_format($precio_total,$currency_format['precision_currency'],$currency_format['decimal_separator'],$currency_format['thousand_separator']);?></td>
            </tr>	
			<?php
		}
				$total_parcial=number_format($sumador_total,$currency_format['precision_currency'],'.','');
				$total_neto=$total_parcial;
				$total_neto=number_format($total_neto,$currency_format['precision_currency'],'.','');
				$total_iva=($total_neto*$tax) / 100;
				$total_iva=number_format($total_iva,$currency_format['precision_currency'],'.','');
				$total_compra=$total_neto+$total_iva;
				$total_compra=number_format($total_compra,$currency_format['precision_currency'],'.','');
				$precio_descuento =($total_neto*$descuento)/100;
				if($descuento >0) {
					$precio_descuento =($total_neto*$descuento)/100;
					$total_descuento = ($total_neto-$precio_descuento);
					$total_iva = ($total_descuento*$tax)/100;
					$total_compra =($total_descuento+$total_iva);
				}else{

					$total_iva=($total_neto*$tax) / 100;
					$total_iva=number_format($total_iva,$currency_format['precision_currency'],'.','');
					$total_compra=$total_neto+$total_iva;
					$total_compra=number_format($total_compra,$currency_format['precision_currency'],'.','');
				}
		?>
		<!--
		<tr>
			<td colspan="4" class='top'></td>
		</tr>
		<tr>
			<td style='text-align:right' colspan="3" ><b>VALOR VENTA < ?php echo $simbolo_moneda;?></b> </td>
			<td style='text-align:right' ><b>< ?php echo number_format($total_neto,$precision_moneda,$sepador_decimal_moneda,$sepador_millar_moneda);?></b> </td>
		</tr>
		<tr>
			<td style='text-align:right' colspan="3" ><b>IGV < ?php echo $simbolo_moneda;?></b></td>
			<td style='text-align:right' ><b> < ?php echo number_format($total_iva,$precision_moneda,$sepador_decimal_moneda,$sepador_millar_moneda);?></b></td>
		</tr>
		!-->
		<tr>
			<tr></tr>
			<td style='text-align:right' class='' colspan="4" >Subtotal <?php echo $moneda;?></td>
			<td style='text-align:right' class=''><?php echo number_format($total_neto,$currency_format['precision_currency'],$currency_format['decimal_separator'],$currency_format['thousand_separator']);?></td>
			
		</tr>
		<?php 
			if ($descuento>0){
		?>
		<tr>
			<td style='text-align:right' class='' colspan="4" >Descuento <?php echo $descuento;?>% <?php echo $moneda;?></td>
			<td style='text-align:right' class=''><?php echo number_format($precio_descuento,$currency_format['precision_currency'],$currency_format['decimal_separator'],$currency_format['thousand_separator']);?></td>
			
		</tr>
		<?php 
			}
		?>
		<tr>
			<td style='text-align:right' class='' colspan="4" ><?php echo $tax_txt;?> <?php echo $tax;?>% <?php echo $moneda;?></td>
			<td style='text-align:right' class=''><?php echo number_format($total_iva,$currency_format['precision_currency'],$currency_format['decimal_separator'],$currency_format['thousand_separator']);?></td>
			
		</tr>

		<tr>
			<td style='text-align:right' class='' colspan="4" ><b>Total <?php echo $moneda;?></b></td>
			<td style='text-align:right' class=''> <b><?php echo number_format($total_compra,$currency_format['precision_currency'],$currency_format['decimal_separator'],$currency_format['thousand_separator']);?> </b></td>
			
		</tr>
			
		</table>

		<table border=0 style="width:100%;" cellspacing=0>
			
			<tr>
				<td style="width:100%;text-align:left; font-size:85%" class=''>CAJERO: <?php echo get_id('users','fullname','user_id',$sale_by);?> </td>
			</tr>
		</table>
		<br><br>

           <table border=0 style="width:100%;" cellspacing=0>
			
			<tr>
		     <?php
		     /* $formatterES = new NumberFormatter("es-ES", NumberFormatter::SPELLOUT);
             $izquierda = intval(floor($total_compra));
             $derecha = intval(($total_compra - floor($total_compra)) * 100
             $variable_cantidad =  $formatterES->format($izquierda) . " punto " . $formatterES->format($derecha); */
             ?>
		<!-- 	 <td style="width:100%;text-align:center; font-size:85%" class=''>< ?Php echo $variable_cantidad;?></td> -->
			</tr>
		</table>
		<br>
		<table border=0 style="width:100%;" cellspacing=0>
			<tr>
				<td class='top bottom' style="width:100%;text-align:center;font-size:10px" ></td>
			</tr>
		</table>
			<p style="width:100%;text-align:center">*** GRACIAS POR SU COMPRA ***</p>
</page>

