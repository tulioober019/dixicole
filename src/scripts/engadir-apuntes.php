<?php

    ob_start();

    session_start();
    
    require '../req/conbd.php';

    $subida_ficheiros = $_SERVER['DOCUMENT_ROOT'] . "/arquivos/curso/";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $nome = $_POST['engadir-apuntes-nome']??"";

        $path = $_FILES['engadir-apuntes-path']['name'];

        $curso = $_POST['engadir-apuntes-cursoid']??"";

        $ruta_destino = $subida_ficheiros . $curso . "/" . basename($path);

        $topico = $_POST["engadir-apuntes-topico"]??"";

        move_uploaded_file($_FILES['engadir-apuntes-path']['tmp_name'],$ruta_destino);

        #$query = "INSERT INTO tab_recurso SET rec_url = \"" . $ruta_destino . "\", rec_nome = \"" . $nome . "\", rec_ubicacion = \"Local\", rec_topico = " . $topico . ", rec_curso = " . $curso . ");";

        $query = "CALL pro_engadir_recurso (\"" . "/arquivos/curso/" . $curso .  "/" . basename($path) . "\", \"" . $nome . "\", \"Local\", " . $topico . ", " . $curso . ");";
        
        mysqli_query($conexion,$query);

        mysqli_commit($conexion);

        mysqli_close($conexion);
        
        header("Location: ../session/index.php");
    }