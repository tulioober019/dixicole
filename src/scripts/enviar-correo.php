<?php

    session_start();

    ob_start();

    $config_file_path_ftp = $_SERVER['DOCUMENT_ROOT'] . "/config.json";

    $datos_smtp = json_decode(file_get_contents($config_file_path_ftp),true)["smtp"];

    /*use PHPMailer\PHPMailer\PHPMailer;

    use PHPMailer\PHPMailer\Exception;

    use PHPMailer\PHPMailer\SMTP;*/

    require '../vendor/autoload.php';



    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $destinatario = $_POST["enviar-correo-destinatario"];

        $asunto = $_POST["enviar-correo-asunto"];

        $mensaxe = $_POST["enviar-correo-mensaxe"];

        $cabeceras = "From: " . $_SESSION["nomeusuario"] . "@mail.dixicole.gal \r\n";
        
        $cabeceras .= "Reply-To: " . $destinatario . "\r\n";

        $cabeceras .= "X-Mailer: PHP/" . phpversion();

        /*$mail = new PHPMailer(true);

        // MAIL AUTH SETTINGS 

        $mail->SMTPDebug = 5;                   // Enable verbose debug output

        $mail->isSMTP();                        // Set mailer to use SMTP

        $mail->Host       = $datos_smtp["smtp_host"];    // Specify main SMTP server

        $mail->SMTPAuth   = true;               // Enable SMTP authentication

        $mail->Username   = $_SESSION["nomeusuario"] . "@" . $datos_smtp["smtp_host"];     // SMTP username

        $mail->Password   = $_SESSION["contrasinal"];         // SMTP password

        $mail->SMTPSecure = '';              // Enable TLS encryption, 'ssl' also accepted

        $mail->SMTPAutoTLS = false;

        $mail->Port       = $datos_smtp["smtp_port"];                // TCP port to connect to


        // MAIL SEND SETTINGS

        $mail->setFrom($_SESSION["nomeusuario"] . "@" . $datos_smtp["smtp_host"], $_SESSION["apelido1"] . " " . $_SESSION["apelido2"] . ", " . $_SESSION["nome"]);           

        $mail->addAddress($destinatario);
        
        $mail->isHTML(true);               

        $mail->Subject = $asunto;

        $mail->Body    = $mensaxe;

        $mail->AltBody = $mensaxe;

        $mail->send();*/

        mail($destinatario,$asunto,$mensaxe,$cabeceras);

        header("Location: ../session/mail/index.php");
    }