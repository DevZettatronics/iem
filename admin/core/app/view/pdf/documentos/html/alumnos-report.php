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
<page backtop="20mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 13px; font-family: helvetica" backimg="">
	<?php 
	$title_report='Reporte de alumnos';
	include('page_header_footer1.php');
	?>

	
	<div style='border-bottom: 3px solid #2ecc71;padding-bottom:10px'>
		Usuario:  
		<?php
		$sql1=mysqli_query($con,"select name from alumnos where id='".$id."'");
		$rw1=mysqli_fetch_array($sql1);
		$name=$rw1['name']; 
		if (empty($name)){
			echo "Todos";
		}else {
			echo $fullname;
		}
		?>
	</div>

	
	
	
  
    <table class="table-bordered" style="width:100%;" cellspacing=0>
        <tr>
			<th class='top bottom'  style="width: 12%;text-align:center">No. Control</th>
            <th class='top bottom'  style="width: 40%;">Nombre</th>
            <th class='top bottom'  style="width: 12%;text-align:center">Apellidos</th>
            <th class='top bottom'  style="width: 12%;text-align:right">Estado</th>
			<th class='top bottom'  style="width: 12%;text-align:right">Alta</th>
			
            
        </tr>
		<?php
		
		while($row=mysqli_fetch_array($query)){
			$id=$row['id'];
			$name=$row['name'];
			$sql_alumnos=mysqli_query($con,"select name from alumnos where id='".$id."'");
			$rw_alumnos=mysqli_fetch_array($sql_alumnos);
			$alumnos_name=$rw_alumnos['name'];
			$name=$row['name'];
			$apellido=$row['apellido'];
			$status=$row['status'];
			$date_added=$row['date_added'];
			
			
			
			
			
			
			
			?>
				<tr>
					<td class='bottom' style="width: 12%;text-align:center"><?php echo $id;?></td>
					<td class='bottom' style="width: 40%;"><?php echo $alumnos_name;?></td>
					<td class='bottom' style="width: 12%;text-align:center"><?php echo $fecha;?></td>
					<td class='bottom' style="width: 12%;text-align:right"><?php echo number_format($subtotal,$currency_format['precision_currency'],$currency_format['decimal_separator'],$currency_format['thousand_separator']);?></td>
					<td class='bottom' style="width: 12%;text-align:right"><?php echo number_format($tax,$currency_format['precision_currency'],$currency_format['decimal_separator'],$currency_format['thousand_separator']);?></td>
					<td class='bottom' style="width: 12%;text-align:right"><?php echo number_format($total,$currency_format['precision_currency'],$currency_format['decimal_separator'],$currency_format['thousand_separator']);?></td>
				</tr>
				
				<tr>
					<td class='bottom' style="width: 12%;text-align:center">	$pdf->cell(15,8,'',2,0,'C',0);
    $pdf->cell(5,8,'Comentarios',2,1,'L',0);
      $pdf->cell(190,8,$row['name'],1,1,'C',0);</td>
				
				</tr>
			<?php 
		}
		
		?>
		<tr>
				<td colspan=3 style='text-align:right;border-top:3px solid #2ecc71;padding:4px;padding-top:4px;font-size:14px'><strong>Totales <?php echo $moneda;?></strong></td>
				<td style='text-align:right;border-top:3px solid #2ecc71;padding:4px;padding-top:4px;font-size:14px'><?php echo number_format($sumador_subtotal,$currency_format['precision_currency'],$currency_format['decimal_separator'],$currency_format['thousand_separator']);?></td>
				<td style='text-align:right;border-top:3px solid #2ecc71;padding:4px;padding-top:4px;font-size:14px'><?php echo number_format($sumador_tax,$currency_format['precision_currency'],$currency_format['decimal_separator'],$currency_format['thousand_separator']);?></td>
				<td style='text-align:right;border-top:3px solid #2ecc71;padding:4px;padding-top:4px;font-size:14px'><?php echo number_format($sumador_total,$currency_format['precision_currency'],$currency_format['decimal_separator'],$currency_format['thousand_separator']);?></td>
		</tr>
	 </table>
</page>

