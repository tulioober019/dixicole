<?php
    $config_file_path = $_SERVER['DOCUMENT_ROOT'] . "/config.json";

    $datos = json_decode(file_get_contents($config_file_path),true)["db"];

    try {
        $conexion = mysqli_connect(
            $datos["db_host"],
            $datos["db_username"],
            $datos["db_password"],
            $datos["db_database"],
            $datos["db_port"]
        );

    } catch (Exception $e) {
        echo "<p>" . $e->getMessage() . "</p>";
    }