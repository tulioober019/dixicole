<?php

    ob_start();

    session_start();
    
    require '../req/conbd.php';

    //$subida_ficheiros = $_SERVER['DOCUMENT_ROOT'] . "/arquivos/curso/";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $nome = $_POST['engadir-actividade-nome']??"";

        //$path = $_FILES['engadir-apuntes-path']['name'];

        $descricion = $_POST["engadir-actividade-descricion"]??"";

        $curso = $_POST['engadir-actividade-cursoid']??"";

        $topico = $_POST["engadir-actividade-topico"]??"";
        
        $puntuacion = $_POST["engadir-actividade-puntuacion"]??"";
        
        $query = "CALL pro_engadir_actividade (\"" . $nome . "\", \"" . $descricion . "\"," . $puntuacion  . "," . $topico . "," . $curso . ")";

        mysqli_query($conexion,$query);

        mysqli_commit($conexion);

        mysqli_close($conexion);
        
        header("Location: ../session/index.php");
    }