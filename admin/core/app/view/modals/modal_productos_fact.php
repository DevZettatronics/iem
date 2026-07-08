<!-- Modal -->
<div class="modal fade" id="m_fact_products" tabindex="-1" role="dialog" aria-labelledby="m_fact_products">
    <div class="modal-dialog modal-xl" role="document"> <!-- AQUI CAMBIA -->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Productos</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar por concepto, clave o unidad..." onkeyup="filterAndPaginate()">

                <table class="table table-bordered table-hover table-striped" style="text-align: center;">


                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Concepto</th>
                            <th>Clave</th>
                            <th>Cantidad</th>
                            <th>Unidad</th>
                            <th>Precio Unitario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php 
                            $consulta_productos = mysqli_query($con,"SELECT * FROM products WHERE status = 1"); 
                            $cantidadP = 1;
                            while ($dataP = mysqli_fetch_array($consulta_productos)) {
                                $unidad = $dataP['presentation'];
                                $sql_clave = mysqli_query($con, "SELECT * from c_claveunidad where idClaveUnidad='$unidad';");
                                $row_c = mysqli_fetch_array($sql_clave);
                                $clave_tabla = $row_c['Nombre'];
                                $clave_tablaU = $row_c['ClaveUnidad'];
                        ?>
                        <tr>
                            <td><?php echo $dataP['product_id']; ?></td> 
                            <td><?php echo $dataP['product_name']; ?></td> 
                            <td><?php echo $dataP['clave_sat']; ?></td>
                            <td><?php echo $cantidadP; ?></td>
                            <td><?php echo $clave_tablaU . " " . $clave_tabla; ?></td>
                            <td><?php echo $dataP['selling_price']; ?></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" style="padding: 5px 6px; margin: 0;" 
                                        onClick="agregarFact(<?php echo $dataP['product_id']; ?>)"
                                >Agregar</button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
               

            </div>
            <div id="paginationControls" class="mt-3 text-center"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
