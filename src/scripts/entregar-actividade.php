<?php

    ob_start();

    session_start();
    
    require '../req/conbd.php';

    $subida_ficheiros = $_SERVER['DOCUMENT_ROOT'] . "/arquivos/usuario/";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $nome = $_POST['entregar-actividade-nome']??"";

        $path = $_FILES['entregar-actividade-path']['name'];

        $act_id = $_POST['entregar-actividade-id'];

        $ruta_destino = $subida_ficheiros . $_SESSION["id_usuario"] . "/" . basename($path);

        move_uploaded_file($_FILES['entregar-actividade-path']['tmp_name'],$ruta_destino);

        #$query = "INSERT INTO tab_recurso SET rec_url = \"" . $ruta_destino . "\", rec_nome = \"" . $nome . "\", rec_ubicacion = \"Local\", rec_topico = " . $topico . ", rec_curso = " . $curso . ");";

        $query = "CALL pro_entregar_actividade (" . $_SESSION["id_usuario"] . "," . $act_id . "," . "\"/arquivos/usuario/" . $_SESSION["id_usuario"] . "/" . $path . "\");";
        
        #mysqli_query($conexion,$query);

        #mysqli_commit($conexion);

        #mysqli_close($conexion);
        
        #header("Location: ../session/index.php");

        mysqli_query($conexion,$query);

        mysqli_commit($conexion);

        mysqli_close($conexion);
        
        header("Location: ../session/index.php");
    }