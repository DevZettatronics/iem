<?php
if (isset($_GET["opt"]) && $_GET["opt"] == "update") { /*EDICION */
    if (count($_POST) > 0) {
        $a = RecibosData::getById($_POST["id"]);
        $a->alumn_id = $_POST["alumn_id"];
        $a->cantidad = $_POST["cantidad"];
        $a->folio = $_POST["folio"];
        $u = $a->update();
        Core::alert("Se actualizaron los datos");
        Core::redir("./?view=recibos&opt=all");
    }
}
if (isset($_GET["opt"]) && $_GET["opt"] == "del") {/*ELIMINACION  */

    $user = RecibosData::getById($_GET["id"]);
    $user->del();

    Core::redir("./?view=recibos&opt=all");
}


if (isset($_GET["opt"]) && $_GET["opt"] == "validar") {
    $con = Database::getCon();

    $user = RecibosData::getById($_GET["id"]);

    $code = $user->code_user; //codigo de usuario
    
    
    $sql = mysqli_query($con, "select sale_number from sales order by sale_id desc limit 0,1");
			$rw = mysqli_fetch_array($sql);
			$sale_number = $rw['sale_number'];
			$nex_sale_number = $sale_number + 1;
    
    $nombre = PersonData::getByCodeAlumn($code);
    $codeid =  $nombre->id;
    $name = $nombre->name;
    $lastname = $nombre->lastname;
    $fullname = $name . " " . $lastname;
    $email = $nombre->email; //email del alumno 
    $orden = $user->folio; //folio del recibo 
    $total =$user->importe; //cantidad pagada 
    $pp = $user->id_plan; // id del plan de pago 
    $idbeca =  $nombre->beca; //el id de la beca del usuario 
    $idpromo =  $nombre->promocion;
    $beca = BecasData::getById($idbeca);
    $porbeca = $beca->porcentaje;
    $promo = BecasData::getById($idpromo);
    $porcprom =  $promo ->porcentaje;
    $planp = PlandepagoData::getById($pp); //id plan de pago
    $idPerson = $planp->alumno;
    $idprod =  $planp->concepto;
    $cbeca = $planp->cuenta_beca;
    $cprom = $planp->cuenta_promocion;
    $producto =ProductsData::getByIdd($idprod);
    $nproducto = $producto->product_name; //nombre del producto
    $precio = $producto->selling_price;//precio del producto 
    

    if($cprom == "SI" && $cbeca == "SI"){
        $descuento = $porbeca + $porcprom;
        $total = $precio - (( ($precio * ($porbeca / 100) ) ) + ( ($precio * ($porcprom / 100) ) ));
    }
    if($cbeca == "SI" &&  $cprom == "NO"){
        $descuento = $porbeca;
        $total = $precio - ( ($precio * ($porbeca / 100) ) );
    }if($cbeca == "NO" &&  $cprom == "SI"){
        $descuento = $porcprom;
        $total = $precio - ( ($precio * ($porcprom / 100) ) );
    }
    if($cprom == "NO" && $cbeca == "NO"){
        $descuento = 0 ;
        $total = $precio;
    }
   
    //$descuento = floatval($descuento);
    $total = number_format($total,2,'.','');

    //$insert_tabla_pago = mysqli_query($con, "INSERT INTO pagos (name,description,total,tipo_pago,order_id,date_created,email,matricula,status,idPerson) VALUES ('$fullname','$nproducto','$total','DEPOSITO','$orden', 'now()', '$email', '$code','1','$idPerson');");
    $insert_tabla_pago = mysqli_query($con, "INSERT INTO pagos (name, description, total, tipo_pago, order_id, date_created, email, matricula, status, idPerson, id_plan) VALUES ('$fullname', '$idprod', '$total', 'DEPOSITO', '$nex_sale_number', now(), '$email', '$code', '1', '$idPerson', '$pp');");

    $user->validar();
    $jscode = '
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script>
    var person_id = "'.$codeid.'";
    var sale_number = "'. $nex_sale_number.'";
    var taxes = "0";
    var descuento = "'. $descuento.'";
    var monto = "'. $precio.'";
    var payid = "'. $pp.'";
    var pago = "'. $total.'";

    add_sale1(person_id, sale_number, taxes, descuento, monto, payid, pago);

    console.log(person_id);

    function add_sale1(person_id, sale_number, tax, descuento, payablePrice, payid, pago) {
        $.ajax({
            type: "POST",
            url: "./core/app/ajax/add_sale.php",
            data: {
                person_id: person_id,
                sale_number: sale_number,
                tax: tax,
                descuento: descuento,
                payablePrice: payablePrice,
                payid: payid,
                pago: pago
            },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
</script>
    
    ';
    echo $jscode;

    Core::redir("./?view=recibos&opt=all");
} 
?>



<?php
/* Rechazar */
if (isset($_GET["opt"]) && $_GET["opt"] == "rechazar" && isset($_GET["motivo"])) {

    $user = RecibosData::getById($_GET["id"]);
    $user->rechazar($_GET["motivo"]);

    Core::redir("./?view=recibos&opt=all");
}
?>
