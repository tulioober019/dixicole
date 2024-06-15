<?php

    ob_start();

    session_start();



    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $nome_directorio = $_POST["crear-cartafol-nome"];

        $config_file_path_ftp = $_SERVER['DOCUMENT_ROOT'] . "/config.json";

        $datos_ftp = json_decode(file_get_contents($config_file_path_ftp),true)["ftp"];
    
        $ftp = ftp_connect(
            $datos_ftp["ftp_host"],
            $datos_ftp["ftp_connect_port"],
            90
        );
    
        $ftp_user = ftp_login($ftp,$_SESSION["nomeusuario"],$_SESSION["contrasinal"]);
    
        ftp_pasv($ftp, true);

        ftp_mkdir($ftp,$nome_directorio);

        header("Location: ../session/arquivos/index.php");

    }