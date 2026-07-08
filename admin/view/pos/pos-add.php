<html lang="en">
   <head>
     <meta charset="UTF-8">
     <meta name="viewport"
         content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>Caja Virtual</title>
     <link rel="icon" href="img/icon.png">
     <!-- Bootstrap 3.3.5 -->
     <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
     <!-- Font Awesome -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
     <!-- Select2 -->
     <link rel="stylesheet" href="plugins/select2/select2.min.css">
     <link href="bootstrap/custom-styles-POS/css/core.css" rel="stylesheet">
     <link href="bootstrap/custom-styles-POS/css/components.css" rel="stylesheet">
     <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
         <style>
         /* .widget-panel {
             padding: 10px !important;
             margin: 0px !important;
         }
         */
         /*tr {display: block; }*/
         th,
         td:first-child {
             width: 10px;
         }
           th,
         td:nth-child(2) {
             width: 150px;
         }
           #cartTable {
             display: block;
             height: 206px;
             overflow: auto;
         }
     </style>
   </head>
   <body>
     <style>
         .order-box {
             background-color: grey;
             color: #FFFFFF;
         }
     </style>
     <?php
     // if ($permisos_editar==1){        
     //include("modal/agregar_cliente.php");
     // }
     ?>
         <div class="container">
         <div id="resultados_ajax"></div>
         <!-- Page-Title -->
         <div class="row">
             <div class="col-sm-12">
                 <a href="index.php" class="btn btn-danger waves-effect waves-light m-t-15">
                     <span class="btn-label"><i class="fa fa-exclamation"></i></span>Inicio
                 </a>
             </div>
         </div>
         <br>
         <div class="row">
             <div class="col-md-7">
                 <div class="card-box">
                     <div class="row">
                         <div class="col-md-6">
                             <input type="text" id="q" class="form-control" placeholder="Buscar Productos"
                                 onkeyup="load(1)">
                         </div>
                         <div class="col-md-6">
                             <select onchange="load(1);" class="form-control" name="category_id" id="category_id">
                                 <option value="">Selecciona Cetegoria</option>
                                 <?php
                                 $query = mysqli_query($con, "SELECT id, name from categories ORDER BY name");
                                 while ($rw = mysqli_fetch_array($query)) {
                                     ?>
                                     <option value="<?php echo $rw['id']; ?>"><?php echo $rw['name']; ?></option>
                                     <?php
                                 }
                                 ?>
                             </select>
                         </div>
                     </div>
                     <hr>
                     <div class="row  outer_div" id="outer_div" style="height: 77%; overflow: scroll;"></div>
                 </div>
             </div>
             <div class="col-md-5">
                 <div class="card-box">
                     <div class="col-md-12">
                         <div class="col-md-10 mb-3">
                             <button type="button" class="btn btn-primary" onclick="mostrarSelect('alumno')">Alumnos</button>
                             <button type="button" class="btn btn-success" onclick="mostrarSelect('vinculacion')">Vinculación</button>
                             <br><br>
                         </div>
                        <div class="row">
                            <div class="col-md-10"  id="selectAlumno" style="display:none;">
                                    <select required class="form-control select2 " name="person_id" id="person_id"
                                        onchange="mostrar_productos_plan_pago()">
                                        <option value="default" selected>Selecciona Estudiante</option>
                                        <?php $sql_user = mysqli_query($con, "SELECT * FROM person");
                                        while ($rw = mysqli_fetch_array($sql_user)) {
                                            ?>
                                            <option value="<?php echo $rw['id'] ?>"><?php echo $rw['code'] . " - " . $rw['lastname'] . " " . $rw['name'] ?></option>
                                        <?php } ?>
                                    </select>
                            </div><br>
                            <div class="col-md-10"  id="selectVinculacion" style="display:none;">
                                    <select required class="form-control select2 " name="vinculacion_id" id="vinculacion_id"
                                        onchange="mostrar_productos_vinculacion()">
                                        <option value="default" selected>Centro de vinculación</option>
                                        <?php $sql_vinculacion = mysqli_query($con, "SELECT * FROM centro_vinculacion");
                                        while ($rw = mysqli_fetch_array($sql_vinculacion)) {
                                            ?>
                                            <option value="<?php echo $rw['id'] ?>"><?php echo $rw['name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <!-- <input type="text" class="form-control" name="sale_number" id="sale_number" required
                                value="<?php //echo nex_sale_number(); ?>"> -->
                        </div>
                     <div id="resultados" class=""></div>
                 </div>
             </div>
         </div>
     </div>
       <!--------------------------------------------------------  Modal content for the above example -------------------------------------------------->
       <style>
        .alerta-izquierda {
            display: none;
            position: fixed;
            top: 20px; /* Espacio desde la parte superior */
            left: -300px; /* Inicialmente fuera de la pantalla */
            background-color: #28a745; /* Verde bonito */
            color: white;
            padding: 20px 40px;
            border-radius: 10px;
            font-size: 18px;
            z-index: 9999;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: aparecerDesdeIzquierda 0.5s ease forwards;
        }

        .alerta-izquierda2 {
            display: none;
            position: fixed;
            top: 20px; /* Espacio desde la parte superior */
            left: -300px; /* Inicialmente fuera de la pantalla */
            background-color: #dc3545; /* rojo  */
            color: white;
            padding: 20px 40px;
            border-radius: 10px;
            font-size: 18px;
            z-index: 9999;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: aparecerDesdeIzquierda 0.5s ease forwards;
        }

        @keyframes aparecerDesdeIzquierda {
            from {
                left: -300px; /* Empieza fuera de la pantalla */
                opacity: 0;
            }
            to {
                left: 20px; /* Se mueve a la posición deseada */
                opacity: 1;
            }
        }
    </style>

    <div id="miAlerta" class="alerta-izquierda">
        ¡Acción realizada correctamente!
    </div>
    <div id="miAlerta2" class="alerta-izquierda2">
        ¡Uups. Algo paso, intentalo de nuevo!
    </div>

     <div id="paymentModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" style="display: none;">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     <h4 class="modal-title text-center" id="myLargeModalLabel">Pago</h4>
                 </div>
                 <div class="modal-body">
                     <div class="row">
                         <div class="col-md-12 col-xs-12">
                             <div class="input-group col-md-12 col-xs-12">
                                   <div class="col-md-6 col-xs-6">
                                     <span class="input-group-addon bg-danger" id="basic-addon3"
                                         style="color: #FFFFFF;">TOTAL $ </span>
                                     <input id="payablePrice" readonly type="text" class="form-control text-center"
                                         aria-describedby="basic-addon3" step="0.01">
                                 </div>
                                   <div class="col-md-6 col-xs-6">
                                     <span class="input-group-addon bg-danger" id="basic-addon3"
                                         style="color: #FFFFFF;">Pago $ </span>
                                     <input type="text" placeholder="0.0" class="form-control text-center" id="payment"
                                         aria-describedby="basic-addon3" oninput="$(this).calculateChange();">
                                 </div>
                               </div>
                             <hr>
                         </div>
                     </div>
                       <div class="row">
                         <div class="col-md-12 col-xs-12">
                                <div class="input-group col-md-12 col-xs-12">
                                    <div class="col-md-4 col-xs-4">
                                        <a href="javascript:void(0)" id="cash" onclick="paymentType(1);"
                                            class="list-group-item text-center active">EFECTIVO </a>
                                    </div>
                                        <div class="col-md-4 col-xs-4">
                                        <a href="javascript:void(0)" id="deposit" onclick="paymentType(2); "
                                            class="list-group-item text-center" handlePaymentMethod();>DEPOSITO</a>
                                            <input type="hidden" id="typeDocument" value="1">
                                    </div> 
                                    <div class="col-md-4 col-xs-4">
                                        <a href="javascript:void(0)" id="card" onclick="paymentType(3); "
                                            class="list-group-item text-center" handlePaymentMethod();>TARJETA </a>
                                        <input type="hidden" id="typeDocument" value="1">
                                    </div>
                                </div>
                                <br>
                                <div class="input-group col-md-12 col-xs-12">
                                    <label for="datepago" class="mb-2" style="font-size:12px; ">Fecha de pago correspondiente: </label>
                                    <input type="date" id="datepago" name="datepago" value="<?php echo date('Y-m-d'); ?>"
                                        style="width:100%; height:15px; font-size:18px; padding:10px; border-radius:3px;">
                                </div>

                             <hr>
                         </div>
                     </div>
                 </div>
                 <form method="post" name="save_sale" id="save_sale">
                     <div class="modal-footer">
                         <div class="btn btn-danger btn-block btn-lg waves-effect waves-light" id="cambio" >Cambio $<span
                                 id="change"></span> </div>
                         <button type="submit" id="confirmPayment"
                             class="btn btn-danger btn-block btn-lg waves-effect waves-light"
                             style="display: none;">Confirmar</button>
                     </div>
                 </form>
             </div><!-- /.modal-content -->
         </div><!-- /.modal-dialog -->
         <script>
        function handlePaymentMethod() {
            var tarjeta = document.getElementById("card");
            var deposito = document.getElementById("deposit");
            var efectivo = document.getElementById("cash");
            var paymentInput = document.getElementById("payment");
            var divCambio = document.getElementById("cambio");

            tarjeta.addEventListener("click", function() {
    if (tarjeta.classList.contains("active")) {
        paymentInput.value = document.getElementById("payablePrice").value;
        paymentInput.readOnly = true;
        $("#confirmPayment").show();
        divCambio.style.display = "none";
            }
        });

        deposito.addEventListener("click", function() {
    if (deposito.classList.contains("active")) {
        paymentInput.value = document.getElementById("payablePrice").value;
        paymentInput.readOnly = true;
        $("#confirmPayment").show();
        divCambio.style.display = "none";
            }
        });

        efectivo.addEventListener("click", function() {
            if (efectivo.classList.contains("active")) {
                paymentInput.value = "0.0";
                paymentInput.readOnly = false;
                divCambio.style.display = "block";
            }
        });
        }

        document.addEventListener("DOMContentLoaded", function() {
            handlePaymentMethod();
        });
    </script>
     </div><!-- /.modal -->
     <!-----------------------------------------------------FIN  Modal content for the above example -------------------------------------------------->
     <?php include("js.php"); ?>
     <script src="plugins/select2/select2.full.min.js"></script>
     <script src="plugins/daterangepicker/daterangepicker.js"></script>
     <script src="dist/js/VentanaCentrada.js"></script>
       <script>
         $('#alumno').selectpicker();
     </script>
     <script>
        function mostrarSelect(tipo) {
            // Ocultar ambos
            $("#selectAlumno, #selectVinculacion").hide();

            // Reiniciar selects
            $("#person_id").val("default").trigger("change");
            $("#vinculacion_id").val("default").trigger("change");

            // Mostrar el select correspondiente
            if (tipo === "alumno") {
                $("#selectAlumno").show();
                $('#person_id').select2({ width: '100%' }); // reinicializar
            } else {
                $("#selectVinculacion").show();
                $('#vinculacion_id').select2({ width: '100%' }); // reinicializar
            }
        }
     </script>
       <script>
         $(function () {
             //Initialize Select2
             $(".select2").select2();
             var taxes = $("#taxes").val();
             var descuento = $("#descuento").val();
             $("#resultados").load("./ajax/agregar_tmp_pos.php?tax=" + taxes + "&descuento=" + descuento);
             load(1);
           });

           function load(page) {
             var q = $("#q").val();
             var categoria = $("#category_id").val();
            
             if (categoria == '8') { //Este es el id de conceptos de vinculacion
                    // console.log('categoria 7');
                    
                 $.ajax({
                     url: './ajax/productos_ventas_vinculacion.php?action=ajax&page=' + page + '&q=' + q + '&categoria=' + categoria,
                     beforeSend: function (objeto) {
                         // $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
                     },
                     success: function (data) {
                         $(".outer_div").html(data);
                         //  $('#loader').html('');
                     }
                 })
             }else{

                 
                 $.ajax({
                     url: './ajax/productos_ventas_pos.php?action=ajax&page=' + page + '&q=' + q + '&categoria=' + categoria,
                     beforeSend: function (objeto) {
                         // $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
                     },
                     success: function (data) {
                         $(".outer_div").html(data);
                         //  $('#loader').html('');
                     }
                 })
             }
         }

  // Obtén la referencia al elemento de input
  const input = document.getElementById("payablePrice");
  
  // Obtén el valor actual del input
  const value = input.value;
  
  // Convierte el valor a un número de punto flotante
  const floatValue = parseFloat(value);
  
  // Verifica si el valor es un número válido
  if (!isNaN(floatValue)) {
    // Formatea el valor a pesos con 10 enteros y 2 decimales
    const formattedValue = floatValue.toLocaleString("es-AR", {
      style: "currency",
      currency: "ARS",
      minimumIntegerDigits: 10,
      minimumFractionDigits: 2
    });
    
    // Actualiza el valor del input con el formato deseado
    input.value = formattedValue;
  }
var productAdded = false; // Variable to track if a product has been added



function agregar(id, idPlan) {
    // if (productAdded) {
    //     // Display an error message or take appropriate action
    //     // alert("Solo puedes realizar un pago a la vez.")
    //     // return; // Exit the function
    // }
    
    var precio_venta = document.getElementById('precio_venta_' + id).value;
    var cantidad = document.getElementById('cantidad_' + id).value;
    var taxes = $("#taxes").val();
    var descuento = $("#descuento").val();
    var vinculacion = $("#vinculacion").val();
    // console.log({
    //     id:id,
    //     precio_venta: precio_venta,
    //     cantidad: cantidad,
    //     taxes: taxes,
    //     descuento: descuento,
    //     vinculacion: vinculacion,
    //     click: true
    // });

    // return
    $.ajax({
        type: "POST",
        url: "./ajax/agregar_tmp_pos.php",
        data: "id=" + id + "&id_plan=" + idPlan + "&precio_venta=" + precio_venta + "&cantidad=" + cantidad + "&tax=" + taxes + "&descuento=" + descuento + "&vinculacion=" + vinculacion,
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados").html(datos);
            verificar_beca_promocion_alumno($("#person_id").val(), id);
            // console.log(datos);
            
        }
    });
    
    productAdded = true; // Set the flag to indicate a product has been added
}
function resetearBandera() {
    productAdded = false; // Reset the flag to allow adding a new product
}

           function verificar_beca_promocion_alumno(id_alumno, id_producto) {
             parametros = {
                 'id_alumno': id_alumno,
                 'id_producto': id_producto
             }
             $.ajax({
                 data: parametros,
                 type: 'POST',
                 url: 'ajax/beca_promocion_planpago.php',
                 dataType: 'json',
                 success: function (data) {
                     var total = 0;
                     if (parseInt(data.beca) > 0) {
                         total += parseInt(data.beca)
                     }
                       if (parseInt(data.promo) > 0) {
                         total += parseInt(data.promo)
                     }
                    //  console.log("\n" + data + "\n")
                    //  console.log("El descuento de promocion es de: " + data.promo);
                    //  console.log("El descuento de beca es de: " + data.beca);
                    //  console.log("SQL: " + data.sql +"\n" +"SQL2: " + data.sql2);
                    //  console.log("Extra: " + data.extra);
                    if (id_alumno != "default") {
                        productAdded = true;
                    } else {
                        resetearBandera();
                    }

                        console.log("Extra: " + productAdded);
                     $("#descuento").attr("value", total);
                     $("#descuento").focus();
                     $("#descuento").blur();
                 },
                 error: function (response) {
                     console.log(response)
                 }
             })
         }
           function eliminar(id) {
             var taxes = $("#taxes").val();
             var descuento = $("#descuento").val();
             $.ajax({
                 type: "GET",
                 url: "./ajax/agregar_tmp_pos.php",
                 data: "id=" + id + "&tax=" + taxes + "&descuento=" + descuento,
                 beforeSend: function (objeto) {
                     $("#resultados").html("Mensaje: Cargando...");
                 },
                 success: function (datos) {
                     $("#resultados").html(datos);
                 }
             });
           }
           function update_sale(person_id) {
             $.ajax({
                 type: "POST",
                 url: "./ajax/agregar_venta.php",
                 data: "person_id=" + person_id,
                 success: function (datos) {
                     $("#resultados").html(datos);
                 }
             });
         }

        $("#save_sale").submit(function (event) {
            event.preventDefault();

            var person_id_val = $("#person_id").val(); //id para obtener los datos de la persona
            var vinculacion_id_val  = $("#vinculacion_id").val(); //id para obtener los datos de la persona
            var datepago  = $("#datepago").val(); //id para obtener fecha del modal de pago
            
            // console.log(datepago);
            
            // return

            // Caso 3: Ambos llenos y distintos de "default"
            if (person_id_val !== "" && person_id_val !== "default" &&
                vinculacion_id_val !== "" && vinculacion_id_val !== "default") {
                
                alert("Tienes seleccionado a un alumno y una vinculación. Por favor, cambia uno a 'Selecciona'.");
                return; // detener ejecución para que no continúe
            }

            // Caso 1: person_id es "default"
            if (person_id_val === "default" && vinculacion_id_val !== "" && vinculacion_id_val !== "default") {
                person_id = vinculacion_id_val;
                vinculacion = "SI";
            }

            // Caso 2: person_id válido y vinculacion_id vacío o "default"
            else if (person_id_val !== "" && person_id_val !== "default" &&
                    (vinculacion_id_val === "" || vinculacion_id_val === "default")) {
                        person_id = person_id_val; // se mantiene igual, pero aquí podrías hacer lógica extra si necesitas
                        vinculacion = "NO";
            }

            if (
                (person_id_val === undefined || person_id_val === null || person_id_val === '' || person_id_val === 'default') &&
                (vinculacion_id_val === undefined || vinculacion_id_val === null || vinculacion_id_val === '' || vinculacion_id_val === 'default')
            ) {
                alert('Selecciona un estudiante o una vinculación');
                
                // Resetea ambos para forzar selección
                $("#person_id").val("default");
                $("#vinculacion_id").val("default");
                
                $("#person_id").focus();
                return false;
            }
            var descuento = $("#descuento").val();
            var taxes = $("#taxes").val();
            var typeDocument = $('#typeDocument').val();
            var total = $("#payablePrice").val(); /* total */
            var pago = $("#payment").val(); /* pagar */
            var recargo = $("#recargo").val(); /* Recargos */

            // console.log("person_id: ", person_id);
            // console.log("descuento: ", descuento);
            // console.log("taxes: ", taxes);
            // console.log("typeDocument: ", typeDocument);
            // console.log("total: ", total);
            // console.log("pago: ", pago);
            // console.log("recargo: ", recargo);
            // console.log("vinculacion: ", vinculacion);
            // console.log("datepago: ", datepago);

            

            // if (person_id === undefined || person_id === null || person_id === '' || person_id === 'default' ) {
            //     alert('Selecciona un estudiante');
            //     $("#person_id").val("");
            //     $("#person_id").focus();
            //     return false;
            // }

            // Crear el objeto de datos para enviar
            var datos = {
                person_id: person_id,
                descuento: descuento,
                taxes: taxes,
                payment_method: typeDocument,  // Asegúrate de que 'typeDocument' sea lo que realmente esperas
                total: total,
                payment: pago,
                recargo: recargo,
                vinculacion: vinculacion,
                datepago:datepago
            };

            $.ajax({
                type: "POST",
                url: "add_sale.php",
                data: JSON.stringify(datos),  // Asegúrate de enviar los datos como JSON
                contentType: "application/json",  // Especifica que el contenido es JSON
                dataType: 'json',
                success: function(response) {
                    // console.log("response", response); //mUESTRAS LOS ERRORES GRACIAS A LAS EXCEPTTIONES de cualquier pago en pos
                    // return
                    // Revisa si el status es "ok" o "error"
                    if (response.status === "ok") {
                        const alerta = document.getElementById('miAlerta');
                        alerta.innerHTML = response.message;
                        alerta.style.display = 'block';

                        // Se oculta después de 5 segundos
                        setTimeout(() => {
                            alerta.style.display = 'none';
                        }, 3000);

                        
                        // Abre la ventana centrada para el PDF
                        VentanaCentrada(
                            'new-sale-ticket-pdf.php?person_id=' + person_id +
                            '&tax=' + taxes +
                            '&descuento=' + descuento +
                            '&payment_method=' + typeDocument +
                            '&payablePrice=' + total +
                            '&payment=' + pago +
                            '&recargo=' + recargo +
                            '&vinculacion=' + vinculacion +
                            '&datepago=' + datepago +
                            '&sale_id=' + response.sale_id,
                            'Nueva factura',
                            '',
                            '1024',
                            '768',
                            'true'
                        );

                        // Recarga la página después de un pequeño retraso (500ms)
                        setTimeout(() => {
                            location.reload(); // Recarga la página
                        }, 3000); // Asegúrate de que el retraso sea suficiente para que la ventana del PDF se haya abierto

                        // Resetea ambos para forzar selección
                        $("#person_id").val("default");
                        $("#vinculacion_id").val("default");
                    } else {
                        const alerta = document.getElementById('miAlerta2');
                        alerta.innerHTML = "Error: " + response.message;  // Mensaje de error
                        alerta.style.display = 'block';

                        // Se oculta después de 5 segundos
                        setTimeout(() => {
                            alerta.style.display = 'none';
                        }, 4000);
                        // console.log("Error General: " + response.message); Muestra el error en las exceptiones al finalizar proceso
                        
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert('Ocurrió un error al guardar la venta.');
                }
            });
        });

     </script>
       <script>
         function tax_value(value) {
             var descuento = $("#descuento").val();
             var recargo = $("#recargo").val();
             $("#resultados").load("./ajax/agregar_tmp_pos.php?tax=" + value + "&descuento=" + descuento + "&recargo=" + recargo);
         }
     </script>
     <script>
         function descuento(value) {
             var taxes = $("#taxes").val();
             var recargo = $("#recargo").val();
             $("#resultados").load("./ajax/agregar_tmp_pos.php?descuento=" + value + "&tax=" + taxes + "&recargo=" + recargo);
             $("#descuento").val(value);
         }
           function updateCant(value, idproducto) {
                var taxes = $("#taxes").val();
                var recargo = $("#recargo").val();
                var descuento = $("#descuento").val();
                var vinculacion = $("#vinculacion").val();
             $("#resultados").load("./ajax/agregar_tmp_pos.php?cantidad=" + value + "&idproducto=" + idproducto + "&tax=" + taxes + "&descuento=" + descuento +
                                         "&recargo=" + recargo + "&vinculacion=" + vinculacion);
           }

            function recargo(value) {
                var taxes = $("#taxes").val();
                var descuento = $("#descuento").val();
             $("#resultados").load("./ajax/agregar_tmp_pos.php?recargo=" + value + "&tax=" + taxes + "&descuento=" + descuento);
             $("#descuento").val(value);
         }
     </script>
     <script>
         function modalPago(value) {
               var totalModal = $("#payablePrice").val(value);
           }
             function paymentType(payment) {
             var paymentType = 1;
               switch (payment) {
                 case 1:
                     $('#cash').addClass('active');
                     $('#deposit').removeClass('active');
                     $('#card').removeClass('active');
                     paymentType = 1;
                     //console.log(paymentType);
                     break;
                 case 2:
                     $('#deposit').addClass('active');
                     $('#cash').removeClass('active');
                     $('#card').removeClass('active');
                     // console.log(paymentType);
                     paymentType = 2;
                     // console.log(paymentType);
                     break;
                   case 3:
                     $('#card').addClass('active');
                     $('#cash').removeClass('active');
                     $('#deposit').removeClass('active');
                     

                     // console.log(paymentType);
                     paymentType = 3;
                     // console.log(paymentType);
                     break;
             }
               type = $('#typeDocument').val(paymentType);
         }


     </script>
       <script>
         $.fn.calculateChange = function () {
             var change = $("#payment").val() - $("#payablePrice").val();
             if (change <= 0) {
                 $("#change").text('No debe darse cambio');
             } else {
                 $("#change").text(change.toFixed(2));
             }
             if (change <= 0) {
                 $("#confirmPayment").show();
             } else {
                 $("#confirmPayment").show();
             }
         }
     </script>
   </body>
   </html>
 <script>
     function mostrar_productos_plan_pago() {

         var id = $("#person_id").val();
         if (id === "default") {
             load(1)
         } else {
             var params = { "id_estudiante": id }
             var page = 15;
             var q = $("#q").val();
             var categoria = $("#category_id").val();
             $.ajax({
                 data: params,
                 type: "ajax",
                 url: './ajax/productos_ventas_pos.php?action=ajax&page=' + page + '&q=' + q + '&categoria=' + categoria + '&id_estudiante=' + id,
                 beforeSend: function (objeto) {
                     $("#outer_div").html("");
                     // $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
                 },
                 success: function (data) {
                     $(".outer_div").html(data);
                     //$("#outer_div").html(data);
                     //console.log(data)
                     //  $('#loader').html('');
                 },
                 error: function (response) {
                     //console.log(JSON.stringify(response));
                 },
             })
         }
     }

    function mostrar_productos_vinculacion() {

        var id = $("#vinculacion_id").val();
        console.log(id);
        // return
        if (id === "default") {
            load(1)
        } else {
            var params = { "id_vinculacion": id }
            var page = 15;
            var q = $("#q").val();
            var categoria = $("#category_id").val();
            $.ajax({
                data: params,
                type: "ajax",
                url: './ajax/productos_ventas_vinculacion.php?action=ajax&page=' + page + '&q=' + q + '&categoria=' + categoria + '&id_vinculacion=' + id,
                beforeSend: function (objeto) {
                    $("#outer_div").html("");
                    // $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
                },
                success: function (data) {
                    $(".outer_div").html(data);
                    //$("#outer_div").html(data);
                    //console.log(data)
                    //  $('#loader').html('');
                },
                error: function (response) {
                    //console.log(JSON.stringify(response));
                },
            })
        }
    }
</script>
