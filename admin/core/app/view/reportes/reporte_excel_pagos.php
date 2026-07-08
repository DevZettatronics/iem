<h2>Reporte de pagos: <?php echo date('d/m/Y'); ?> </h2>
<table>
    <thead>
        <tr>
            <th style="text-align:center;">ID Venta/Ticket</th>
            <th style="text-align:center;">Matr&iacute;cula</th>
            <th style="text-align:center;">Estudiante</th>
            <th style='text-align:center;'>Concepto</th>
            <th style='text-align:center;'>Tarjetahabiente</th>
            <th style='text-align:center;'>Metodo</th>
            <th style='text-align:center;'>Tarjeta</th>
            <th style='text-align:center;'>Importe Pagado</th>
            <th style='text-align:center;'>Fecha</th>
            <th style='text-align:center;'>Estatus</th>

        </tr>
    </thead>
    <?php foreach ($data as $key) { ?>

        <tr>
            <td style="text-align:center;">
                <?php echo $key->order_id; ?>
            </td>
            <td style="text-align:center;">
                <?php echo $key->matricula; ?>
            </td>
            <td style="text-align:center;">
                <?php echo utf8_decode($key->name_person); ?>
            </td>
            <td style="text-align:center;">
                <?php echo utf8_decode($key->product_name); ?>
            </td>
            <td style="text-align:center;">
                <?php echo utf8_decode($key->name_person); ?>
            </td>
            <td style="text-align:center;">
                <?php echo  $key->tipo_pago; ?>
            </td>
            <td style="text-align:center;">
                <?php echo (!is_null($key->number_card)) ? $key->number_card : "N/A"; ?>
            </td>
            <td style="text-align:center;">
                <?php echo  '$' . $key->total; ?>
            </td>
            </td>
            <td style="text-align:center;">
                <?php echo $key->date_created; ?>
            </td>
            <td style="text-align:center;">
                <?php echo $key->Pago; ?>
            </td>
            <td style="text-align:center;"></td>
        </tr>
    <?php } ?>
</table>