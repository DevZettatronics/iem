<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all") { ?>
    <?php
    include_once("config/db.php");
    include_once("config/conexion.php");
    $con = Database::getCon();
    mysqli_set_charset($con, "utf8mb4");
    $id_ticket = $_GET['id'];
    $sql_ticket = mysqli_query($con, "SELECT * FROM pagos WHERE id = $id_ticket");
    $rwt = mysqli_fetch_array($sql_ticket);
    $order_id = $rwt['order_id'];
    $sql_ticket = mysqli_query($con, "SELECT * FROM sales WHERE sale_number = $order_id");
    $rwt = mysqli_fetch_array($sql_ticket);
    $ticket = $rwt['sale_id'];
    $cliente = $rwt['person_id'];
    $subtotal = $rwt['subtotal'];
    $total = $rwt['total'];
    $tax = $rwt['tax']; // lo que sale del iva
    $sale_date = $rwt['sale_date'];
    $discount_value = $rwt['discount_value'];
    $metodoPago = $rwt['payment_method'];
    $sql_pro = mysqli_query($con, "SELECT sp.product_id FROM sale_product sp inner join products p on sp.product_id = p.product_id WHERE sale_id ='$ticket'");
    $rwp = mysqli_fetch_array($sql_pro);
    if ($metodoPago == 1) {
        $mPago = 1;
    } elseif ($metodoPago == 2) {
        $mPago = 2;
    } elseif ($metodoPago == 3) {
        $mPago = 4;
    }
    ?>
    <!-- <script src="http://code.jquery.com/jquery-latest.js"></script> -->
    <section class="content-header">
        <h1><i class='fa fa-edit'></i> Generar Factura del ticket
            <?php echo $id_ticket ?>
        </h1>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <!-- *********************** Nueva factura ************************** -->
                        <div class="col-md-12">
                            <form action="" method="post" id="factura_r" name="factura_r" enctype="multipart/form-data">
                                <label for="">DATOS CLIENTE </label>
                                <div>
                                    <div class="col-md-6">
                                        <label for="">Cliente</label>
                                        <select required class="form-control" data-live-search="true" name="customer_id"
                                            id="customer_id" onchange="procedimiento_A()">
                                            <!-- <option class="text-left" value="">Generico</option> -->
                                            <?php
                                            $sql_user = mysqli_query($con, "SELECT * FROM customers;");
                                            // while (
                                            while ($rw = mysqli_fetch_array($sql_user)) {
                                                // ) {
                                                $customers_id = $rw['id'];
                                                if ($customers_id == 1) {
                                                    $customers_name = $rw['name'];
                                                    $customers_last_name = $rw['last_name'];
                                                    $cp = $rw['postal_code'];
                                                    $pais = $rw['country'];
                                                    $estado = $rw['state'];
                                                    $ciudad = $rw['city'];
                                                    $calle = $rw['address1'];
                                                    $rfc = $rw['rfc'];
                                                    $regimen = $rw['regimen'];
                                                }
                                                ?>
                                                <!-- "ID:".$rw['id']." ". -->
                                                <option <?php echo ($customers_id == 1) ? 'selected' : 'nada' ?> class="text-left"
                                                    value="<?php echo $rw['id'] ?>">
                                                    <?php echo $rw['name'] . " " . $rw['last_name'] ?>
                                                </option>
                                            <?php //} 
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3" style="">
                                        <label for="">Agregar nuevo cliente</label>
                                        <button type="button" class="form-control" style="width:40px" onclick="location.replace('?view=receptoresform&opt=new')" title="Agregar nuevo cliente"><i class="fa fa-plus"></i></button>
                                    </div>
                                    <!-- <div class="col-md-2" style="margin-top: 22px;">
                                    <label for="">Agregar Nuevo</label>
                                    <button data-toggle="modal" data-target="#cliente_modal" class="btn btn-success"><i class="fa fa-plus"></i></button>
                                </div> -->
                                </div>
                                <div class="row">

                                    <div class='col-md-2' style="display:none;">
                                        <label for="id_ticket">id_ticket</label>
                                        <input type="text" class="form-control" id="id_ticket" name="id_ticket"
                                            value="<?php echo $id_ticket; ?>" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-3'>
                                        <label for="rsocial">R.Social</label>
                                        <input type="text" class="form-control" maxlength="100" id="rsocial" name="rsocial"
                                            value="<?php echo $customers_name . " " . $customers_last_name ?>" readonly>
                                    </div>
                                    <div class='col-md-3'>
                                        <label for="rfc_cli">RFC</label>
                                        <input type="text" class="form-control" maxlength="100" id="rfc_cli" name="rfc_cli"
                                            onchange="validarfc();" maxlength="13" value="<?php echo $rfc ?>" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-6'>
                                        <label for="direccion_cliente">Dirección</label>
                                        <input type="text" class="form-control" maxlength="100" id="direccion_cliente"
                                            name="direccion_cliente"
                                            value="<?php echo $pais . "," . $estado . "," . $ciudad . ", Calle y No." . $calle; ?>"
                                            readonly>
                                    </div>
                                    <div class='col-md-3'>
                                        <label for="cp_cliente">CP</label>
                                        <input type="text" class="form-control" maxlength="100" id="cp_cliente"
                                            name="cp_cliente" value="<?php echo $cp ?>" readonly>
                                    </div>
                                </div><br>
                                <label for="">DATOS COMPROBANTE</label><br>
                                <div class="row">
                                    <div class='col-md-3'>
                                        <label for="tipo_c">Tipo</label>
                                        <select required class="form-control " data-live-search="true" name="tipo_c" id="tipo_c" >
                                            <?php
                                            $sql_user = mysqli_query($con, "SELECT * FROM c_tipodecomprobante;");
                                            while ($rw = mysqli_fetch_array($sql_user)) { 
                                            $tipoComprobante_id = $rw['id'];
                                            $tipoComprobante_name = $rw['descripcion'];
                                            $tipoComprobante_tipo = $rw['tipoDeComprobante'];
                                            ?>
                                            <!-- "ID:".$rw['id']." ". -->
                                            <option class="text-center" value="<?php echo $tipoComprobante_id ?>"><?php echo $tipoComprobante_tipo . ": " . $tipoComprobante_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class='col-md-2'>
                                        <label for="serie_f">Serie</label>
                                        <input type="text" class="form-control" id="serie_f" name="serie_f" value="01" placeholder="01">
                                    </div>
                                    <div class='col-md-2'>
                                        <?php
                                        function next_folio()
                                        {
                                            global $con;
                                            $sql = mysqli_query($con, "SELECT folio FROM tmp_fac ORDER BY id DESC LIMIT 0,1");
                                            $rw = mysqli_fetch_array($sql);
                                            $num_orden = $rw['folio'];
                                            $nex_num_orden = str_pad($num_orden + 1, 5, "0", STR_PAD_LEFT);
                                            return $nex_num_orden;
                                        }
                                        ?>
                                        <label for="folio_f">Folio</label>
                                        <input type="text" class="form-control" id="folio_f" name="folio_f"
                                            value="<?php echo $ticket ?>" placeholder="1">
                                    </div>
                                    <div class='col-md-2'>
                                        <label for="fecha_c">Fecha de Emisión</label>
                                        <input type="text" class="form-control" id="fecha_c" name="fecha_c"
                                            value="<?php echo date("Y-m-d H:i:s"); ?>" > <!-- readonly -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-3'>
                                        <label for="m_pago">Método de Pago</label>
                                        <select required class="form-control" data-live-search="true" name="m_pago" id="m_pago">
                                            <!-- <option value="">Seleccionar</option> -->
                                            <?php
                                            $sql_user = mysqli_query($con, "SELECT * FROM c_metodopago ;");
                                            while ($rw = mysqli_fetch_array($sql_user)) {
                                                $metodo_id = $rw['id'];
                                                $metodo_name = $rw['c_MetodoPago'];
                                                $metodo_tipo = $rw['Descripcion'];
                                                ?>
                                                <!-- "ID:".$rw['id']." ". -->
                                                <option class="text-center" value="<?php echo $metodo_id ?>"><?php echo $metodo_name . ": " . $metodo_tipo ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class='col-md-3'>
                                        <label for="f_pago">Forma de Pago</label>
                                        <select required class="form-control" data-live-search="true" name="f_pago"
                                            id="f_pago" >
                                            <?php
                                            $sql_user = mysqli_query($con, "SELECT * FROM c_formapago;");
                                            while ($rw = mysqli_fetch_array($sql_user)) {
                                                $forma_id = $rw['idformadepago'];
                                                $forma_name = $rw['c_FormaPago'];
                                                $forma_tipo = $rw['Descripcion'];
                                                ?>
                                                <!-- "ID:".$rw['id']." ". -->
                                                <option class="text-center" value="<?php echo $forma_id ?>"><?php echo $forma_name . ": " . $forma_tipo ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class='col-md-3'>
                                        <label for="objeto">Objeto De Impuesto</label>
                                        <select required class="form-control" data-live-search="true" name="objeto"
                                            id="objeto" >
                                            <?php
                                            $sql_ob = mysqli_query($con, "SELECT * FROM c_objetoimp");
                                            while ($rwO = mysqli_fetch_array($sql_ob)) {
                                                $objeto_id = $rwO['id_ObjetoImp'];
                                                $objeto_name = $rwO['c_ObjetoImp'];
                                                $objeto_tipo = $rwO['Descripcion'];
                                                ?>
                                                <!-- "ID:".$rw['id']." ". -->
                                                <option class="text-center" value="<?php echo $objeto_id ?>"><?php echo $objeto_name . ": " . $objeto_tipo ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-2'>
                                        <label for="t_moneda">Tipo de Moneda</label>
                                        <select required class="form-control" data-live-search="true" name="t_moneda"
                                            id="t_moneda" selected readonly>
                                            <?php
                                            $sql_moneda = mysqli_query($con, "SELECT * FROM c_moneda ;"); ?>
                                            <option class="text-center" value="100">MXN-Peso Mexicano</option>
                                            <?php
                                            while ($rwm = mysqli_fetch_array($sql_moneda)) {
                                                $tmoneda_id = $rwm['idmoneda'];
                                                $tmoneda_name = $rwm['c_Moneda'];
                                                $tmoneda_desc = $rwm['Descripcion'];
                                                ?>
                                                <!-- "ID:".$rw['id']." ". -->
                                                <option class="text-center" value="<?php echo $tmoneda_id ?>"><?php echo $tmoneda_name . "-" . $tmoneda_desc; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class='col-md-2'>
                                        <label for="t_cambio">Tipo de Cambio</label>
                                        <input type="text" class="form-control" id="t_cambio" name="t_cambio" value="1.0"
                                            readonly>
                                    </div>
                                    <div class='col-md-3'>
                                        <label for="tipo_cfdi">Uso de CFDI</label>
                                        <select required class="form-control" data-live-search="true" name="tipo_cfdi" id="tipo_cfdi">
                                            <?php
                                            $query_cfdi = "SELECT * FROM c_regimenfiscal WHERE idregimenfiscal = '$regimen';";
                                            $sql_cfdi = mysqli_query($con, $query_cfdi);
                                            $row_regimen = mysqli_fetch_array($sql_cfdi);
                                            $c_Regimen = $row_regimen['c_RegimenFiscal'];
                                            ?>
                                            <?php
                                            $sql_query_reg_fiscal = "SELECT * FROM c_usocfdi ;";
                                            $sql_cfdi = mysqli_query($con, $sql_query_reg_fiscal);
                                            ?>
                                            <?php
                                            while ($rwc = mysqli_fetch_array($sql_cfdi)) { //Oceano de las tempestades, manzana 26, lote 14
                                                $cfdi_id = $rwc['idusocfdi'];
                                                $cfdi_uso = $rwc['c_UsoCFDI'];
                                                $cfdi_des = $rwc['Descripcion'];
                                                ?>
                                                <!-- "ID:".$rw['id']." ". -->
                                                <option class="text-center" value="<?php echo $cfdi_id ?>"><?php echo $cfdi_uso . ": " . $cfdi_des ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div><br>
                                <label for="">CONCEPTO PRODUCTO O SERVICIO</label>
                                <!-- <div class="row">
                                <div class="col-md-2" style="margin-top: 22px;">
                                    <label for=""> Nuevo</label>
                                    <button data-toggle="modal" data-target="#proserv_modal" class="btn btn-success"><i class="fas fa-boxes"></i></button>
                                </div>
                            </div> -->
                                <!-- <div class="row">
                                <div class='col-md-3'>
                                    <label for="concepto">*Concepto</label>
                                    <select required class="form-control" data-live-search="true" name="concepto1" id="concepto1" onchange="procedimiento_B()">
                                        <option class="text-left" value="">Seleccione un producto/servicio</option>
                                        <?php
                                        /* $sql_con = mysqli_query($con, "SELECT * FROM producto order by id DESC;");
                                        while ($rwc = mysqli_fetch_array($sql_con)) {
                                        $c_id = $rwc['id'];
                                        $c_unidad = $rwc['unidad'];
                                        $c_concepto = $rwc['concepto'];
                                        $c_iva = $rwc['iva'];
                                        $c_pu = $rwc['pu'];
                                        $c_ieps = $rwc['ieps'];
                                        $c_clave = $rwc['clave']; */
                                        ?>                                         
                                                <option class="text-left" value="<?php /* echo $c_id; */?>"><?php /* echo $c_concepto; */?></option>
                                        <?php /* } */?>
                                    </select>
                                </div>
                                <div class='col-md-2'>
                                    <label for="clave_ps">*Clave P/S</label>
                                    <input type="text" class="form-control" maxlength="100" id="clave_ps" name="clave_ps" readonly>
                                </div>
                                <div class='col-md-2'>
                                    <label for="cantidadc">*Cantidad</label>
                                    <input type="text" class="form-control" maxlength="100" id="cantidadc" name="cantidadc" onchange="importe()" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                                </div>
                                <div class='col-md-2'>
                                    <label for="unidadc">*Unidad</label>
                                    <input type="text" class="form-control" maxlength="100" id="unidadc" name="unidadc" readonly>
                                </div>
                            </div> -->
                                <!--                               
                            <div class="row">                        
                                <div class='col-md-2'>
                                    <label for="puc">*Precio Unitario</label>
                                    <input type="text" class="form-control" maxlength="100" id="puc" name="puc" readonly>
                                </div>
                                <div class='col-xs-1'>
                                    <label for="ivac">*IVA</label>
                                    <input type="text" class="form-control" maxlength="100" id="ivac" name="ivac" readonly>
                                </div>
                                <div class='col-md-1'>
                                    <label for="importec">*Importe</label>
                                    <input type="text" class="form-control" maxlength="100" id="importec" name="importec" readonly>
                                </div>
                                <div class='col-md-1'>
                                    <label for="descc">*Descuento</label>
                                    <input type="text" class="form-control" maxlength="100" id="descc" name="descc">
                                </div>
                            </div> -->
                                <div class="table-responsive">
                                    <table class="table table-condensed table-hover table-striped ">
                                        <tr>
                                            <th class='text-center'>Concepto</th>
                                            <th class='text-center'>Clave</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class='text-center'>Unidad</th>
                                            <th class='text-center'>Precio U.</th>
                                            <th class='text-center'>TotalxConcepto</th>
                                            <th></th>
                                        </tr>
                                        <?php
                                        $sumador_total = 0;
                                        $query = "SELECT * from products, sale_product where products.product_id= sale_product.product_id and sale_product.sale_id='$ticket';";
                                        $sql_c = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_array($sql_c)) {
                                            $product_code = $row['product_code'];
                                            $qty = $row['qty'];
                                            $product_name = $row['product_name'];
                                            $unit_price = number_format($row['unit_price'], $currency_format['precision_currency'], '.', '');
                                            $precio_total = $unit_price * $qty;
                                            $precio_total = number_format($precio_total, $currency_format['precision_currency'], '.', ''); //Precio total formateado                                 
                                            $sumador_total += $precio_total; //Sumador                                  
                                            $clave_sat = $row['clave_sat'];
                                            $unidad = $row['presentation'];
                                            $sql_clave = mysqli_query($con, "SELECT * from c_claveunidad where idClaveUnidad='$unidad';");
                                            $row_c = mysqli_fetch_array($sql_clave);
                                            $clave_tabla = $row_c['Nombre'];
                                            $clave_tablaU = $row_c['ClaveUnidad'];
                                            ?>
                                            <style>
                                                .pro[readonly] {
                                                    background-color: #fff0;
                                                    border: 0px;
                                                }
                                            </style>
                                            <tr>
                                                <td class='text-left'><input type="text" class="form-control pro" id="concepto1"
                                                        name="concepto1" value="<?php echo $product_name; ?>"
                                                        style="font-size:12px;" readonly> </td>
                                                <td class='text-center'><input type="text" class="form-control pro"
                                                        id="clave_ps" name="clave_ps" value="<?php echo $clave_sat; ?>"
                                                        maxlength="8" style="font-size:12px; text-align: center;" readonly></td>
                                                <td class="text-center"><input type="text" class="form-control pro"
                                                        id="cantidadc" name="cantidadc" value=" <?php echo $qty; ?>"
                                                        style="font-size:12px;text-align: center;" readonly> </td>
                                                <td class='text-center'><input type="text" class="form-control pro" id="unidadc"
                                                        name="unidadc" value="<?php echo $clave_tablaU . " " . $clave_tabla; ?>"
                                                        style="font-size:12px;text-align: center;" readonly></td>
                                                <td class='text-center'><input type="text" class="form-control pro" id="puc"
                                                        name="puc"
                                                        value="<?php echo number_format($unit_price, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?>"
                                                        style="font-size:12px;text-align: center;" readonly></td>
                                                <td class='text-center'><input type="text" class="form-control pro"
                                                        id="total_unidad" name="total_unidad"
                                                        value="<?php echo number_format($precio_total, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?>"
                                                        style="font-size:12px;text-align: center;" readonly></td>
                                            </tr>
                                        <?php }
                                        $sql_o = mysqli_query($con, "SELECT * from sales where sale_number='$order_id';");
                                        $rows = mysqli_fetch_array($sql_o);
                                        $descuento = $rows['discount_value'];
                                        $tax_txt = $rows['tax_value'];
                                        $total_parcial = number_format($sumador_total, $currency_format['precision_currency'], '.', '');
                                        $total_neto = $total_parcial;
                                        $total_neto = number_format($total_neto, $currency_format['precision_currency'], '.', '');
                                        $total_iva = ($total_neto * $tax_txt) / 100;
                                        $total_iva = number_format($total_iva, $currency_format['precision_currency'], '.', '');
                                        $total_compra = $total_neto + $total_iva;
                                        $total_compra = number_format($total_compra, $currency_format['precision_currency'], '.', '');
                                        /*  $precio_descuento = ($total_neto * $descuento) / 100; */
                                        if ($descuento > 0) {
                                            $precio_descuento = ($total_neto * $descuento) / 100;
                                            $total_descuento = ($total_neto - $precio_descuento);
                                            $total_iva = ($total_descuento * $tax_txt) / 100;
                                            $total_compra = ($total_descuento + $total_iva);
                                        } else {
                                            $total_iva = ($total_neto * $tax_txt) / 100;
                                            $total_iva = number_format($total_iva, $currency_format['precision_currency'], '.', '');
                                            $total_compra = $total_neto + $total_iva;
                                            $total_compra = number_format($total_compra, $currency_format['precision_currency'], '.', '');
                                        }
                                        ?>
                                        <tr>
                                            <td style='text-align:right' class='' colspan="3">Subtotal <i class="fa fa-usd"
                                                    aria-hidden="true"> </td>
                                            <td class=''>
                                                <?php echo number_format($total_neto, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?>
                                            </td>
                                            <input type="hidden" id="subtotal" name="subtotal"
                                                value="<?php echo number_format($total_neto, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?>">
                                        </tr>
                                        <?php
                                        if ($descuento > 0) {
                                            ?>
                                            <tr>
                                                <td style='text-align:right' class='' colspan="3">Descuento
                                                    <?php echo $descuento; ?>% <i class="fa fa-usd" aria-hidden="true">
                                                </td>
                                                <!--muestra el descuento en la vista -->
                                                <td class=''>
                                                    <?php echo number_format($precio_descuento, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?>
                                                </td>
                                             <!--    < ?php var_dump($precio_descuento) ?> -->
                                                <!-- input que se esta pasando -->
                                                <input type="text" id="descuento" name="descuento"
                                                    value="<?php echo number_format($precio_descuento, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?>">
                                            </tr>
                                            <?php
                                        } else { ?>
                                            <tr>
                                                <td style='text-align:right' class='' colspan="3">Descuento 0% <i
                                                        class="fa fa-usd" aria-hidden="true"> </td>
                                                <td class=''></td>
                                                <input type="hidden" id="descuento" name="descuento" value="">
                                            </tr>
                                        <?php }
                                        ?>
                                        <tr>
                                            <td style='text-align:right' class='' colspan="3">IVA
                                                <?php echo $tax_txt; ?> % <i class="fa fa-usd" aria-hidden="true">
                                            </td>
                                            <td class=''>
                                                <?php echo number_format($total_iva, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?>
                                            </td>
                                            <input type="hidden" id="iva" name="iva"
                                                value="<?php echo number_format($total_iva, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?>">
                                        </tr>
                                        <tr>
                                            <td style='text-align:right' class='' colspan="3"><b>Total <i class="fa fa-usd"
                                                        aria-hidden="true"></i></b></td>
                                            <td class=''> <b>
                                                    <?php echo number_format($total_compra, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?>
                                                </b></td>
                                            <input type="hidden" id="total" name="total"
                                                value="<?php echo number_format($total_compra, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']); ?> ">
                                        </tr>
                                        <?php $total = number_format($total_compra, $currency_format['precision_currency'], $currency_format['decimal_separator'], $currency_format['thousand_separator']);
                                        if (isset($total)) { ?>
                                            <input type="hidden" id="estado" name="estado" value="Vigente">
                                        <?php } ?>
                                    </table>
                                </div>
                                <div class="box-footer left">
                                    <button type="submit" id="guardar_datos" class="btn btn-primary">Facturar</button>
                                    <!-- onclick="pdf('<?php /* echo $id_ticket; */ ?>');" -->
                                </div>
                                <div id="resultados_ajax"></div>
                            </form>
                        </div>
                    </div><!-- row -->
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
<?php }
?>
<script>
    // $("#customer_id").selectpicker();
    /* $("#concepto1").selectpicker(); */
    /* $("#unidadp").selectpicker(); */
    $("#factura_r").on("submit", function (e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...
        } else {
            $("#guardar_datos").attr("disabled", true);
            var parametros = $(this).serialize();
            var formData = new FormData(document.getElementById("factura_r")); // preparados todos mis valores
            $.ajax({
                type: "POST",
                url: "./ajax/registro/agregar_factura4.php",
                data: parametros,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function (objeto) {
                    console.log(parametros)
                    $("#resultados_ajax").html("Enviando Información...");
                },
                success: function (datos) {
                    $("#resultados_ajax").html(datos);
                    $("#guardar_datos").attr("disabled", false);
                    $('input[id="direccion_cliente"]').val('');
                    $('input[id="cp_cliente"]').val('');
                    $('input[id="rfc_cli"]').val('');
                    $('select[id="tipo_c"]').val('');
                    $('select[id="customer_id"]').val('');
                    //load(1);
                    window.setTimeout(function () {
                        $(".alert")
                            .fadeTo(500, 0)
                            .slideUp(500, function () {
                                $(this).remove();
                            });
                    }, 5000);
                },
                error: function (response) {
                    console.log(JSON.stringify(response))
                }
            });
            event.preventDefault();
        }
    });
    /* no se pueden seleccionar los select */
    // $('#tipo_c').on('mousedown', function (e) {
    //     e.preventDefault();
    //     this.blur();
    //     window.focus();
    // });
    // $('#f_pago').on('mousedown', function (e) {
    //     e.preventDefault();
    //     this.blur();
    //     window.focus();
    // });
    // $('#m_pago').on('mousedown', function (e) {
    //     e.preventDefault();
    //     this.blur();
    //     window.focus();
    // });
    $('#t_moneda').on('mousedown', function (e) {
        e.preventDefault();
        this.blur();
        window.focus();
    });
    /* $('#customer_id').on('mousedown', function (e) {
        e.preventDefault();
        this.blur();
        window.focus();
    }); */
    // $('#objeto').on('mousedown', function (e) {
    //     e.preventDefault();
    //     this.blur();
    //     window.focus();
    // });
</script>
<script>
    function procedimiento_A() {
        id = $("#customer_id").val()
        parametros = { "id": id };
        $.ajax({
            dataType: 'json',
            url: './tim/obtener_datos.php',
            type: "POST",
            data: parametros,
            error: function (data) {
                console.log(data);
            },
            success: function (datos) {
                $("#rsocial").val(datos.nombre);
                $("#direccion_cliente").val(datos.direccion);
                $("#rfc_cli").val(datos.rfc);
                $("#cp_cliente").val(datos.cp);
            }
        })
    }
</script>