<?php

    $sale_number=intval($_GET['id']);
    $_SESSION['sale_id']=$sale_number;
    $sql_sale=mysqli_query($con,"select * from sales where sale_id='".$_SESSION['sale_id']."'");
    $count=mysqli_num_rows($sql_sale);
    $rw_sale=mysqli_fetch_array($sql_sale);
    $sale_number=$rw_sale['sale_number'];
    $customer_id=$rw_sale['customer_id'];
    $descuento = $rw_sale['discount_value'];
    $paymentType = $rw_sale['payment_method'];
    $sale_date= date('d/m/Y', strtotime($rw_sale['sale_date']));
    
    if (!isset($_GET['id']) or $count!=1){
        header("location: manage_invoice.php");
    }
    
    
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>POS-EDIT</title>
    <link rel="icon" href="img/icon.png">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <link href="bootstrap/custom-styles-POS/css/core.css" rel="stylesheet">
    <link href="bootstrap/custom-styles-POS/css/components.css" rel="stylesheet"> 

   
    <style>
       /* .widget-panel {
            padding: 10px !important;
            margin: 0px !important;
        }
*/
      /*tr {display: block; }*/
        th, td:fi
        rst-child{ width: 10px; }
        th, td:nth-child(2){ width: 150px; }
        #cartTable  { display: block; height: 356px; overflow: auto;}

        


    </style>

</head>
<body>
<style>
    .order-box{
        background-color: grey;
        color: #FFFFFF;
    }
</style>    
    <?php 
       // if ($permisos_editar==1){        
        include("modal/agregar_cliente.php");
       // }
    ?>


<div class="container"> 
<input type="hidden" class="form-control" name="descuento" id="descuento" required value="<?php echo $descuento;?>" >   
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            

            <a href="manage_invoice.php"  
               class="btn btn-info waves-effect waves-light m-t-15">
                <span class="btn-label"><i class="fa fa-exclamation"></i></span>Todas las ventas
            </a>            

        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <div class="card-box">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-10">
                            <select required class="form-control select2 " name="customer_id" id="customer_id" onchange="return update_sale(1,this.value);">
                               <option value="">Selecciona Cliente</option>
                                    <?php 
                                        $sql_supplier=mysqli_query($con,"select id, name from customers order by name");
                                        while ($rw=mysqli_fetch_array($sql_supplier)){
                                            if ($customer_id==$rw['id']){$selected="selected";}
                                            else{$selected="";}
                                    ?>
                                <option value="<?php echo $rw['id'];?>" <?php echo $selected;?>><?php echo $rw['name'];?></option>
                                    <?php
                                        }
                                    ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button data-toggle="modal" data-target="#cliente_modal" class="btn btn-success"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" name="sale_number" id="sale_number" required value="<?php echo $sale_number;?>" >
                    <div class="input-group m-t-5 col-md-12">

                        <form id="barcode_form" method> 
                                    <!-- <hr> -->
                                         <div class="col-md-2">
                                            <input class='form-control' type='text' name='barcode_qty' id='barcode_qty'  value='1' required>
                                         </div> 
                                         
                                         <div class="col-md-10">
                                            <div class="input-group">
                                                    <input class='form-control' type='text' name='barcode' id='barcode' required placeholder="Ingresa el código de barras">
                                                    <span class="input-group-btn">
                                                        <button class="btn " style="height: 38px" type="submit" ><i class='fa fa-barcode'></i> </button>
                                                    </span>
                                            </div>
                                         </div>     
                                    </form>                     
                    </div>
                </div>

                <div id="resultados" class="">
                    
                </div>

              
            </div>
        </div>
        <div class="col-md-8">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" id="q" class="form-control" placeholder="Buscar Productos" onkeyup="load(1)">
                    </div>
                    <div class="col-md-6">
                        <select  onchange="load(1);" class="form-control" name="category_id" id="category_id" >
                                <option value="">Selecciona Departamento</option>
                                <?php
                                    $query=mysqli_query($con,"select id, name from categories order by name");
                                     while ($rw=mysqli_fetch_array($query)){
                                ?>
                                <option value="<?php echo $rw['id'];?>"><?php echo $rw['name'];?></option>
                                <?php
                                    }   
                                ?>  
                        </select>
                       
                    </div>
                </div>
                <hr>
                <div class="row  outer_div" id="outer_div" style="height: 600px; overflow: scroll;">                   
                </div>

            </div>
        </div>
    </div>
</div>

<!--  Modal content for the above example -->
<div id="paymentModel" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">    
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Pago</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="list-group">                              

                            
                            <a href="javascript:void(0)" id="cash" onclick="paymentType(1);" class="list-group-item">
                                Efectivo
                            </a>                        
                           
                            <a href="javascript:void(0)" id="check" onclick="paymentType(2); " class="list-group-item">Cheque</a>
                            <a href="javascript:void(0)" id="card" onclick="paymentType(3);" class="list-group-item">Tarjeta</a>
                            <input type="hidden" id="typeDocument" onchange="update_sale_payment(this.value)" value="<?php echo $paymentType;?>">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon3">Precio $ </span>
                            <input id="payablePrice" readonly type="text"  class="form-control" aria-describedby="basic-addon3">
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon3">Pago  $ </span>
                            <input type="text" placeholder="0.0" class="form-control" id="payment" aria-describedby="basic-addon3" oninput="$(this).calculateChange();">
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-3">
                                        <button onclick="$(this).go(1,false);" class="btn btn-success btn-lg btn-block">1</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button onclick="$(this).go(2,false);" class="btn btn-success btn-lg btn-block">2</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button onclick="$(this).go(3,false);" class="btn btn-success btn-lg btn-block">3</button>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <button onclick="$(this).go(4,false);" class="btn btn-success btn-lg btn-block">4</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button onclick="$(this).go(5,false);" class="btn btn-success btn-lg btn-block">5</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button onclick="$(this).go(6,false);" class="btn btn-success btn-lg btn-block">6</button>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <button onclick="$(this).go(7,false);" class="btn btn-success btn-lg btn-block">7</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="input" onclick="$(this).go(8,false);" class="btn btn-success btn-lg btn-block">8</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button onclick="$(this).go(9,false);" class="btn btn-success btn-lg btn-block">9</button>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <button onclick="$('#payment').val($('#payment').val().substr(0,$('#payment').val().length -1));$(this).calculateChange();" class="btn btn-success btn-lg btn-block">Corregir</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button onclick="$(this).go(0,false);" class="btn btn-success btn-lg btn-block">0</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button onclick="$(this).digits()" class="btn btn-success btn-lg btn-block">.</button>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button onclick="$('#payment').val('');$(this).calculateChange();" class="btn btn-danger btn-block btn-lg">AC</button>                             
                            </div>
                        </div>
                        <br>
                        
                    </div>
                </div>
            </div>
    <form  method="post" name="save_sale" id="save_sale">
            <div class="modal-footer">
                <div  class="btn btn-primary btn-block btn-lg waves-effect waves-light">Cambio $<span id="change"></span> </div>
                <button type="submit" id="confirmPayment" onclick="comfirmEdit();" class="btn btn-primary btn-block btn-lg waves-effect waves-light" style="display: none;">Confirmar</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    
    
    </div><!-- /.modal-dialog -->

    
</div><!-- /.modal -->

<?php include("js.php");?>
<!-- Select2 -->
    
    <script src="plugins/select2/select2.full.min.js"></script>
    <script src="dist/js/VentanaCentrada.js"></script>

    <script>
    $(function () {
       
     var param= $("#typeDocument").val();
     var final_payment = parseInt(param);      
       paymentType(final_payment);

        //Initialize Select2 Elements
        $(".select2").select2();
         var descuento= $("#descuento").val();
        $("#resultados" ).load( "./ajax/agregar_venta_pos.php?descuento="+descuento);
        load(1);


    });
        function load(page){
            var q= $("#q").val();
            $("#loader").fadeIn('slow');
            var categoria =$("#category_id").val();
            $.ajax({
                url:'./ajax/productos_ventas_pos.php?action=ajax&page='+page+'&q='+q+'&categoria='+categoria,
                 beforeSend: function(objeto){
                 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
              },
                success:function(data){
                    $(".outer_div").html(data).fadeIn('slow');
                    $('#loader').html('');
                    
                }
            })
        }

    function agregar (id)
        {
            var precio_venta=document.getElementById('precio_venta_'+id).value;
            var cantidad=document.getElementById('cantidad_'+id).value;
            
            //Inicia validacion
            if (isNaN(cantidad))
            {
            alert('Esto no es un numero');
            document.getElementById('cantidad_'+id).focus();
            return false;
            }
            if (isNaN(precio_venta))
            {
            alert('Esto no es un numero');
            document.getElementById('precio_venta_'+id).focus();
            return false;
            }
            //Fin validacion
             var descuento=$("#descuento").val();
            
            $.ajax({
        type: "POST",
        url: "./ajax/agregar_venta_pos.php",
        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad+"&descuento="+descuento,
         beforeSend: function(objeto){
            $("#resultados").html("Mensaje: Cargando...");
          },
        success: function(datos){
        $("#resultados").html(datos);
        }
            });
        }
        
            function eliminar (id)
        {
            var descuento=$("#descuento").val(); 
            
            $.ajax({
        type: "GET",
        url: "./ajax/agregar_venta_pos.php?descuento="+descuento,
        data: "id="+id,
         beforeSend: function(objeto){
            $("#resultados").html("Mensaje: Cargando...");
          },
        success: function(datos){
        $("#resultados").html(datos);
        }
            });

        }


        function comfirmEdit ()
        {
            var id =$('#sale_number').val();
            VentanaCentrada('sale-print-ticket-pdf.php?id='+id,'Ver PDF','','1024','768','true');

        }


        function update_sale(key,value){
            var descuento=$("#descuento").val();
        $.ajax({
        type: "POST",
        url: "./ajax/agregar_venta_pos.php",
        data: {"key":key,"value":value, "descuento":descuento},
             success: function(datos){
            $("#resultados").html(datos);
            }
        });
        }

        function update_sale_payment(payment){

            var descuento=$("#descuento").val();
            $("#resultados").load("./ajax/agregar_venta_pos.php?payment="+payment+"&descuento="+descuento);           

        }

         function descuento(value){
            var taxes=$("#taxes").val();            
            $("#resultados" ).load( "./ajax/agregar_venta_pos.php?descuento="+value+"&tax="+taxes);
            $("#descuento").val(value);
        }

         function updateCant(value, idproducto){
           
            var taxes=$("#taxes").val();
            console.log(value);
            console.log(idproducto);
            var descuento =$("#descuento").val();
            var sale =$("#sale_number").val();
            $("#resultados" ).load( "./ajax/agregar_venta_pos.php?cantidad="+value+"&idproducto="+idproducto+"&tax="+taxes+"&descuento="+descuento+"&sale_number="+sale);
            

        }
        

        function view_pdf(id){
            VentanaCentrada('sale-print-ticket.php?id='+id,'Ver PDF','','1024','768','true');
        }   
                    
                

    </script>

    <script>
        $( "#guardar_cliente").submit(function( event ) {
          $('#guardar_datos').attr("disabled", true);
         var parametros = $(this).serialize();
             $.ajax({
                    type: "POST",
                    url: "ajax/registro/agregar_cliente.php",
                    data: parametros,
                     beforeSend: function(objeto){
                        $("#resultados_ajax").html("Enviando...");
                      },
                    success: function(datos){
                    $("#resultados_ajax").html(datos);
                    $('#guardar_datos').attr("disabled", false);
                    load(1);
                    window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove();});}, 5000);
                    $('#cliente_modal').modal('hide');
                  }
            });
          event.preventDefault();
        })
    </script>

     <script>
        $("#barcode_form" ).submit(function( event ) {
          var barcode=$("#barcode").val();
          var barcode_qty=$("#barcode_qty").val();         
          var taxes=$("#taxes").val();
          var descuento =$("#descuento").val();
          parametros={'barcode':barcode,'barcode_qty':barcode_qty,'tax':taxes, 'descuento':descuento};
          
          $.ajax({
            type: "POST",
            url: "./ajax/agregar_venta_pos.php",
            data: parametros,
             beforeSend: function(objeto){
                $("#resultados").html("Mensaje: Cargando...");
              },
            success: function(datos){
            $("#resultados").html(datos);
            $("#barcode").val("");
            $("#barcode").focus();
            }
        });
            
          event.preventDefault();
        })
    </script>


    <script>
        function modalPago(value){        

         var totalModal =$("#payablePrice").val(value);
                         
        }


        function paymentType(payment)
        {
            var paymentType =1;

            switch (payment){
                  case 1:
                    $('#cash').addClass('active');
                    $('#check').removeClass('active');
                    $('#card').removeClass('active');                   
                    paymentType=1;
                    
                    break;
                     case 2:
                    $('#check').addClass('active');
                    $('#cash').removeClass('active');
                    $('#card').removeClass('active');
                    
                    paymentType=2;
                     console.log(paymentType);
                    break;

                      case 3:
                    $('#card').addClass('active');
                    $('#cash').removeClass('active');
                    $('#check').removeClass('active');

                    paymentType =3;
                     console.log(paymentType);
                    break;
            }

            type = $('#typeDocument').val(paymentType);
             update_sale_payment(paymentType);
        }
    </script>

    <script>
        //teclado
         $.fn.go = function (value,isDueInput) {
            if(isDueInput){
               

            }else{

                $("#payment").val($("#payment").val()+""+value);
            $(this).calculateChange();
            }
        }



         $.fn.digits = function(){
            $("#payment").val($("#payment").val()+".");
            $(this).calculateChange();
        }




        $.fn.calculateChange = function () {
        var change = $("#payment").val() - $("#payablePrice").val() ;
        if(change <= 0){
            $("#change").text('No debe darse cambio');
        }else{
            $("#change").text(change.toFixed(2));
        }
        if(change <= 0){
            $("#confirmPayment").show();
        }else{
            $("#confirmPayment").show();
        }
    }
    
    </script>


</body>
</html>