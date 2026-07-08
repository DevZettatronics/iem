<?php
include("modals/modal_nuevoRol.php")
?>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<button class="btn btn-primary btn-img" id="btn_reporte_rolnew">
				Nuevo Rol
			</button>
		</div>
		<h1>Lista de Roles</h1>
		
		
		<?php

		?>
		<?php

		$roles = Permisos::allRoles();
	
		if (count($roles) > 0) {
			// si hay usuarios
		?>
			<div class="box box-primary">
				<div class="box-body">
					<table class="table table-bordered table-hover">
						<thead>
							<th>Id Rol</th>
							<th>Nombre del Rol</th>
							<th>Acciones</th>
							<th></th>
						</thead>  
						<?php
						foreach ($roles as $rol) {
						?>
							<tr>
							    <td><?php echo $rol->id_rol; ?></td>
								<td><?php echo $rol->nombre_rol; ?></td>
								<td style="width:250px;">
									<a href="index.php?view=editpermisos&id=<?php echo $rol->id_rol; ?>&name=<?php echo $rol->nombre_rol?>" class="btn btn-info btn-xs">Permisos</a>
									<a href="index.php?action=delroles&id=<?php echo $rol->id_rol; ?>" 
										class="btn btn-danger btn-xs"
										onclick="return confirm('⚠️ Al eliminar el rol, se eliminarán los permisos asignados.\n\n¿Deseas continuar?');">
										Eliminar
									</a>

								</td>
							</tr>
					<?php

						}
						echo "</table></div></div>";
					} else {
						// no hay usuarios
					}


					?>


				</div>
			</div>

<script>
	const idModal = document.getElementById("btn_reporte_rolnew");

	idModal.addEventListener("click", () => {
		// console.log("Diste click");
		$("#modal_nuevoRol").modal('show');
	})


	//Mndamos inforemacion del modal 
	document.getElementById ("insertar_rol").addEventListener("click", async( ) => {
		console.log("me diste clic");
		
		//Obtenemos el contenido del modal
		const nameRol = document.getElementById("nameRol").value;

		if (nameRol === '') {
			alert("Introduce un nombre valido");
			return;
		}

		try {
			//Mandamos informacion al back
			const response = await fetch("index.php?action=roles",{
				method:"POST",
				headers: {
					"Content-Type":"application/json",
				},
				body:JSON.stringify({nameRol})
			})

			if (!response.ok) {
				throw new Error("Error al enviar datos");
			}

			const result = await response.json();
			// console.log("Respuesta del servidor: ",  result);
			alert("Nuevo Rol generado correctamente");
			window.location.reload(true);

		} catch (error) {
			console.error("Error:", error);
    		alert("Hubo un error al generar el reporte ");
		}
		
	})
</script>