<!DOCTYPE html>
<html>
  <head>
	
  </head>
  <body class="hold-transition <?php echo $skin;?> sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
		<?php include("View.php");?>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
		
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
		
        <section class="content-header">
				<div class="row">
                    <div class="col-xs-12 col-md-3">
						<div class="input-group">
						  <input type="text" class="form-control" placeholder="Buscar por número" id='q' onkeyup="load(1);">
						  <span class="input-group-btn">
							<button class="btn btn-default" type="button" onclick='load(1);'><i class='fa fa-search'></i></button>
						  </span>
						</div><!-- /input-group -->
						
					</div>
					<div class="col-md-3">
						<select class="form-control select2" data-placeholder="Selecciona el cliente" name="person_id" id="person_id">	
						
						</select>
								
					</div>
					<!-- <div class="col-md-3 hidden-xs"></div> -->
					<div class="col-xs-2 col-md-1">
						<div id="loader" class="text-center"></div>
						
					</div>
					<div class="col-xs-10  col-md-5 ">
						<div class="btn-group pull-right">
							<a href="pos.php" target="_blank" class="btn btn-default"><i class='fa fa-plus'></i> Nuevo</a>
							
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Mostrar
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu pull-right">
							  <li class='active' onclick='per_page(15);' id='15'><a href="#">15</a></li>
							  <li  onclick='per_page(25);' id='25'><a href="#">25</a></li>
							  <li onclick='per_page(50);' id='50'><a href="#">50</a></li>
							  <li onclick='per_page(100);' id='100'><a href="#">100</a></li>
							  <li onclick='per_page(1000000);' id='1000000'><a href="#">Todos</a></li>
							</ul>
							 

						</div>
                    </div>
					<input type='hidden' id='per_page' value='15'>
					
             </div>
				
			 
        </section>
			
        <!-- Main content -->
        	
		
      </div><!-- /.content-wrapper -->
      <?php include("footer.php");?>
    </div><!-- ./wrapper -->

	<?php include("js.php");?>
	<script src="dist/js/VentanaCentrada.js"></script>
	<script src="plugins/select2/select2.full.min.js"></script>
	<script src="dist/js/ventas.js"></script>
  </body>
</html>




