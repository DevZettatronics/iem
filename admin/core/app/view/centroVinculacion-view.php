<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all") : 
	include "modals/modal_centroVinculacion.php"; 	
	include "modals/modal_centroVinculacionEdit.php"; 	
	
	$dataVinculacion = Vinculacion::all();

?>
	<div class="row">
        <div class="col-md-12">
            <div class="btn-group pull-right">
              
            </div>	
            <h1>Centro de Vinculación</h1>
            <a href="./?view=home" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a> 
			<button class="btn btn-primary btn-img" id="btn_nuevo">
				Nuevo
			</button>
<?php
if (count($dataVinculacion) > 0) {
?>
            <div class="box box-primary">
                <div class="box-body">
					<!-- Le quitamos el data table por defecto para que la cinsulta se tomara de forma desc asi trae los datos y el id ayuda a implementar el datatable y desactivar
					  el acomodo automatico -->
					<table id="datatable_hpagos" class="table table-bordered  table-hover" data-page-length="100">
                        <thead>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Responsable</th>
                            <th>Direccion</th>
                            <th>Telefono</th>
                            <th>Parcialidades</th>
                             <?php if (Core::$user->kind == 1 or Core::$user->kind == 12 or Core::$user->kind == 11) : ?>
                            <th>Acciones</th>
                               <?php endif; ?>
                        </thead>
                        <?php foreach ($dataVinculacion as $Vn) { ?>
                            <tr>
                                <td>
                                    <?php echo $Vn->id; ?>
                                </td>
                                <td>
                                    <?php echo $Vn->name; ?>
                                </td>
                                <td>
									<?php echo $Vn->descripcion; ?>
                                </td>
								 <td>
									<?php echo $Vn->responsable; ?>
                                </td>
								 <td>
									<?php echo $Vn->address; ?>
                                </td>
                                <td>
									<?php echo $Vn->phone; ?>
                                </td>
								 <td>
									<?php if($Vn->parcialidades === "1"){
										echo "SI";
									} else if ($Vn->parcialidades === "2"){
										echo "NO";
									} else {
										echo "Sin parcialidad";
									}
									?>
                                </td>
                                <!-- Acciones -->
								<td>
									<a href="index.php?view=conceptosCV&opt=add&id=<?php echo $Vn->id; ?>" 
										id="btn_conceptos" class="btn btn-primary btn-xs" data-id="<?php echo $Vn->id; ?>">Conceptos</a>
									
									<a id="btn_nuevoEdit" class="btn btn-warning btn-xs" data-id="<?php echo $Vn->id; ?>">Editar</a>

									<!-- <a href="index.php?action=centrodeVinculacion&opt=delete&id=<?php echo $Vn->id; ?>" 
										class="btn btn-danger btn-xs"
										onclick="return confirm('⚠️ Al eliminar el registro, se eliminarán los datos asignados.\n\n¿Deseas continuar?');">
										Eliminar
									</a> -->
									<a href="index.php?action=centrodeVinculacion&opt=delete&id=<?php echo $Vn->id; ?>" 
										class="btn btn-danger btn-xs eliminar-btn">
										Eliminar
									</a>

								</td>
                            </tr>
                        <?php
                        } # FIn del foreach
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php endif; ?>

<script>
	$(document).on("click", "#btn_nuevo", function(e) {
		$('#modal_vinculacionADD').modal('show');
	});

   
	document.getElementById("generar_registro").addEventListener("click", async function (e) {
		e.preventDefault();

		// Obtener valores
		const name = document.getElementById("name").value.trim();
		const descripcion = document.getElementById("descripcion").value.trim();
		const responsable = document.getElementById("responsable").value.trim();
		const direccion = document.getElementById("direccion").value.trim();
		const telefono = document.getElementById("telefono").value.trim();
		const parcialidades = document.getElementById("parcialidades").value.trim();
		const lastname = document.getElementById("lastname").value.trim();
		const email = document.getElementById("email").value.trim();

		// Validar
		if (!name || !descripcion || !responsable || !direccion || !telefono || !parcialidades || !lastname || !email) {
		document.getElementById("errorMessage").innerText = "LLena todos los campos.";
		setTimeout(() => document.getElementById("errorMessage").innerText = "", 5000);
		return;
		}

		// Preparar datos
		const formData = new FormData();
		formData.append("name", name);
		formData.append("descripcion", descripcion);
		formData.append("responsable", responsable);
		formData.append("direccion", direccion);
		formData.append("telefono", telefono);
		formData.append("parcialidades", parcialidades);
		formData.append("lastname", lastname);
		formData.append("email", email);

		try {
		// Enviar al backend por fetch
		const response = await fetch("index.php?action=centrodeVinculacion&opt=add", {
			method: "POST",
			body: formData
		});

		const result = await response.text(); // o .json() si devuelves JSON

		// Mostrar respuesta
		// alert(result);

		// Mostrar respuesta con SweetAlert2
		Swal.fire({
			icon: "success",
			title: "¡Operación exitosa!",
			text: result,
			showConfirmButton: false,
			timer: 3000 // 3 segundos
		});

		// Limpiar y cerrar modal
		document.getElementById("addcategory").reset();
		$('#modal_vinculacionADD').modal('hide');

		// Recargar después de 3s
		setTimeout(() => {
			location.reload();
		}, 3000);

		} catch (error) {
		console.error("Error:", error);
		alert("Ocurrió un error al enviar los datos.");
		}
	});


	$(document).ready(function() {
		$('#datatable_hpagos').DataTable({
			ordering: false,
			pageLength: 100
		});
	});

	//  Editar modal

	$(document).on("click", "#btn_nuevoEdit", async function(e) {
		e.preventDefault();
		const id = $(this).data("id");

		try {
			const response = await fetch(`index.php?action=centrodeVinculacion&opt=edit&id=${id}`);
			const data = await response.json();

			// Rellenar los campos del modal
			$("#edit_id").val(data.id);
			$("#edit_name").val(data.name);
			$("#edit_descripcion").val(data.descripcion);
			$("#edit_responsable").val(data.responsable);
			$("#edit_direccion").val(data.address);
			$("#edit_telefono").val(data.phone);
			$("#lastnameEdit").val(data.lastname);
			$("#emailEdit").val(data.email);
			
			// console.log(data.parcialidades);
			
				const val = String(data.parcialidades);
				const options = ["1", "2", ""]; // valores permitidos

				if (options.includes(val)) {
					$("#parcialidadesEdit").val(val);
				} else {
					$("#parcialidadesEdit").val(""); // valor por defecto
				}


			$('#modal_vinculacionEdit').modal('show');
		} catch (error) {
			console.error("Error al obtener los datos:", error);
		}
	});
	 
	document.getElementById("Actualizar").addEventListener("click", async function (e) {
		e.preventDefault();

		// Obtener valores
		const edit_id = document.getElementById("edit_id").value.trim();
		const edit_name = document.getElementById("edit_name").value.trim();
		const edit_descripcion = document.getElementById("edit_descripcion").value.trim();
		const edit_responsable = document.getElementById("edit_responsable").value.trim();
		const edit_direccion = document.getElementById("edit_direccion").value.trim();
		const edit_telefono = document.getElementById("edit_telefono").value.trim();
		const edit_parcialidades = document.getElementById("parcialidadesEdit").value.trim();
		const edit_lastname = document.getElementById("lastnameEdit").value.trim();
		const edit_email = document.getElementById("emailEdit").value.trim();

		// Validar
		if (!edit_name || !edit_descripcion || !edit_responsable || !edit_direccion || !edit_telefono || !edit_lastname || !edit_email) {
		document.getElementById("errorMessageedit").innerText = "LLena todos los campos.";
		setTimeout(() => document.getElementById("errorMessageedit").innerText = "", 5000);
		return;
		}

		// Preparar datos
		const formData = new FormData();
		formData.append("edit_id", edit_id);
		formData.append("edit_name", edit_name);
		formData.append("edit_descripcion", edit_descripcion);
		formData.append("edit_responsable", edit_responsable);
		formData.append("edit_direccion", edit_direccion);
		formData.append("edit_telefono", edit_telefono);
		formData.append("edit_parcialidades", edit_parcialidades);
		formData.append("edit_lastname", edit_lastname);
		formData.append("edit_email", edit_email);

		try {
			// Enviar al backend por fetch
			const response = await fetch("index.php?action=centrodeVinculacion&opt=editUp", {
				method: "POST",
				body: formData
			});


			const data = await response.json(); // esperamos JSON
			// console.log("dATA: " , data);
			
			if (data.success) {
				Swal.fire({
					icon: "success",
					title: "¡Actualizado!",
					text: data.message,
					showConfirmButton: false,
					timer: 2000
				});

				// Cerrar modal y limpiar formulario
				document.getElementById("addcategoryEdit").reset();
				$('#modal_vinculacionEdit').modal('hide');

				// Recargar después de 2s
				setTimeout(() => {
					location.reload();
				}, 2000);
			} else {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: data.message,
					confirmButtonText: "Aceptar"
				});
			}

		} catch (error) {
			console.error("Error:", error);
			Swal.fire({
				icon: "error",
				title: "Error",
				text: "Ocurrió un problema al enviar los datos a editar.",
				confirmButtonText: "Aceptar"
			});
		}
	});
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".eliminar-btn").forEach(btn => {
        btn.addEventListener("click", function(e) {
            e.preventDefault(); // evita ir directo al enlace
            const url = this.getAttribute("href");

            Swal.fire({
                title: "⚠️ ¿Estás seguro?",
                text: "Al eliminar el registro, se eliminarán los conceptos relacionados.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    // aquí en vez de redirigir, llamamos al backend con fetch
                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "¡Eliminado!",
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(() => {
                                    // redirige después de la alerta
                                    window.location.href = data.redirect;
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: data.message || "No se pudo eliminar el registro."
                                });
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Ocurrió un problema en el servidor."
                            });
                        });
                }
            });
        });
    });
});

</script>
