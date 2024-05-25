<?php

    session_start();

    ob_start();

    require '../req/conbd.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $curso = htmlspecialchars($_POST["matricula-curso-codigo"]);

        $query = "CALL pro_matricula (\"" . $_SESSION['id_usuario'] . "\",\"" . $curso . "\");";

        mysqli_query($conexion,$query);

        mysqli_close($conexion);

        header("Location: ../session/index.php");
    }
