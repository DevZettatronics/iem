<?php if (isset($_GET["opt"]) && $_GET["opt"] == "all") : ?>
    <?php
    $id = ($_GET["id"]);
    $alumnid = PersonData::getById($id); //mando a llamar todos los elementod por id
    $code = $alumnid->code;/* sasigno a $code el campo code de DataPerson */
    $dates = BecasData::getByCode($code);
    ?>
    <div class="row">
        <div class="col-md-12">
            <h1>Becas y Promociones</h1>
            <div class="col-md-12" style="display:flex; justify-content:space-between">
            <?php
            $prom = $alumnid->promocion;
            $beca = $alumnid->beca;
            if($beca>1 || $prom>2)
            {
?>                <a href="index.php?view=editalumnbeca&opt=editb&id=<?php echo $alumnid->id; ?>" class="btn btn-default col-md-2"><i class='fa fa-asterisk'></i>Editar</a>
<?php
            }else{ ?>
                <a href="index.php?view=add_alumnbeca_prom&opt=editb&id=<?php echo $alumnid->id; ?>" class="btn btn-default col-md-3"><i class='fa fa-asterisk'></i> Asignar Beca o Promoción</a>
        <?php   }
            ?>
            </div><br>
        </div>
        <br>
    </div>
    <?php
    if (($dates)) {
        // si hay usuarios
    ?>
        <div class="box box-primary">
            <div class="box-body">
                <table class="table table-bordered datatable table-hover">
                    <thead>
                        <th>Matrícula</th>
                        <th>Nombre</th>
                        <th>Carrera</th>
                        <th>Beca</th>
                        <th>Promoción</th>
                        <th>Fecha</th>
                    </thead>
                    <?php
                    foreach ($dates as $da) {
                        /* carrera */
                        $carr = $alumnid->carrera;
                        $co = EducationalProgramData::getById($carr);
                        /* beca */
                        $id_bek = $da->beca;
                        $nombre_beca = BecasData::getById($id_bek);
                        if ($nombre_beca == null) {
                            $nombre_beca = "Sin Beca Asignada";
                        } else {
                            $name_beca = $nombre_beca->name;
                        }
                        /* promocion */
                        $id_prom = $da->promocion;
                        $nombre_promo = BecasData::getById($id_prom);
                        if ($nombre_promo == null) {
                            $name_promo = "Sin Promoción Asignada";
                        } else {
                            $name_promo = $nombre_promo->name;
                        }
                    ?>
                        <tr>
                            <td><?php echo  $da->code; ?></td>
                            <td>
                                <?php echo  $da->name; ?>
                                <br>
                                <?php echo $da->lastname; ?>
                            </td>
                            <td><?php echo $co->name; ?></td>
                            <td><?php echo $name_beca; ?>
                                <br><?php echo $nombre_beca->porcentaje . "%" ?>
                            </td>
                            <td><?php echo $name_promo ?>
                                <br><?php echo $nombre_promo->porcentaje . "%" ?>
                            </td>
                            <td><?php echo $da->created_at; ?></td>
                            <td></td>
                            <td>
                                <!--   <a href="index.php?action=planpago&opt=val&id=?php echo $pay->id; ?>" class="btn btn-success btn-xs"><i class="fa fa-check-circle"></i></a> -->
                                <!--  -->
                            </td>
                        </tr>
                <?php
                    }
                    echo "</table></div></div>";
                } else {
                    echo "<p class='alert alert-danger'>No hay Becas o Promociones asignadas a éste estudiante.</p>";
                }
                ?>
                </table>
            </div>
        </div>
    <?php endif; ?>