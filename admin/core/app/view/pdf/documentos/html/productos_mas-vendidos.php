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
	$title_report='Reporte  de productos más vendidos';
	include('page_header_footer.php');
	
	?>

	
	<div style='border-bottom: 3px solid #2ecc71;padding-bottom:-5px;text-align:center'>
		<h4>Reporte de productos más vendidos generado: <?php echo date('d/m/Y');?> </h4>
	</div>

	
	
	
  
    <table class="table-bordered" style="width:100%;" cellspacing=0>
        <tr>			
            <th class='top bottom'  style="width: 40%;">Producto</th>
            <th class='top bottom'  style="width: 15%;">Categoría</th>
            <th class='top bottom'  style="width: 10%;">Ventas</th>		
        </tr>
		<?php
			$sumador=0;//Inicializo variable
			while($row=mysqli_fetch_array($query)){
			$product_id=$row['product_name'];
			$product_code=$row['name'];
			$product_name=$row['TotalVentas'];			
			?>
				<tr>
					<td class='bottom' style="width: 15%;"><?php echo $product_id;?></td>
					<td class='bottom' style="width: 40%;"><?php echo $product_code;?></td>
					<td class='bottom' style="width: 15%;"><?php echo $product_name;?></td>					
				</tr>
			<?php 
		}
		
		?>		
	 </table>
</page>

