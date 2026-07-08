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
	border-top: 1px solid #eee;
}
.bottom{
	border-bottom: 1px solid #eee;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}

-->
</style>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm" style="font-size: 12px; font-family: helvetica" backimg="">
	<?php 
	$title_report='Reporte de inventario';
	include('page_header_footer.php');
	
	?>

	
	<div style='border-bottom: 3px solid #2ecc71;padding-bottom:-5px;text-align:center'>
		<h4>Reporte de inventario generado: <?php echo date('d/m/Y');?> </h4>
	</div>

	
	
	
  
    <table class="table-bordered" style="width:100%;" cellspacing=0>
        <tr>
			<th class='top bottom'  style="width: 15%;text-align:center">C&oacute;digo</th>
            <th class='top bottom'  style="width: 40%;">Producto</th>
            <th class='top bottom'  style="width: 15%;">Categoíra</th>
            <th class='top bottom'  style="width: 10%;text-align:center">Existencias</th>
			<th class='top bottom'  style="width: 10%;text-align:right">Costo</th>
			<th class='top bottom'  style="width: 10%;text-align:right">Total</th>
        </tr>
		<?php
			$sumador=0;//Inicializo variable
			while($row=mysqli_fetch_array($query)){
			$product_id=$row['product_id'];
			$product_code=$row['product_code'];
			$product_name=$row['product_name'];
			$category_name=$row['name'];
			$buying_price=$row['buying_price'];
			$buying_price=number_format($buying_price,$currency_format['precision_currency'],'.','');
			$total=$buying_price*get_stock($product_id);
			$total=number_format($total,$currency_format['precision_currency'],'.','');
			$sumador+=$total;
			?>
				<tr>
					<td class='bottom' style="width: 15%;text-align:center"><?php echo $product_code;?></td>
					<td class='bottom' style="width: 40%;"><?php echo $product_name;?></td>
					<td class='bottom' style="width: 15%;"><?php echo $category_name;?></td>
					<td class='bottom' style="width: 10%;text-align:center"><?php  echo get_stock($product_id);?></td>
					<td class='bottom' style="width: 10%;text-align:right"><?php  echo number_format($buying_price,$currency_format['precision_currency'],$currency_format['decimal_separator'],$currency_format['thousand_separator']);?></td>
					<td class='bottom' style="width: 10%;text-align:right"><?php  echo number_format($total,$currency_format['precision_currency'],$currency_format['decimal_separator'],$currency_format['thousand_separator']);?></td>
				</tr>
			<?php 
		}
		
		?>
		<tr>
			<td colspan=5 style='text-align:right'><strong>Total</strong></td>
			<td style='text-align:right'><strong><?php echo number_format($sumador,$currency_format['precision_currency'],$currency_format['decimal_separator'],$currency_format['thousand_separator']);?></strong></td>
		</tr>		
		<tr>
			<td colspan=6 style='text-align:right;border-top:3px solid #2ecc71;padding:4px;padding-top:4px;font-size:14px'></td>
				
		</tr>
	 </table>
</page>

