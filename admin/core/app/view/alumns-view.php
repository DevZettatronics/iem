<?php
$alumns = PersonData::getAlumns();
include "modals/modal_estado.php";
?>
<style>
/* Alinear el submenú correctamente */
/* Submenú */
.inline-submenu {
    list-style: none !important;
    margin: 0 !important;
    padding-left: 70px !important; /* mueve más hacia adentro */
}

.inline-submenu li a {
    display: block; /* importante para ocupar todo el li */
    padding: 4px 15px; /* espacio arriba/abajo y a los lados */
    color: #747272ff; /* color normal */
    background-color: transparent;
    text-decoration: none;
    transition: background-color 0.2s ease, color 0.2s ease;
}

/* Hover del submenú */
.inline-submenu li a:hover {
    color: #333;
    background-color: #e6e6e6; /* mismo hover que btn-default */
}


.has-inline-submenu > a {
    position: relative;
}

.has-inline-submenu > a .caret {
    float: right;
    margin-top: 6px;
}

/* Color de letra del bootn eliminar */
.eliminarColor{
	color: #747272ff; /* color normal */
}

/* Modal de vista */
    /* Permitir texto largo sin romper tabla */
    #tablaHistorial td:nth-child(4) {
        max-width: 400px;
        white-space: pre-wrap;   /* Mantiene saltos de línea */
        word-wrap: break-word;   /* Rompe palabras largas */
        vertical-align: top;
    }

    /* Si el mensaje es demasiado largo, que tenga scroll interno */
    .mensaje-largo {
        max-height: 200px;
        overflow-y: auto;
        padding-right: 6px;
    }

	/* Hacer que el encabezado de la tabla quede fijo */
	#tablaHistorial thead th {
		position: sticky;
		top: 0;
		background: #f8f9fa;   /* mismo color del thead-light */
		z-index: 10;
	}

	/* Contenedor con scroll para tabla si sobrepasa 7 filas */
	.tabla-scroll {
		max-height: 300px;      /* altura ideal visible */
		overflow-y: auto;       /* activa scroll solo si hace falta */
	}

	/* Mantener tabla alineada y bonita */
	.tabla-scroll table {
		margin: 0 !important;
	}
</style>
<div class="row">
	<div class="col-md-12">

		<h3><img src="../storage/posts/estudiantes.png"  width="52px"> <strong>Control de Estudiantes</strong></h3>
		<h5>La información mostrada en este espacio contiene todos los <strong>estudiantes</strong> dados de alta en el sistema. </h5>

        <a href="./?view=home" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a> 
        
		<!-- <a href="index.php?view=newalumn" class="btn btn-success"><i class='fa fa-asterisk'></i> Nuevo Estudiante</a> -->
		<?php if (count($alumns) > 0) : ?>
		<?php endif; ?>
		<!--	<a href="index.php?view=list&team_id=?php echo $_GET["id"]; ?>" class="btn btn-default"><i class='fa fa-area-chart'></i> Estadisticas</a> -->
		<br><br>
		<?php
		if (count($alumns) > 0) {
			// si hay usuarios
		?>
			<div class="box box-primary">
				<div class="box-body">
					<table id="tabladatatable" class="table table-bordered table-hover">
						<thead class="bg-primary font-weight-bold p-3 text-left">
							<th>Matrícula</th>
							<th>Nombre</th>
							<th>Programa</th>
							<th>Email</th>
							<th>Inscripción</th>
							<th>Beca</th>
							<th>Historiales</th>
							<th></th>
						</thead>
						<?php
						foreach ($alumns as $alumn) {
							$alumn->id;
							/* becas */
							$con = Database::getCon();
							$sql_1 = "SELECT * FROM becas WHERE id = '" . $alumn->beca . "'";
							$query_1 = mysqli_query($con, $sql_1);
							$con_1 = mysqli_fetch_array($query_1);
							if ($alumn->beca == null) {
								$name_beca = "Sin Beca Asiganda";
							} else {
								$name_beca = $con_1['name'];
								$por_beca = $con_1['porcentaje'];
							}
							/**********/
							$sql_2 = "SELECT * FROM becas WHERE id = '" . $alumn->promocion . "'";
							$query_2 = mysqli_query($con, $sql_2);
							$con_2 = mysqli_fetch_array($query_2);
							if ($alumn->promocion == null) {
								$name_promocion = "Sin Promoción Asiganda";
							} else {
								$name_promocion = $con_2['name'];
								$por_propocion = $con_2['porcentaje'];
							}
							$sql_pro = "SELECT ins.alumn_id, 
											   ins.team_id, 
											   te.id, 
											   te.id_program, 
											   te.modalidad as id_modalida_team, 
											   per.id, 
											   prog.id,
											   prog.type
											   FROM inscription ins
							INNER JOIN team te ON te.id = ins.team_id
							INNER JOIN program prog ON prog.id = te.id_program
							INNER JOIN person per ON per.id = ins.alumn_id
							WHERE ins.alumn_id = $alumn->id";
							$query_pro = mysqli_query($con, $sql_pro);
							$rwp = mysqli_fetch_array($query_pro);
							$id_program = $rwp['id_program'];
							$type = $rwp['type'];
							$id_modalida_team = $rwp['id_modalida_team'];
							$sql_pr1 = mysqli_query($con, "SELECT * FROM program WHERE id='$id_program'");
							$rw_pro = mysqli_fetch_array($sql_pr1);
							$name_program = $rw_pro['name'];

							$querySsA = mysqli_query(
								$con,
								"SELECT estado, fecha_manual 
								FROM estatus_alumnos 
								WHERE id = " . intval($alumn->status_alumno)
							);

							//Modalidad del grupo
							if (empty($id_modalida_team) || $id_modalida_team == 0) {
								$nombre_modalidagrupo = 'Sin modalidad aún';
							}else{
								$sql_pr2 = mysqli_query($con, "SELECT * FROM modalidad WHERE id_modalidad = '$id_modalida_team'");
								$rw_pro2 = mysqli_fetch_array($sql_pr2);
								$nombre_modalidagrupo = $rw_pro2['nombre'];
							}
							$estadoTxt = "";
							$fechaTxt   = "";

							if ($querySsA && mysqli_num_rows($querySsA) > 0) {

								$dataAs = mysqli_fetch_assoc($querySsA);

								$estadoTxt  = $dataAs['estado'] ?? "";
								$fechaTxt   = $dataAs['fecha_manual'] ?? "";
							}


							$estadosTexto = [
								1 => "Bajas administrativa",
								2 => "Baja temporal",
								3 => "Baja definitiva",
								4 => "Baja académica",
								5 => "Activo",
								6 => "Egresados titulado",
								7 => "Egresados en vía de titulación"
							];

							$estadoTexto = $estadosTexto[$estadoTxt] ?? "Desconocido";
						?>
							<tr>
								<td><?php echo $alumn->code; ?></td>
								<td>
									<?php echo $alumn->name . " " . $alumn->lastname; ?>
									<br>
									<span style="display: inline-block; border-left: 5px solid #FFE487; padding-left: 5px;">
										<p style="font-size: 11px;"> Estado: <strong> <?php echo $estadoTexto; ?></strong></p>
                                    </span>
								</td>
								<td>
									<?php echo $name_program; ?>
									<br>
									<span style="display: inline-block; border-left: 5px solid #FFE487; padding-left: 5px;">
										<p style="font-size: 11px;"> Modalidad: <strong> <?php echo $nombre_modalidagrupo; ?></strong></p>
                                    </span>
								</td>
								<td><?php echo $alumn->email; ?></td>
								<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'estudiantes')): ?>
									
									
									<!--<td style="font-size: 11px; font-weight: bold;"><?php echo $name_promocion . " - " . $por_propocion . '%'; ?></td>--> <!--línea original-->
									<td style="font-size: 11px; font-weight: bold;" ><?php echo $name_promocion; ?></td>
									
									<!--<td style="font-size: 11px; font-weight: bold;"><?php echo $name_beca . " - " . $por_beca . '%'; ?></td>--> <!--línea original-->
									<td style="font-size: 11px; font-weight: bold;"><?php echo $name_beca?></td>
									
									
								<?php endif; ?>
								<td>
									<div class="btn-group pull-right">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Historial <span class="fa fa-caret-down"></span></button>
										<ul class="dropdown-menu">
											<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'estudiantes')): ?>
												<!---->
												<li><a href="index.php?view=historial_esp&id=<?php echo $alumn->id ?>&name=<?php echo $alumn->name ?>&lastname=<?php echo $alumn->lastname ?>&code=<?php echo $alumn->code ?>"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Historial Especialidad</a></li>
												<!---->
												<li><a href="index.php?view=historial_bachi&id=<?php echo $alumn->id ?>&name=<?php echo $alumn->name ?>&lastname=<?php echo $alumn->lastname ?>&code=<?php echo $alumn->code ?>"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Historial Bachillerato</a></li>
												<!---->
												<li><a href="index.php?view=historial&id=<?php echo $alumn->id ?>&name=<?php echo $alumn->name ?>&lastname=<?php echo $alumn->lastname ?>&code=<?php echo $alumn->code ?>" target="_blank"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Historial Licencitura</a></li>
												<!---->
												<li><a href="index.php?view=historial_maestria&id=<?php echo $alumn->id ?>&name=<?php echo $alumn->name ?>&lastname=<?php echo $alumn->lastname ?>&code=<?php echo $alumn->code ?>"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Historial Maestría</a></li>
												<!---->
												<li><a href="index.php?view=historial_doctorado&id=<?php echo $alumn->id ?>&name=<?php echo $alumn->name ?>&lastname=<?php echo $alumn->lastname ?>&code=<?php echo $alumn->code ?>"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Historial Doctorado</a></li>
												<!---->
											<?php endif; ?>
										</ul>
									</div>
								</td>
								<td>
									<div class="btn-group pull-right">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
										<ul class="dropdown-menu">
											<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'estudiantes')): ?>
												<li><a href="index.php?view=alumnhistory&id=<?php echo $alumn->id; ?>"><i class='fa fa-eye'></i> Calificaciones por Ciclo</a></li>
												<!---->
												<li><a href="index.php?view=alumndocs&code=<?php echo $alumn->code; ?>"><i class="fa fa-file"></i> Expediente</a></li>
											<?php endif; ?>
											<!----->
										<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'estudiantes')): ?>
												<!-- <li><a href="index.php?view=editalumnbeca&opt=editb&id=<?php echo $alumn->id; ?>"><i class="fa fa-bold"></i> Beca Asignada</a></li> -->
												<li><a href="index.php?view=add_alumnbeca_prom&opt=editb&id=<?php echo $alumn->id; ?>"><i class='fa fa-asterisk'></i> Asignar Beca | Inscripción</a></li>
											<?php endif; ?>
											<!---->
											<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'estudiantes')): ?>
												<li><a href="index.php?view=editalumn&id=<?php echo $alumn->id; ?>"><i class='fa fa-edit'></i> Editar Perfil</a></li>
											<?php endif; ?>

											<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'estudiantes')): ?>
												<li class="has-inline-submenu">
													<a href="javascript:void(0)" class="toggle-inline-submenu">
														<i class="fa fa-user-times "></i>  Estado del Alumno <span class="caret ms-1"></span>
													</a>

													<!-- SUBMENÚ QUE SE DESPLIEGA DENTRO -->
													<ul class="inline-submenu" >
														<li>
															<a href="#" id="modalEstado" data-id="<?php echo $alumn->id; ?>">
																<i class="fa fa-edit me-2"></i> Editar Estado
															</a>
														</li>
														<li>
															<a href="javascript:void(0)" onclick='verMensaje(<?php echo json_encode($alumn->status_alumno); ?>,<?php echo json_encode($alumn->id); ?>)'>
																<i class="fa fa-eye me-2"></i> Ver Estado
															</a>
														</li>
													</ul>
												</li>


											<?php endif; ?>
											
											<!---->
											<?php if (Permisos::usuarioTieneModulo(Core::$user->kind, 'estudiantes')): ?>
												<li><a href="index.php?action=alumns&opt=del&id=<?php echo $alumn->id; ?>"
												onclick="return confirm('⚠️ Al eliminar el registro, se eliminarán los datos del alumno.\n\n¿Deseas continuar?');">
												<i class='fa fa-trash'></i> Eliminar</a></li>

											<?php endif; ?>
										</ul>
									</div><!-- /btn-group -->
								</td>
							</tr>
						<?php
						}
						echo "</table></div></di>";
						?>
					</table>
				</div>
			</div>
		<?php } else {
			echo "<p class='alert alert-danger'>No hay Alumnos</p>";
		}
		?>
	</div>
</div>
<!-- </div> -->
<!-- href="#" onclick="historial(?php echo $alumn->id ?>,'?php echo $alumn->name; ?>','?php echo $alumn->lastname ?>','?php echo $alumn->code ?>')" -->
<script>
	// function historial(alumn_id, alumn_name,alumn_lastname, alumn_code, fecha) {
	// 	//https://craftpip.github.io/jquery-confirm/ documentacion
	// 	var alumn_id = alumn_id;
	// 	var alumn_name = alumn_name;
	// 	var alumn_lastname = alumn_lastname;
	// 	var alumn_code = alumn_code;
	// 	VentanaCentrada('historial-view.php?alumn_id=' + alumn_id + '&alumn_name=' + alumn_name + '&alumn_lastname=' + alumn_lastname + '&alumn_code=' + alumn_code + '&fecha=' + fecha, '', '1024', '768', 'true');
	// }

	$(document).on("click", "#modalEstado", function(e) {
		e.preventDefault();

		let idAlumno = $(this).data("id");  // 🔥 obtiene el ID real del alumno
		$("#alumno_id").val(idAlumno);      // lo manda al input hidden en el modal

		$('#modalEstadoview').modal('show');
	});



    $(document).on("click", "#guardar_estado", function(e) {
		e.preventDefault();

		
		var $btn = $(this);
  		
		// Bloquear el botón
   		$btn.prop("disabled", true);

		let alumno_id = document.getElementById("alumno_id").value;
		let estado_alumno = document.getElementById("estado_alumno").value;
		let comentario = document.getElementById("comentario").value;
		let fecha_estado = document.getElementById("fecha_estado").value;
		
		// Validación básica
		if (estado_alumno === "" || fecha_estado === "") {
			alert("Todos los campos obligatorios deben estar llenos.");
			return;
		}

		$.ajax({
			url: "index.php?action=estadoAlumno&opt=add", // Archivo PHP que procesará la petición
			type: 'POST',                                     // Método de envío
			data: {
				opt: "add",            // Acción que realizará el backend (insertar en histórico)
				id: alumno_id,          // ID del alumno al que se le cambia el estado
				estado: estado_alumno,        // Estado seleccionado del select
				comentario: comentario, // Comentario opcional
				id_usuario: <?= $_SESSION["user_id"]; ?>, // ID del usuario que hace el cambio
				fecha: fecha_estado           // Fecha manual seleccionada
			},
			dataType: 'json',
			success: function(response) {
				// console.log("Respuesta del servidor:", response); // Ver qué regresa el PHP

				// Acceder al JSON
				if (response.status === "ok") {

					Swal.fire({
						icon: 'success',
						title: '¡Éxito!',
						text: response.message,
						confirmButtonColor: '#3085d6'
					});

					// desbloquear si exito
            		$btn.prop("disabled", false);

					// Si necesitas refrescar tabla/lista:
					location.reload();
				} else {

					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: response.message,
						confirmButtonColor: '#d33'
					});

					// desbloquear si hubo error
            		$btn.prop("disabled", false);

				}

				// Cerrar el modal al terminar la operación
				$('#modalEstadoview').modal('hide');

				
			},
			error: function(err) {
				console.error("Error en AJAX:", err); // Registro de error en consola
				alert("Ocurrió un error al guardar."); // Mensaje al usuario
			}
		});
	});

	function verMensaje(id,ida) {
		// console.log(id);
		// console.log(ida);
		// Abrir modal (usa jQuery para mantener el mismo comportamiento)

		$.ajax({
			url: "index.php?action=estadoAlumno&opt=getAll",
			type: 'POST',
			data: {
				opt: "getAll",
				id: id,
				ida:ida
			},
			dataType: 'json',
			success: function(response) {

				 if (!response || response.status !== 'success') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: response?.message || 'No se encontró información'
        });
        return;
    }

    // respuesta.data es un ARRAY de registros completos
    const registros = response.data || [];

    let html = "";

    registros.forEach(reg => {
        html += `
            <tr>
				<td>${reg.id}</td>
				<td>${reg.estado}</td>
				<td>${reg.usuario}</td>
				<td>${reg.fecha}</td>
				<td>
					<div class="mensaje-largo">
						${reg.mensaje}
					</div>
				</td>
			</tr>
        `;
    });

    // Ponerlo en la tabla del modal
    $("#tablaHistorial tbody").html(html);

    // Mostrar el modal
    $('#modalMensaje').modal('show');
			},
			error: function(err) {
				console.error("Error en AJAX:", err);
				Swal.fire({
					icon: 'error',
					title: 'Error de comunicación',
					text: 'Ocurrió un error al obtener el mensaje. Revisa la consola.'
				});
			}
		});
	}


// $(document).on("click", ".toggle-inline-submenu", function(e) {
//     e.preventDefault();

//     var submenu = $(this).next(".inline-submenu");
//     submenu.slideToggle(150);
// });

$(document).ready(function() {
    // Al cargar la página, cerrar todos los submenús
    $(".inline-submenu").hide();
});

// Evita que el dropdown principal se cierre al abrir el submenú
$(document).on("click", ".toggle-inline-submenu, .inline-submenu a", function (e) {
    e.stopPropagation();
});

// Mantiene el toggle del submenú funcionando
$(document).on("click", ".toggle-inline-submenu", function(e) {
    e.preventDefault();
    var submenu = $(this).next(".inline-submenu");
    submenu.slideToggle(150);
});

// Cierra submenús si se hace clic fuera
$(document).on("click", function() {
    $(".inline-submenu").slideUp(150);
});



$(document).ready(function () {

    var table = $('#tabladatatable').DataTable({
        ordering: false,
        pageLength: 10,
        stateSave: true // ✅ guarda búsqueda, página, etc.
    });

    // 🔥 Forzar redraw al cargar estado guardado
    table.draw();

    // 🔄 Redibujar cuando el usuario busca
    $('#tabladatatable_filter input').on('keyup change', function () {
        table.draw();
    });

});

</script>