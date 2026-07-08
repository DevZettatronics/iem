<?php
session_start();

//var_dump($_SERVER["REQUEST_URI"]);

require("../plugins/PHPMailer/Exception.php");
require("../plugins/PHPMailer/PHPMailer.php");
require '../plugins/PHPMailer/SMTP.php'; // para local
?>
<script src="https://code.jquery.com/jquery-latest.js"></script>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// get the HTML
ob_start();

/* conexion a la base de datos*/
include("./config/db.php");
include("./config/conexion.php");

if (isset($_GET["tmp"])) {
    $id_tmp = $_GET['tmp'];
 
    $sel = mysqli_query($con, "SELECT * FROM sales where sale_id = $id_tmp");
    $datos_persona = mysqli_fetch_array($sel);
    $id_persona = $datos_persona['person_id'];

    $query_socio = mysqli_query($con, "SELECT * FROM person WHERE id ='" . $id_persona . "'");
    $rw_socio = mysqli_fetch_array($query_socio);

    $name_s = $rw_socio['name'];
    $correo = $rw_socio['email'];
    $date_added = $rw_socio['created_at'];

    $body = $name_s . " Este correo es envíado automáticamente porque se realizó la factura de una compra que realizaste.
    </br></br> En este correo puedes encontrar el ticket de la compra. Un saludo, Gestalt </br>";

    try {
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        //$mail->isSMTP(); //estaba comentado se descomenta para local        
        $mail->Host = 'mail.zettatronics.com.mx';
        $mail->SMTPAuth = true;
        $mail->Username = 'soporte@zettatronics.com.mx'; //correo desde donde se va enviar  soporte@zettatronics.com.mx
        $mail->Password = 'Zettapc2245++2020'; //contraseña del correo Zettapc2245++2020
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 465; //465

        $mail->setFrom('soporte@zettatronics.com.mx', 'Ticket de compra');
        $mail->addAddress($correo);

        //$mail->addAttachment("./tim/new-sale-ticket-pdf.php");
        $mail->isHTML(true);
        $mail->Subject = utf8_decode('Ticket de Compra.');
        $mail->Body = 'Buen día ' . $body;        
        //$mail->addAttachment($pdf_auxiliar);// AQUÍ VA EL ARCHIVO A ADJUNTAR AL CORREO
        $mail->send();

        $messages[] = '¡Correo Enviado!';
    } catch (Exception $errors) {
        $errors[] = "Message could not be sent. Mailer Error: " . ($mail->ErrorInfo);
    }
    error_log(var_dump($errors));
    error_log(var_dump($messages));
    error_log(var_dump($warnings));
    error_log(var_dump($correo));
    if (isset($errors)) { ?>
        <script> mini_alerta('error', '<?php foreach ($errors as $error) { echo '<strong>¡Error! </strong>' . $error; } ?>')</script>
    <?php
    }
    if (isset($messages)) { ?>
        <script>mini_alerta('success', '<?php foreach ($messages as $message) { echo '<strong>¡Bien! </strong>' . $message; } ?>')</script>
        <?php
    }
    if (isset($warnings)) { ?>
        <script>mini_alerta('warning', '<?php foreach ($warnings as $warning) { echo '<strong>¡Aviso! </strong>' . $warning; } ?>')</script>
        <?php
    }
}
?>