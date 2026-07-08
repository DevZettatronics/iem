<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//require ("determinar_movimiento.php");
require 'plugins/PHPMailer/Exception.php';
require 'plugins/PHPMailer/PHPMailer.php';
require 'plugins/PHPMailer/SMTP.php';

function correo($correo, $pdf)
{


    $mail = new PHPMailer(true);



    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host       = 'mail.zettatronics.com.mx';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'pruebas@zettatronics.com.mx';
    $mail->Password   = 'Pcplus20211+++';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->setFrom('pruebas@zettatronics.com.mx', 'Zettatronics');
    //    $mail->addAddress('y2j97luis@gmail.com', 'Luis');
    $mail->addAddress($correo);
    $mail->isHTML(true);
    $mail->Subject = 'Comprobante de pago';
    $mail->Body    = 'HOLA';
    $mail->addStringAttachment($pdf, 'comprobante.pdf');
    //$mail->addAttachment($pdf);


    if ($mail->send()) {
        echo 'success';
    } else {
        echo $mail->ErrorInfo;
    }
}
