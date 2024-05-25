<?php

    session_start();

    ob_start();

    require '../req/conbd.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $nome_curso = htmlspecialchars($_POST["engadir-curso-nome"]);

        $descricion_curso = htmlspecialchars($_POST["engadir-curso-descricion"]);

        $query = "CALL pro_engadir_curso (\"" . $nome_curso . "\",\"" . $descricion_curso . "\",\"" . $_SESSION['id_usuario'] . "\",\"asdlask\");";

        mysqli_query($conexion,$query);

        mysqli_close($conexion);

        header("Location: ../session/index.php");
    }
