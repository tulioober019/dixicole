<?php

    session_start();

    ob_start();

    require '../req/conbd.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $nome_topico = htmlspecialchars($_POST["engadir-topico-nome"]);

        $id_curso = htmlspecialchars($_POST["engadir-topico-cursoid"]);

        $rol = htmlspecialchars($_POST["rol"]);

        $query = "CALL pro_insertar_topico (\"" . $nome_topico . "\",\"" . $id_curso . "\");";

        mysqli_query($conexion,$query);

        mysqli_close($conexion);

        header("Location: ../session/campus/index.php?curso=" . $id_curso . "&&rol=" . $rol);
    }