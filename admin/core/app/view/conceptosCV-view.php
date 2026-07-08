<?php if (isset($_GET["opt"]) && $_GET["opt"] == "add" && isset($_GET['id'])) : 
	include "modals/btn_nuevoConcepto.php"; 	
	include "modals/btn_nuevoConceptoEdit.php"; 	

    $id = intval($_GET['id']);
    $id_center =$id;

    $dataCocneptos = Vinculacion::allConceptos($id);
    $dataVinculacion = Vinculacion::getById($id);
    $name = $dataVinculacion->name;
  
?>

	<div class="row">
        <div class="col-md-12">
            <div class="btn-group pull-right">
              
            </div>	
            <h1>Conceptos de convenios (<?php echo $name; ?>)</h1>
            <a href="./?view=centroVinculacion&opt=all" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a> 
			<button class="btn btn-primary btn-img" id="btn_nuevoConcepto">
				Nuevo Concepto
			</button>
<?php
if (count($dataCocneptos) > 0) {
?>
            <div class="box box-primary">
                <div class="box-body">
					<!-- Le quitamos el data table por defecto para que la cinsulta se tomara de forma desc asi trae los datos y el id ayuda a implementar el datatable y desactivar
					  el acomodo automatico -->
					<table id="datatable_conceptos" class="table table-bordered  table-hover" data-page-length="100">
                        <thead>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Monto</th>
                             <?php if (Core::$user->kind == 1 or Core::$user->kind == 12 or Core::$user->kind == 11) : ?>
                            <th>Acciones</th>
                               <?php endif; ?>
                        </thead>
                        <?php foreach ($dataCocneptos as $Vn) { ?>
                            <tr>
                                <td>
                                    <?php echo $Vn->id; ?>
                                </td>
                                <td>
                                    <?php echo $Vn->product_name; ?>
                                </td>
                                <td>
									<?php echo $Vn->monto; ?>
                                </td>
								
                                <!-- Acciones -->
								<td>
									<a id="btn_nuevoEdit" class="btn btn-warning btn-xs" data-id="<?php echo $Vn->id; ?>">Editar</a>

									<!-- <a href="index.php?action=conceptosVinculacion&opt=delete&id=<?php echo $Vn->id; ?>&id_center=<?php echo $id_center; ?>"
										class="btn btn-danger btn-xs"
										onclick="return confirm('⚠️ Al eliminar el concepto, se eliminarán los datos asignados.\n\n¿Deseas continuar?');">
										Eliminar
									</a> -->
                                    <a href="index.php?action=conceptosVinculacion&opt=delete&id=<?php echo $Vn->id; ?>&id_center=<?php echo $id_center; ?>"
                                        class="btn btn-danger btn-xs eliminar-concepto-btn">
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
    $(document).on("click", "#btn_nuevoConcepto", function(e) {
		$('#modal_ConceptosADD').modal('show');
	});


   document.getElementById("generar_registroConcepto").addEventListener("click", async (e) => {
        e.preventDefault();
        

        //Obtenemos la informacion
        let nombre = document.getElementById("name").value.trim();
        let monto = document.getElementById("monto").value.trim();
        let centro_id = document.getElementById("centro_id").value.trim();

        //Valdiaciones
        if (!nombre || !monto) {
            document.getElementById("errorMessage").innerText = "LLena todos los campos.";
            setTimeout(() => document.getElementById("errorMessage").innerText = "", 5000);
            return;
        }

        //Preparamos informacion
        const formData = new FormData();
        formData.append("nombre",nombre);
        formData.append("monto",monto);
        formData.append("centro_id",centro_id);

        //Mandamso informacion al back
        try {
            const response = await fetch('index.php?action=conceptosVinculacion&opt=add', {
                method:"POST",
                body: formData
            })

            //Esperamos respuesta
            const result = await response.text(); // o .json() si devuelves JSON

            // alert(result);
            // Mostrar respuesta con SweetAlert2
            Swal.fire({
                icon: "success",
                title: "¡Operación exitosa!",
                text: result,
                showConfirmButton: false,
                timer: 2000 // 3 segundos
            });

            
            // Limpiar y cerrar modal
            document.getElementById("addcategory").reset();
            $('#modal_ConceptosADD').modal('hide');

		    // Recargar después de 3s
            setTimeout(() => {
                location.reload();
            }, 2000);


        } catch (error) {
            console.error("Error:", error);
		    alert("Ocurrió un error al enviar los datos.");
        }
    });

    $(document).ready(function() {
		$('#datatable_conceptos').DataTable({
			ordering: false,
			pageLength: 100
		});
	});


//  Editar modal

	$(document).on("click", "#btn_nuevoEdit", async function(e) {
		e.preventDefault();
		const id = $(this).data("id");
        // console.log(id);
        
		try {
			const response = await fetch(`index.php?action=conceptosVinculacion&opt=edit&id=${id}`);
			const data = await response.json();

            console.log(data);
            
			// Rellenar los campos del modal
			$("#edit_id").val(data.id);
			$("#edit_name").val(data.product_name);
			$("#edit_monto").val(data.monto);

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
		const edit_monto = document.getElementById("edit_monto").value.trim();
        
		// Validar
		if (!edit_name || !edit_monto ) {
		document.getElementById("errorMessageedit").innerText = "LLena todos los campos.";
		setTimeout(() => document.getElementById("errorMessageedit").innerText = "", 5000);
		return;
		}

		// Preparar datos
		const formData = new FormData();
		formData.append("edit_id", edit_id);
		formData.append("edit_name", edit_name);
		formData.append("edit_monto", edit_monto);

		try {
            // Enviar al backend por fetch
            const response = await fetch("index.php?action=conceptosVinculacion&opt=editUp", {
                method: "POST",
                body: formData
            });

		    // const result = await response.text(); // o .json() si devuelves JSON

            // Mostrar respuesta
            // alert(result);

            // Limpiar y cerrar modal
            // document.getElementById("addcategoryEdit").reset();
            // $('#modal_vinculacionEdit').modal('hide');

            // location.reload();
             const data = await response.json(); // ahora esperamos JSON

            if (data.success) {
                Swal.fire({
                    icon: "success",
                    title: "¡Actualizado!",
                    text: data.message,
                    showConfirmButton: false,
                    timer: 3000
                });

                // Limpiar y cerrar modal
                document.getElementById("addcategoryEdit").reset();
                $('#modal_vinculacionEdit').modal('hide');

                // Recargar después de 3s
                setTimeout(() => {
                    location.reload();
                }, 3000);
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
            alert("Ocurrió un error al enviar los datos a editar.");
		}
	});
</script>

<!-- Alerta de eliminar -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".eliminar-concepto-btn").forEach(btn => {
        btn.addEventListener("click", function(e) {
            e.preventDefault();
            const url = this.getAttribute("href");

            Swal.fire({
                title: "⚠️ ¿Estás seguro?",
                text: "Al eliminar el concepto, se eliminarán los datos asignados.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "¡Eliminado!",
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(() => {
                                    window.location.href = data.redirect;
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: "No se pudo eliminar el concepto."
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
