<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all") : 
  include "modals/modal_cargosAdd.php";  
  include "modals/modal_cargosAddEdit.php";  
?>
  <div class="row">
    <div class="col-md-12">
      <h1>Recargos</h1>
      <!-- <a href="./?view=recargos&opt=new" class="btn btn-default"><i class='fa fa-th-list'></i> Nuevo Recargo</a> -->
      <button id="ShowModalRecargosAdd" class="btn btn-success">Nuevo Recargo</button>
      <br>
      <?php

      $teams = Recargos::getAll();
      if (count($teams) > 0) {
        // si hay usuarios
      ?>
        <div class="box box-primary">
          <div class="box-body">
            <table id="tableRecargosAll" class="table table-bordered  table-hover ">
              <thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Porcentaje</th>
                <th>fecha Inicio</th>
                <th>Fecha_fin</th>
                <th>Intervalo</th>
                <th>Acciones</th>
              </thead>
              <?php
              foreach ($teams as $team) {
              ?>
                <tr>
                  <td><?php echo $team->id; ?></td>
                  <td><?php echo $team->nombre; ?></td>
                  <td> <?php echo $team->descripcion; ?></td>
                  <td> <?php echo $team->fecha_inicio; ?></td>
                  <td> <?php echo $team->fecha_fin; ?></td>
                  <td> <?php echo $team->intervalos . " Dias"; ?></td>

                  <td style="width:130px;"> 
                      <a class="btn btn-warning btn-xs" id="showModalRecargosEdit"  
                          data-id="<?php echo $team->id; ?>">Editar</a>
                      
                      <a href="index.php?action=recargos&opt=delete&id=<?php echo $team->id; ?>" 
                        class="btn btn-danger btn-xs eliminar-btn">
                        Eliminar
                      </a>
                  </td>
                </tr>
            <?php
              }
              echo "</table></div></div>";
            } else {
              echo "<p class='alert alert-danger'>No hay recargos</p>";
            }
            ?>
          </div>
        </div>
      
      
        
      <?php endif; ?>

      <script>

        
        $(document).ready(function() {
          $('#tableRecargosAll').DataTable({
            ordering: false,
            // pageLength: 100
          });
        });

        //Hacer clic en el bootn de Nuevo Recargo abrimos modal
        document.getElementById("ShowModalRecargosAdd").addEventListener("click", (e) => {
          e.preventDefault(); // Evita recargar la página

         
          //Abrimos modal
          $("#modal_nuevoCargo").modal('show');
        })

        // Cerrar modal y limpiar campos
        document.getElementById("cancelarRecargoAdd").addEventListener("click", () => {
            document.getElementById("FormRecargoAdd").reset(); // limpia todos los campos
            $('#modal_nuevoCargo').modal('hide'); // cierra el modal
            document.getElementById("errorMessage").textContent = ''; // limpia mensajes de error si los hay
        });


        //Abrimos y cerramos modal edit ------------------------------------------------------------------------------------
        $(document).on("click", "#showModalRecargosEdit", async function(e) {
          e.preventDefault();
           
         const id = $(this).data("id");
          // console.log(id);
          // return
          
          try {
            const response = await fetch(`index.php?action=recargos&opt=getById&id=${id}`);
            const data = await response.json(); 

            console.log(data);

            // Rellenar los campos del modal
            $("#idEdit").val(data.id);
            $("#nombreEdit").val(data.nombre);
            $("#descripcionEdit").val(data.descripcion);
            $("#fecha_inicioEdit").val(data.fecha_inicio);
            $("#fecha_finEdit").val(data.fecha_fin);
            

          } catch (error) {
            console.error("Error al obtener los datos:", error);
          }
            //Abrimos modal
            $("#modal_editRecargo").modal('show');
        })



        // Cerrar modal y limpiar campos edit
        document.getElementById("Edit_recargoCancelar").addEventListener("click", () => {
            document.getElementById("FormRecargoEdit").reset(); // limpia todos los campos
            $('#modal_editRecargo').modal('hide'); // cierra el modal
            document.getElementById("errorMessage").textContent = ''; // limpia mensajes de error si los hay
        });



        
        document.getElementById("cancelarRecargoAdd")
        //Al prcesar el formulario
        document.getElementById("FormRecargoAdd").addEventListener("submit", async (e) => {
           e.preventDefault(); // Evita recargar la página
          
          //Informacion capturada
          const data = {
            nombre: document.getElementById("nombre").value,
            descripcion: document.getElementById("descripcion").value,
            fecha_inicio: document.getElementById("fecha_inicio").value,
            fecha_fin: document.getElementById("fecha_fin").value,
          }

          //Procesamos el envio de datos
          try {
            const response = await fetch("index.php?action=recargos&opt=add", {
              method: 'POST',
              headers: {
                "Content-Type": "application/json"
              },
              body: JSON.stringify(data)
            });
            const result = await response.json();
            console.log("Respuesta del backend:", result);
            console.log("Entro al click");
            // Mostrar respuesta con SweetAlert2
            if (result.success) {
              Swal.fire({
                  icon: "success",
                  title: "¡Operación exitosa!",
                  text: result.message,
                  showConfirmButton: false,
                  timer: 3000
              });

              $('#modal_nuevoCargo').modal('hide');
              document.getElementById("FormRecargoAdd").reset(); // limpia inputs

              setTimeout(() => {
                  location.reload();
              }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: result.message,
                    confirmButtonText: "Aceptar"
                });
            }

            // Limpiar formulario
            document.getElementById("FormRecargoAdd").reset();
          } catch (error) {
              console.error("Error al enviar datos:", error);
              Swal.fire("Error", "Ocurrió un error al enviar datos", "error");
          }


        })


        document.getElementById("Actualizar").addEventListener("click", async function (e) {
            e.preventDefault();

            // Obtener valores
            const edit_id = document.getElementById("idEdit").value.trim();
            const edit_name = document.getElementById("nombreEdit").value.trim();
            const edit_descripcion = document.getElementById("descripcionEdit").value.trim();
            const fecha_inicioEdit = document.getElementById("fecha_inicioEdit").value.trim();
            const fecha_finEdit = document.getElementById("fecha_finEdit").value.trim();
           
            // Validar
            if (!edit_name || !edit_descripcion || !fecha_inicioEdit || !fecha_finEdit) {
            document.getElementById("errorMessageedit").innerText = "LLena todos los campos.";
            setTimeout(() => document.getElementById("errorMessageedit").innerText = "", 5000);
            return;
            }

            // Preparar datos
            const formData = new FormData();
            formData.append("edit_id", edit_id);
            formData.append("edit_name", edit_name);
            formData.append("edit_descripcion", edit_descripcion);
            formData.append("fecha_inicioEdit", fecha_inicioEdit);
            formData.append("fecha_finEdit", fecha_finEdit);

            try {
              // Enviar al backend por fetch
              const response = await fetch("index.php?action=recargos&opt=upd", {
                method: "POST",
                body: formData
              });


              const data = await response.json();
              console.log("dATA: " , data);
              
              if (data.success) {
                Swal.fire({
                  icon: "success",
                  title: "¡Actualizado!",
                  text: data.message,
                  showConfirmButton: false,
                  timer: 2000
                });

                // Cerrar modal y limpiar formulario
                document.getElementById("FormRecargoEdit").reset();
                $('#modal_editRecargo').modal('hide');

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
                      text: "Esta accion eliminara el recargo por completo.",
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