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
	$title_report='Reporte de alumnos';
	include('page_header_footer.php');
	
	?>

	
	<div style='border-bottom: 3px solid #2ecc71;padding-bottom:-5px;text-align:center'>
		<h4>Reporte de alumnos generado: <?php echo date('d/m/Y');?> </h4>
	</div>

	
	
	
  
    <table class="table-bordered" style="width:100%;" cellspacing=0>
        <tr>
			<th class='top bottom'  style="width: 30%;text-align:center">Nombre</th>
            <th class='top bottom'  style="width: 40%;">Apellidos</th>
            <th class='top bottom'  style="width: 30%;">Grupo</th>
        </tr>
		<?php
			while($row=mysqli_fetch_array($query)){
			$name=$row['name'];
			$apellido=$row['apellido'];
			$grupo=$row['grupo'];
			
			?>
				<tr>
					<td class='bottom' style="width: 30%;text-align:center"><?php echo $name;?></td>
					<td class='bottom' style="width: 40%;"><?php echo $apellido;?></td>
					<td class='bottom' style="width: 30%;"><?php echo $grupo;?></td>
					
				</tr>
			<?php 
		}
		
		?>
		<tr>
			
			
		</tr>		
		<tr>
			<td colspan=6 style='text-align:right;border-top:3px solid #2ecc71;padding-bottom:-5px;text-align:center'></td>
				
		</tr>
	 </table>
</page>

