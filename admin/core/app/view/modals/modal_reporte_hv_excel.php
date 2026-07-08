<!-- Modal -->
<div class="modal fade" id="m_reporte_hv_excel" tabindex="-1" role="dialog" aria-labelledby="m_reporte_hv_excel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generación de reporte de ventas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h5>Seleccione un rango de fechas a generar el reporte:</h4>
                    <div class="row">
                        <div class="input-group input-daterange">
                            <div class="input-group-addon" for="start_date">De</div>
                            <input type="date" name="start_date" id="start_date" class="form-control" require>
                            <div class="input-group-addon" for="end_date">Hasta</div>
                            <input type="date" name="end_date" id="end_date" class="form-control" require>
                        </div>
                    </div>
                    <h5 id="errorMessage" class="text-danger text-center"></h5>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-img" id="generar_reporte_hvexcel">
                    <img src="https://download.logo.wine/logo/Microsoft_Excel/Microsoft_Excel-Logo.wine.png" alt="Imagen" height="20px">
                    Generar Reporte
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->