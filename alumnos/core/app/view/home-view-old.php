<?php
$inscription = InscriptionData::getActive($_SESSION["alumn_id"]);
?>

<html lang="es">
 <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/images/aguila_dorada.ico" />  
<section class="content-header">

      <h1> <img src="../storage/posts/visherbot1.png"  width="52px"> Te saludo <?php if (isset($_SESSION["alumn_id"])) {
                    echo PersonData::getById($_SESSION["alumn_id"])->name;
                    $id = $_SESSION["alumn_id"];
                    $con = Database::getCon();
                    $query = mysqli_query($con,"SELECT * FROM person, becas WHERE person.beca=becas.id AND person.id=$id");
                    $data = mysqli_fetch_array($query);
                    $name = $data['name'];
                    $query = mysqli_query($con,"SELECT * FROM person, becas WHERE person.promocion=becas.id AND person.id=$id");
                    $data = mysqli_fetch_array($query);
                    $namepromo = $data['name'];
                
                    } ?>
  

               !<br>
               <small><Strong>Bienvenido(a) al Portal Estudiantil</Strong></small>
               <small>Version 4.0</small></h1>
               <!--<small>Beca: <?php echo $name; ?></small>
                <small>Promocion inscripción: <?php echo $namepromo; ?> </small>-->
            </h1>


</section>
<br>

<section class="content">
<div class="row">
	<div class="col-md-12">
		<div class="row">
        <!-- ./col -->

        <!-- Nuevo Modulo -->
        
        <div class="col-xl-3 col-sm-6 mb-xl-5 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-3xl icon-shape bg-gradient-marron shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">notifications_none</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-5xl mb-0 text-capitalize">Avisos</p>
                    <img src="../storage/posts/campana-de-notificacion.png" width="64px" style="opacity: 0.3;position: absolute;top: 45px;left: 50%;">
                    <h4 class="mb-0"><?php echo count(PostData::getAllByQ("where kind_pub=1 and (kind=1 or kind=4)"));?></h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <a href="./?view=news" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>
                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"> </span>Crea Avisos para Usuarios</p>
            </div>
        </div>
        </div>
        <!-- Hasta aqui -->
        
        <div class="col-xl-3 col-sm-6 mb-xl-5 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-3xl icon-shape bg-gradient-blue shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">library_books</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-5xl mb-0 text-capitalize">Asignaturas</p>
                    <img src="../storage/posts/biblioteca.png" width="64px" style="opacity: 0.3;position: absolute;top: 45px;left: 50%;">
                    <!--<h4 class="mb-0"><?php echo count(AsignatureData::getAll("where kind ==2"));?></h4>-->
                    <h4 class="mb-0" style="color: #FFFFFF;">.</h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <a href="./?view=kardexhistory" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>
                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"> </span>Consulta las Asignaturas Cursadas</p>
            </div>
        </div>
        </div>        
       
        <div class="col-xl-3 col-sm-6 mb-xl-5 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-3xl icon-shape bg-gradient-warning shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">school</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-5xl mb-0 text-capitalize">Ver Calificaciones </p>
                    <img src="../storage/posts/examen.png" width="64px" style="opacity: 0.3;position: absolute;top: 45px;left: 50%;">
                    <h4 class="mb-0" style="color: #FFFFFF;">.</h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <a href="./index.php?view=alumnhistory&id=<?php if(isset($_SESSION["alumn_id"]) ){ echo PersonData::getById($_SESSION["alumn_id"])->id; }?>" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>
                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"> </span>Muestra las Calificaciones Desglosadas por Ciclo Escolar</p>
            </div>
        </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-5 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-3xl icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">folder</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-5xl mb-0 text-capitalize"><small>Mi Expediente Digital</small></p>
                    <img src="../storage/posts/expediente.png" width="64px" style="opacity: 0.3;position: absolute;top: 45px;left: 50%;">
                    <h4 class="mb-0" style="color: #FFFFFF;">.</h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <a href="index.php?view=edituser&id=<?php if (isset($_SESSION["alumn_id"])) {
                                                            echo PersonData::getById($_SESSION["alumn_id"])->id;
                                                          } ?>" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>
                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"> </span>En este espacio deberás cargar tu documentación oficial.</p>
            </div>
        </div>
        </div>
<!--
        <div class="col-xl-3 col-sm-6 mb-xl-5 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-3xl icon-shape bg-gradient-success shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">free_cancellation</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-3xl mb-0 text-capitalize">Documentos para el Estudiante</p>
                    <img src="../storage/posts/contrato.png" width="64px" style="opacity: 0.3;position: absolute;top: 45px;left: 50%;">
                    <h4 class="mb-0">.</h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <a href="./index.php?view=contenedor_estudiantes" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>
                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"> </span>- Documentación emitida por Servicios Escolares.<br>- Aplica para todos los niveles educativos. </p>
            </div>
        </div>
        </div>
    -->    
        <div class="col-xl-3 col-sm-6 mb-xl-5 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-3xl icon-shape bg-gradient-danger shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">credit_card</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-5xl mb-0 text-capitalize">Estado de Cuenta</p>
                    <img src="../storage/posts/tarjeta.png" width="64px" style="opacity: 0.3;position: absolute;top: 45px;left: 50%;">
                    <h4 class="mb-0" style="color: #FFFFFF;">.</h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                
                <p class="mb-0"><span class="text-success text-sm font-weight-bolder">
                </span>
                - Consulta tu Historial de Cuenta. <br>
                - Realiza el pago de tus servicios académicos con tarjeta.<br>
                <p>- Aceptamos:
                            <img src="../storage/posts/visa.png"  width="20px">
                            <img src="../storage/posts/mastercard.png"  width="20px">
                            <img src="../storage/posts/american-express.png"  width="20px">
                        </p>
                        <a href="./?view=pagos&code=<?php if (isset($_SESSION["alumn_id"])) {
                                                    echo PersonData::getById($_SESSION["alumn_id"])->code;
                        } ?>" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>
                </p>
            </div>
        </div>
        </div>
        
        <div class="col-xl-3 col-sm-6 mb-xl-5 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-3xl icon-shape bg-gradient-blue shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">credit_score</i>
                    

                </div>
                <div class="text-end pt-1">
                    <p class="text-5xl mb-0 text-capitalize">Pago PayPal</p>
                    <img src="../storage/posts/paypal.png" width="64px" style="opacity: 0.3;position: absolute;top: 45px;left: 50%;">
                    <h4 class="mb-0" style="color: #FFFFFF;">.</h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                
                <p class="mb-0"><span class="text-success text-sm font-weight-bolder"> 
                </span>
                - Realiza el pago de tus servicios académicos por PayPal.<br>
                - No olvides enviar tu comprobante a ingresos@iemueem.edu.mx<br>

                </p>
                <a href="https://www.paypal.com/mx/digital-wallet/send-receive-money/paypal-me" target="_blank" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        </div> 
        
        
        <!-- <div class="col-xl-3 col-sm-6 mb-xl-5 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-3xl icon-shape bg-gradient-grey shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">picture_as_pdf</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-5xl mb-0 text-capitalize">Solicitud de Factura</p>
                        <img src="../storage/posts/factura.png" width="64px" style="opacity: 0.3;position: absolute;top: 45px;left: 50%;">
                        <h4 class="mb-0" style="color: #FFFFFF;">.</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    
                    <p class="mb-0"><span class="text-success text-sm font-weight-bolder"> 
                    </span>
                    - Si requieres factura por favor solicítala en este espacio.<br>
                    - Las facturas demorarán 72 hrs en ser emitidas.<br>
                    - Sólo se podrán emitir facturas en el mes de pago.<br>
                    - Se requiere la Constancia de Situación Fiscal.<br>
                    </p>
                    <a href="#" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>  -->


        <!-- <div class="col-xl-3 col-sm-6 mb-xl-5 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-3xl icon-shape shadow-dark text-center border-radius-xl mt-n4 position-absolute" style="background-color: #d2a12a;">
                        <i class="material-icons opacity-10">folder</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-5xl mb-0 text-capitalize"><small>Mi Expediente IEM</small></p>
                        <img src="../storage/posts/aguila_dorada.png" width="100px" style="opacity: 0.3;position: absolute;top: 45px;left: 50%;">
                        <h4 class="mb-0" style="color: #FFFFFF;">.</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <a href="" class="small-box-footer">Ir <i class="fa fa-arrow-circle-right"></i></a>
                    <p class="mb-0"><span class="text-success text-sm font-weight-bolder"> </span>
                    En este espacio descarga tu Documentación Oficial IEM<br>
                    - Certificado Total de Estudios - Autenticado <br>
                    - Título Digital - Autenticado<br>
                    - Constancia de Digitalización - DGP
                    </p>
                </div>
            </div>
        </div> -->

        
        
        </div>        
		</div>	  
	</div>	  
</div>		  
</section>		  
		  


