<?php
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=ReportePagos.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Muy importante: BOM UTF-8
echo "\xEF\xBB\xBF";
?>
<h2 style="text-align:center; color:#1777d8;">Reporte de pagos: <?php echo date('d/m/Y'); ?> </h2>

<table style="width:100%; border-collapse:collapse; font-family:sans-serif; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    <thead>
        <tr style="background-color:#1777d8; color:white;">
            <th style="padding:8px; border:1px solid #ccc;">Id</th>
            <th style="padding:8px; border:1px solid #ccc;">Periodo</th>
            <th style="padding:8px; border:1px solid #ccc;">Matr&iacute;cula</th>
            <th style="padding:8px; border:1px solid #ccc;">Estudiante</th>
            <th style="padding:8px; border:1px solid #ccc;">Carrera</th>
            <th style="padding:8px; border:1px solid #ccc;">Concepto</th>
            <th style="padding:8px; border:1px solid #ccc;">Cantidad Pagada</th>
            <th style="padding:8px; border:1px solid #ccc;">Estatus de Pago</th>
            <th style="padding:8px; border:1px solid #ccc;">Fecha de pago</th>
            <!-- <th style="padding:8px; border:1px solid #ccc;">Fin de Pago</th> -->
            <!-- <th style="padding:8px; border:1px solid #ccc;">Estado</th> -->
        </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $key) { 
        
        $idP = trim($key->description);
        $dataProduct = PlandepagoData::dataProduct($idP);

        $productos = $dataProduct[0]->productos;

        //Total del producto de tabla product, por el momento no se ocupa por que es precio de producto genral.
        $total = $dataProduct[0]->total; //Aqui faltaria validar, beca,promocion, recargo, descuento etc tomando de sales (tendriamos que hacer otra consulta)


        // $totalBruto = $total;

        $descuentoBeca = 0;
        $descuentoPromocion = 0;

        $tipopa = $key->periodo_name ?? 'Periodo no asignado';
        // Beca
        // if (empty($key->beca)) { // null, 0 o ''
        //     $cuenta_beca = 'NO';
        //     $porcentaje_beca = 0;
        // } else {
        //     $cuenta_beca = 'SI';
        //     $porcentaje_beca = !empty($key->porcentaje_beca) ? $key->porcentaje_beca : 0;
        // }

        // // Promoción
        // if (empty($key->promocion)) {
        //     $cuenta_promocion = 'NO';
        //     $porcentaje_promocion = 0;
        // } else {
        //     $cuenta_promocion = 'SI';
        //     $porcentaje_promocion = !empty($key->porcentaje_promocion) ? $key->porcentaje_promocion : 0;
        // }

        // // Cálculo de descuentos
        // $descuentoBeca = ($cuenta_beca === "SI") ? ($totalBruto * $porcentaje_beca / 100) : 0;
        // $descuentoPromocion = ($cuenta_promocion === "SI") ? ($totalBruto * $porcentaje_promocion / 100) : 0;

        // $descuentoTotal = $descuentoBeca + $descuentoPromocion;
        // $totalConDescuento = $totalBruto - $descuentoTotal;

        // if ($key->status == 1) {
        //     $estado = "Pendiente";
        // } elseif ($key->status == 2) {
        //     $estado = "Pagado";
        // } elseif ($key->status == 3) {
        //     $estado = "Pagado con retraso";
        // } elseif ($key->status == 4) {
        //     $estado = "Adeudo";
        // } elseif ($key->status == 5) {
        //     $estado = "Sin validar";
        // } elseif ($key->status == 6) {
        //     $estado = "Vencido";
        // } else {
        //     $estado = "Desconocido";
        // }
        if ($key->vinculacion === '1') {
            $tipopa = 'Vinculacion';
        }
    ?>
        <tr style="background-color:<?= $key->status == 2 ? '#e6f7ff' : '#fff'; ?>;">
            <td style="padding:8px; border:1px solid #ccc; text-align:center;"><?php echo $key->id; ?></td>
            <td style="padding:8px; border:1px solid #ccc; text-align:center;"><?php echo $tipopa; ?></td>
            <td style="padding:8px; border:1px solid #ccc; text-align:center;"><?php echo $key->alumno_code; ?></td>
            <td style="padding:8px; border:1px solid #ccc; text-align:center;"><?php echo ($key->alumno_name . " " . $key->alumno_lastname); ?></td>
            <td style="padding:8px; border:1px solid #ccc; text-align:center;"><?php echo ($key->carrera_grade); ?></td>
            <td style="padding:8px; border:1px solid #ccc; text-align:center;"><?php echo ($productos); ?></td>
            <!-- <td style="padding:8px; border:1px solid #ccc; text-align:center;"><?php //echo number_format($totalConDescuento, 2); ?></td> -->
            <td style="padding:8px; border:1px solid #ccc; text-align:center;"><?php echo number_format($key->totalP, 2); ?></td>
            <td style="padding:8px; border:1px solid #ccc; text-align:center; color:<?php echo (!empty($key->kind_cancelacion)) ? 'red' : 'green'; ?>;">
                <?php echo (!empty($key->kind_cancelacion)) ? 'Cancelado' : 'Activo'; ?>
            </td>
            <td style="padding:8px; border:1px solid #ccc; text-align:center;"><?php echo $key->payment_date; ?></td>
            <!-- <td style="padding:8px; border:1px solid #ccc; text-align:center;"><?php //echo $key->fecha_fin_pago; ?></td> -->
            <!-- <td style="padding:8px; border:1px solid #ccc; text-align:center;"><?php //echo $estado; ?></td> -->
        </tr>
    <?php } ?>
    </tbody>
</table>