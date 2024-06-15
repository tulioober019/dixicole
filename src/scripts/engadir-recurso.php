<?php

    ob_start();

    session_start();
    
    require '../req/conbd.php';

    //$subida_ficheiros = $_SERVER['DOCUMENT_ROOT'] . "/arquivos/curso/";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $nome = $_POST['engadir-recurso-nome']??"";

        $url = $_POST['engadir-recurso-url'];

        $curso = $_POST['engadir-recurso-cursoid']??"";

        //$ruta_destino = $subida_ficheiros . $curso . "/" . basename($path);

        $topico = $_POST["engadir-recurso-topico"]??"";

        #$query = "INSERT INTO tab_recurso SET rec_url = \"" . $ruta_destino . "\", rec_nome = \"" . $nome . "\", rec_ubicacion = \"Local\", rec_topico = " . $topico . ", rec_curso = " . $curso . ");";

        $query = "CALL pro_engadir_recurso (\"" . $url . "\", \"" . $nome . "\", \"URL\", " . $topico . ", " . $curso . ");";
        
        mysqli_query($conexion,$query);

        mysqli_commit($conexion);

        mysqli_close($conexion);
        
        header("Location: ../session/index.php");
    }