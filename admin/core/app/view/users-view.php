<div class="row">
	<div class="col-md-12">
		<h1>Lista de Usuarios</h1>
		
		<a href="index.php?view=newuser" class="btn bg-gradient-secondary btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tooltip on bottom" data-container="body" data-animation="true">
        <i class='glyphicon glyphicon-user'></i> Nuevo Usuario
        </a>


		<br><br>
		<?php
		/*
		$u = new UserData();
		print_r($u);
		$u->name = "Agustin";
		$u->lastname = "Ramos";
		$u->email = "evilnapsis@gmail.com";
		$u->password = sha1(md5("l00lapal00za"));
		$u->add();


		$f = $u->createForm();
		print_r($f);
		echo $f->label("name")." ".$f->render("name");
		*/
		?>
		<?php

		$users = UserData::getAll();
		if (count($users) > 0) {
			// si hay usuarios
		?>
			<div class="box box-primary">
				<div class="box-body">
					<table class="table table-bordered table-hover">
						<thead>
						    <th>No.</th>
							<th>Nombre completo</th>
							<th>Nombre de usuario</th>
							<th>Email</th>
							<th>Tipo</th>
							<th>Activo</th>
							<th></th>
						</thead>
						<?php
						foreach ($users as $user) {
							$nombreRoles = Permisos::nombreRoles($user->kind);
						?>
							<tr>
							    <td><?php echo $user->id; ?></td>
								<td><?php echo $user->name . " " . $user->lastname; ?></td>
								<td><?php echo $user->username; ?></td>
								<td><?php echo $user->email; ?></td>
								<td>
									<?php echo $nombreRoles; ?>

								</td>
								<td>
									<?php if ($user->is_active) : ?>
										<i class="glyphicon glyphicon-ok"></i>
									<?php endif; ?>
								</td>

								<td style="width:250px;">
									<!-- <a href="index.php?view=editpermisos&id=<?php //echo $user->id; ?>" class="btn btn-info btn-xs">Permisos</a> -->
									<a href="index.php?view=edituser&id=<?php echo $user->id; ?>" class="btn btn-warning btn-xs">Editar</a>
									<a href="index.php?action=deluser&id=<?php echo $user->id; ?>" class="btn btn-danger btn-xs">Eliminar</a>
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