<style type="text/css">

    .uni {

        color: #002976;

        font-family: Times, serif;

        margin: 5;

    }



    .conte-general {

        font-size: 12px;

        position: absolute;

    }



    .conte-calificaciones {

        font-size: 10px;

        border-collapse: separate;

    }



    .general {

        font-size: 9px;

    }



    .img {

        width: 20%;

        height: 25%;

        display: inline-flex;

    }



    .img1 {

        width: 35%;

        height: 25%;

        display: inline-flex;

    }



    .test {

        top: -70;

        margin: 0;

        padding: 0;

        position: relative;

    }



    .title {

        margin-top: 50px;

        text-align: center;

    }



    .image {

        position: absolute;

        top: 0;

        right: 15;

        float: right;

        width: 20%;

        height: 110%;

    }



    .image1 {

        position: absolute;

        top: 55;

        left: 5;

        float: left;

        width: 20%;

        height: 125%;

    }



    .image2 {

        width: 100%;

        height: 100%;

    }



    .td_tittle {

        padding: -3px;

        padding-left: 25px;

    }



    .table1 {

        font-size: 12px

    }



    .footer {

        position: fixed;

        border-top: solid 1px #000;

    }



    .contet {

        height: 100px;

    }



    table {

        border-collapse: separate;

    }

</style>



<!-- NA y NP se deberan quitar -->





<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm" style="font-size: 12px; font-family: helvetica ;" backimg="">

    <page_footer pageset="old" class="footer">

        <div style="margin-bottom:20px;border-top: solid 1px #000;text-align: center">

            <p style="font-size: 8px;">Documento de indole informativo, sin validez oficial.</p>

            <p style="font-size: 9px; margin:0px; padding:0px;">Herschel 143, Col. Nueva Anzures, Alc. Miguel Hidalgo, Ciudad de México CP 11590.</p>

            <p style="font-size: 9px;">Línea Gestalt (55)5203 2008&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CAMPUS POLANCO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;www.ugestalt.edu.mx</p>

        </div>

    </page_footer>



    <?php



    /* va el fondo si existe de la pagina  */

    $sql = "SELECT * FROM person WHERE id ='$id'";

    $query = mysqli_query($con, $sql);

    $num = mysqli_num_rows($query);

    if ($num == 1) {

        $rw = mysqli_fetch_array($query);

        $email = $rw['email'];

        if (empty($curp = $rw['curp'])) {

            $curp = "-";

        } else {

            $curp = $rw['curp'];

        }

        $date_added = $rw['created_at'];

        // list($date, $hora) = explode(" ", $date_added);

        // list($Y, $m, $d) = explode("-", $date_added);

        // echo $fecha = $d . "/" . $m . "/" . $Y;

        //nueva forma ... traia la hora despues del dia el codigo de arriba.



        $fecha = date('d/m/Y', strtotime($date_added));

        $hora = date('H:i:s', strtotime($date_added));

    }



    //INICIO $sql1 ES EL QUE ORDENA Y TRE LA MAYORIA DE INFORMACION 

    $sql1 = "SELECT p.code code,p.name,period.name semestre,

	asignature.name materia,cf.calificacion,cf.observaciones,

	asignature.program,asignature.credito,

	team.grade,program.nc siglas,program.no_rvoe,program.frvoe,asignature.grado,program.periodo_academico,team.id_identifica

	FROM calificaciones_finales cf 

	INNER JOIN person p	ON   cf.person_id = p.id

	INNER JOIN asignation asig ON  cf.asignation_id = asig.id

	INNER JOIN period ON  period.id = asig.period_id 

	INNER JOIN asignature ON  asig.asignature_id = asignature.id

	INNER JOIN team	ON  team.id = asig.team_id and team.id_identifica = '103'

	INNER JOIN program	ON  team.id_program = program.id	

		

	-- where cf.person_id=$id and (cf.calificacion>=5 || cf.calificacion='AC' ) EN TODAS LAS CONSULTAS SE CAMBIO AL DE ABAJO, ESTO EVITA LOS LLAMADOS DE LAS ASIGANTURAS QUE NO TIENEN VALOR NUMERICO Y SON DE LETRAS	

	where cf.person_id=$id and (cf.calificacion>=5 || cf.calificacion=0 || cf.calificacion='AC') 

	order by asignature.grado,asignature.name asc";



    $query1 = mysqli_query($con, $sql1);

    // FIN$sql1



    //INICIO $sqlt Se repite para evitar el problema de que al momento de usar el msqli_fecht_array contara uno y en la vista no lo mostrara.

    $sqlt = "SELECT

	asignature.name materia,cf.calificacion,

	asignature.program,asignature.credito,

	team.grade,program.nc siglas,program.no_rvoe,program.frvoe,asignature.grado,program.id as id_program,team.id_identifica

	FROM calificaciones_finales cf 

	INNER JOIN person p	ON   cf.person_id = p.id

	INNER JOIN asignation asig ON  cf.asignation_id = asig.id

	INNER JOIN period ON  period.id = asig.period_id 

	INNER JOIN asignature ON  asig.asignature_id = asignature.id

	INNER JOIN team	ON  team.id = asig.team_id	and team.id_identifica = '103'

	INNER JOIN program	ON  team.id_program = program.id

		

	where cf.person_id=$id and (cf.calificacion>=5 || cf.calificacion=0 || cf.calificacion='AC')

	order by asignature.grado,asignature.name asc";

    // FIN $sqlt

    $queryt = mysqli_query($con, $sqlt);

    $rwt = mysqli_fetch_array($queryt);



    if (empty($rwt['grade'])) {

        $programa = "-";

    } else {

        $programa = $rwt['grade'];

        $programa = str_replace(

			array('Ã³', 'Ã±', 'Ã­'),

			array('ó', 'ñ',  'í'), $programa);

    }

    if (empty($rwt['siglas'])) {

        $siglas = "-";

    } else {

        $siglas = $rwt['siglas'];

    }

    if (empty($rwt['no_rvoe'])) {

        $rvoe = "-";

    } else {

        $fecha_r = date("d/m/Y",  strtotime($rwt['frvoe']));

        $rvoe = $rwt['no_rvoe'] . " " . $fecha_r;

    }



    $idprograma = $rwt['id_program'];



    //PROMEDIO Y CONTADOR DE CALIFICACION

    $s = "SELECT count(*) contador, AVG(cf.calificacion) promedio

	FROM calificaciones_finales cf 

	INNER JOIN person p	ON   cf.person_id = p.id

	INNER JOIN asignation asig ON  cf.asignation_id = asig.id

	INNER JOIN period ON  period.id = asig.period_id 

	INNER JOIN asignature ON  asig.asignature_id = asignature.id

	INNER JOIN team	ON  team.id = asig.team_id and team.id_identifica = '103'

	INNER JOIN program	ON  team.id_program = program.id

	where cf.person_id=$id and (cf.calificacion>=5);";

    $q = mysqli_query($con, $s);

    $qq = mysqli_fetch_array($q);

    $contador = $qq['contador'];

    $promedio = $qq['promedio'];



    $pro = sprintf("%.2f", $promedio);





     //CONTADOR DE TOTAL DE ASIGNATURAS

     $sql_asig = "SELECT count(*) totalAsign FROM program

     inner join asignature on asignature.id_program=program.id

     where program.id=$idprograma ";

 

     $total_asign = mysqli_query($con, $sql_asig);

     $rw_total_as = mysqli_fetch_array($total_asign);

     $total_asignaturas = number_format($rw_total_as['totalAsign']);





    //CONTADOR DE TOTAL DE CREDITOS

    $sql_tcre = "SELECT sum(asignature.credito) as totalCreditos

	from program

	inner join asignature on asignature.id_program=program.id

	where program.id=$idprograma ";



    $t_credito = mysqli_query($con, $sql_tcre);

    $rw_tcredi = mysqli_fetch_array($t_credito);

    $t_contador_cre = number_format($rw_tcredi['totalCreditos'], 2);





    //CONTADOR DE CREDITOS ACTUALES

    $sql_cre = "SELECT

	sum(asignature.credito) sumacredito

	FROM calificaciones_finales cf 

	INNER JOIN person p	ON   cf.person_id = p.id

	INNER JOIN asignation asig ON  cf.asignation_id = asig.id

	INNER JOIN period ON  period.id = asig.period_id 

	INNER JOIN asignature ON  asig.asignature_id = asignature.id

	INNER JOIN team	ON  team.id = asig.team_id and team.id_identifica = '103'

	INNER JOIN program	ON  team.id_program = program.id	

		

	where cf.person_id=$id and (cf.calificacion>=5 ) 

	order by asignature.grado,asignature.name asc";



    $a_credito = mysqli_query($con, $sql_cre);

    $rw_acredi = mysqli_fetch_array($a_credito);

    $a_contador_cre = number_format($rw_acredi['sumacredito'], 2);





    // //ESTA FUNCION PERMITE HACER DE NUMERO A LETRA se comenta por posible error en local en UAT si funciona

    $formatterES = new NumberFormatter("es-ES", NumberFormatter::SPELLOUT);

    $n = $promedio;

    $izquierda = intval(floor($n));

    $derecha = round(($n - floor($n)) * 100);

    $h = "(" . $formatterES->format($izquierda) . " punto " . $formatterES->format($derecha) . ")";

    ?>



    <!-- General -->

    <div class="test">

        <div class="image1">

            <img style="width: 98%; height: 100%;" src="https://viserion.gestalt.education/admin/core/app/view/j/img/gesdos.png">

        </div>

        <div class="title">

            <h3 class="uni"></h3>

            <h4 class="uni" style="font-size: 14px">DIRECCIÓN GENERAL DE SERVICIOS ESCOLARES</h4>

            <h4 class="uni">HISTORIAL ACADÉMICO</h4>

            <h5 style="padding: 0px; margin:0px; font-size: 10.5px;"><?php echo $programa ?></h5>

        </div>

        <div class="image">

            <img style="width: 100%; height: 100%;" class="img1" src="https://viserion.gestalt.education/admin/core/app/view/j/img/gesuno.jpg">

        </div>

    </div>

    <table align="center" style="position: relative; margin-left: 15px; margin-top: 8px;">

        <tr class="table1">

            <td class="td_tittle">

                <p style="grid-area: cuenta;"> No de Cuenta: <b><?php echo $code ?></b> </p>

            </td>

            <td class="td_tittle" style="padding-left: 75px">

                <p style="grid-area: nombre;"> Nombre: <b><?php echo $lastname ?>&nbsp;<?php echo $name ?> </b></p>

            </td>

        </tr>

        <tr class="table1">

            <td class="td_tittle">

                <p style="grid-area: nombre;"> Programa: <b><?php echo $siglas ?> </b></p>

            </td>

            <td class="td_tittle">

                <p style="grid-area: nombre; padding-left: 50px"> CURP: <b><?php echo $curp ?> </b></p>

            </td>

        </tr>

        <tr class="table1">

            <td class="td_tittle">

                <p style="grid-area: nombre;"> RVOE: <b><?php echo $rvoe  ?> </b></p>

            </td>

            <td class="td_tittle">

                <p style="grid-area: nombre; padding-left: 50px"> Fecha de ingreso: <b><?php echo $fecha ?> </b></p>

            </td>

        </tr>

    </table>



    <!-- Calificacion -->

    <table class="conte-calificaciones" style="width: 100%;top:175px;padding-bottom: 20px;position:absolute;padding-bottom:200px" align='center'>

        <thead>

            <tr>

                <th style="width: 45%; text-align: center; border-top: solid 2px #000; border-bottom: solid 2px #000;background: #FFF; padding: 10px;">Asignatura</th>

                <th style="width: 7%; text-align: center; border-top: solid 2px #000; border-bottom: solid 2px #000;background: #FFF">Créditos</th>

                <th style="width: 13%; text-align: center;  border-bottom: solid 2px #000;background: #FFF; padding: 5px;">Ciclo</th>

                <th style="width: 10%; text-align: center; border-top: solid 2px #000; border-bottom: solid 2px #000;background: #FFF">Calificación <br> Final</th>

                <th style="width: 10%; text-align: center;border-bottom: solid 2px #000;background: #FFF">Calificación <br>en Letra</th>

                <th style="width: 10%; text-align: center; border-top: solid 2px #000; border-bottom: solid 2px #000;background: #FFF">Observaciones</th>
            </tr>

        </thead>

        <tbody>

            <?php

            error_reporting(0); //remove to see the error

            while ($rw1 = mysqli_fetch_array($query1)) {

                $materia = $rw1['materia'];
                $observaciones = $rw1['observaciones'];
                $d = explode('_', $materia);

                $d1 = $d[0];

                // $d2 = $d[1];

                $d2= str_replace(

					array('Ã', 'Ã“', 'Ã‰', 'Ãš', 'ÃƒÂ', 'Ãƒâ€œ', 'Ã'),

					array('Í', 'Ó', 'É', 'Ú', 'Í', 'Ó', 'Á'), $d[1]);

                $d3 = substr($d[0], -3);

                if (!isset($d1) or !isset($d2)) {



                    $calificacion = "";

                }



                // $periodo_num = $d3[0];

                $periodo_num = $rw1['grado'];

                $calificacion = $rw1['calificacion'];

                $semestre = $rw1['semestre'];

                $c = explode(' ', $semestre);

                $m = $c[0];

                $m1 = $c[1];

                $ciclo = substr($m, 0, 1) . "" . $m1;

                $periodo = $rw1['periodo_academico'];

                $credito = $rw1['credito'];



                $sqlTest = "SELECT

				count(asignature.name) materia

				FROM calificaciones_finales cf 

				INNER JOIN person p	ON   cf.person_id = p.id

				INNER JOIN asignation asig ON  cf.asignation_id = asig.id

				INNER JOIN period ON  period.id = asig.period_id 

				INNER JOIN asignature ON  asig.asignature_id = asignature.id

				INNER JOIN team	ON  team.id = asig.team_id and team.id_identifica = '103'

					

					where cf.person_id=$id and (cf.calificacion>=5) 

				order by asignature.grado";



            ?>

                <tr style="position: absolute;">

                    <td style="width: 45%; text-align: left;font-size:7px; ">

                        <?php

                        // $sql_program=mysqli_query(Database::getCon(),"SELECT periodo_academico FROM program inner join team where  program.name = '$programa' and (program.id=team.program_id);");

                        // $row=mysqli_fetch_array($sql_program);



                        if ($periodo_num == $nuevo_periodo) {

                            $periodo_num = "";

                            $relleno = "";

                        } else {

                            $nuevo_periodo = $periodo_num;

                            if (($nuevo_periodo * $nuevo_periodo) == 0) {

                                $d6 = "Complementaria";

                            } else {

                                $d6 = ucwords(strtolower($periodo)) . " " . $periodo_num . "°";

                            }

                            $m4 = "<p style='padding:0;margin:0; margin-left:25px;font-size:12px'><b><br>$d6</b></p>";

                            $relleno = "<p></p>";

                            echo $m4;

                        } ?>

                        <table style="width: 45%; text-align: left; ">



                            <td>

                                <p style="font-size: 8px;text-align:left;"><?php echo $d1 ?></p>

                            </td>

                            <td style="width: 350px">

                                <p style="font-size: 8px;text-align:left;"><?php echo $d2 ?></p>

                            </td>





                        </table>

                    </td>

                    <td style="width: 7%; text-align: center;">

                        <?php echo $relleno; ?>

                        <p style="font-size: 8px;text-align:center;"><?php echo number_format($credito, 2) ?></p>

                    </td>

                    <td style="width: 13%; text-align: center;">

                        <?php echo $relleno; ?>

                        <p style="font-size: 8px"><?php echo $ciclo ?></p>

                    </td>

                    <td style="width: 10%; text-align: center;">

                        <?php echo $relleno; ?>

                        <?php if ($calificacion == '0') {

                            $calificacion = 'NP';

                        } ?>

                        <p style="font-weight: bold; font-size: 8px"><?php echo $calificacion; ?></p>

                    </td>

                    <td style="width: 10%; text-align: center;">

                        <?php echo $relleno; ?>

                        <?php switch ($calificacion) {

                            case '5':

                                $letra = "CINCO";

                                break;

                            case '6':

                                $letra = "SEIS";

                                break;

                            case '7':

                                $letra = "SIETE";

                                break;

                            case '8':

                                $letra = "OCHO";

                                break;

                            case '9':

                                $letra = "NUEVE";

                                break;

                            case '10':

                                $letra = "DIEZ";

                                break;

                            case 'NP':

                                $letra = "NO PRESENTO";

                                break;

                            case 'NA':

                                $letra = "NO ACREDITÓ";

                                break;

                            case 'AC':

                                $letra = "ACREDITADO";

                                break;

                            case '1' || '2' || '3' || '4':

                                $letra = "";

                                break;

                            default:

                                $letra = "-";

                                break;

                        } ?>

                        <p style="font-weight: bold"><?php echo $letra ?></p>

                    </td>
                    <td style="width: 5%; text-align: center;">
                        <?php echo $relleno; ?>
                       
						
                        <p>     
                            <?php 
                                if ($observaciones == 0) {
                                    
                                    echo "OR" ;
									
                                } else if ($observaciones == 1){
                                    echo "EE";
                                } else if ($observaciones == 2){
                                    echo "REV";
                                }
                            ?>
                        </p>
                    </td>
                    
                </tr>

            <?php

            }

            ?>

        </tbody>

    </table>

    <div style="position:absolute; bottom:50px; left:5%">

        <!-- CAMBIAR A RELATIVE PARA OTRO TIPO DE ACOMODO -->

        <table>

            <tr>

                <td>

                    <p style="font-size:10px;margin-left:45;text-align:left;">TOTAL DE ASIGNATURAS PRESENTADAS: <?php echo $contador . " de " . $total_asignaturas ?>.</p>

                </td>

                <td>

                    <p style="font-size:10px;margin-left:-320px;text-align:rigth; font-weight: bold;">PROMEDIO: <b><?php echo  $pro . " " ?> <?php echo strtoupper($h) ?></b> </p>

                    <p style="font-size:10px;margin-left:-320px;text-align:rigth; font-weight: bold;">Creditos :<?php echo $a_contador_cre . " de " . $t_contador_cre ?> </p>

                </td>

            </tr>

            <tr>

                <td>

                    <p style="margin-top: 3px;font-size:10px;margin-left:45px;text-align:rigth;">* La escala de calificaciones es de 5 (cinco) a 10 (diez) y la minima aprobatoria es de 8 (ocho).</p>

                </td>

            </tr>

            <tr>

                <td>

                    <p style="margin-top: 3px;font-size:10px;margin-left:45px;text-align:rigth;">* Las asignaturas cursadas en otras instituciones educativa y validada por la SEP se anotarán con la abreviatura REV en el ciclo.</p>

                </td>

            </tr>

            <tr>

                <td style="font-weight: bold">

                    <p style="font-size:10px;text-align:rigth;">PROGRAMA: <?php echo $programa ?></p>

                </td>

                <td style="text-align: right; font-weight: bold">

                    <p style="font-size:10px;margin-left: -100px;text-align:rigth;">RVOE SEP: <?php echo $rvoe ?></p>

                </td>

            </tr>

            <tr>

                <td style="font-size:10px;">

                    <p style="margin-left: 150px;">SE EXPIDE LA PRESENTE PARA LOS FINES QUE AL INTERESADO CONVENGAN</p>

                </td>

            </tr>

            <tr>

                <td>FECHA DE EMISIÓN:</td>

            </tr>

        </table>

        <?php

        //starts cotization date

        $diassemana = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");

        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        $dateCot = $rw['fecha_cotizacion'];

        $year =  date('Y');

        $dayofweek = date('w');

        $day = date('d');

        $month = (date('m')) - 1;



        ?>

        <p style="margin:0;font-weight: bold;font-size:10px;">Ciudad de México a: <?php echo $day; ?> de <?php echo $meses[$month]; ?> de <?php echo $year; ?></p>

    </div>

</page>