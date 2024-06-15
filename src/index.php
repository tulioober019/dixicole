<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/form.css">
    <script>
        function amosarFormularioLogin() {
            const formulario = document.getElementById("iniciar-session");
            const iniciarSession = document.getElementById("form-iniciar-session");
            iniciarSession.addEventListener("click", function(){
                formulario.style.display = "block";
            });
        }

        function agacharFormularioLogin() {
            const formulario = document.getElementById("iniciar-session");
            addEventListener("click",function(){
                formulario.style.display = "none";
            });
        }
    </script>
    <title>Dixicole</title>
</head>
<body>
    <?php 
        require 'req/conbd.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $login = htmlspecialchars($_POST["iniciar-session-login"],ENT_QUOTES,'UTF-8');

            $contrasinal_sen_hash = htmlspecialchars($_POST["iniciar-session-contrasinal"],ENT_QUOTES,'UTF-8'); // Vaise utilizar para autheticar contra os outros servizos.

            $contrasinal_con_hash = hash("sha512",$contrasinal_sen_hash);

            $query = "SELECT * FROM vis_usuario WHERE usu_nomeusuario = \"" . $login . "\" AND usu_contrasinal = \"" . $contrasinal_con_hash . "\";";

            $data_usuario = mysqli_fetch_all(mysqli_query($conexion, $query),MYSQLI_ASSOC);

            if (sizeof($data_usuario) == 1) {

                session_start();

                $_SESSION["id_usuario"] = $data_usuario[0]["usu_id"];

                $_SESSION["nomeusuario"] = $data_usuario[0]["usu_nomeusuario"];

                $_SESSION["contrasinal"] = $contrasinal_sen_hash;

                $_SESSION["nome"] = $data_usuario[0]["usu_nome"];

                $_SESSION["apelido1"] = $data_usuario[0]["usu_apelido1"];

                $_SESSION["apelido2"] = $data_usuario[0]["usu_apelido2"];
    
                header("Location: /session/index.php");
    
            }
    
            else {
                ?>
                    <style>
                        .form-modal {
                            display: block;
                        }
                    </style>
                    <header>
                        <div class="header-left">
                            <h1>Dixicole</h1>
                            <p>Unha educación para todos</p>
                        </div>
                        <div class="header-right">
                            <button id="form-iniciar-session">Iniciar sessión</button>
                        </div>
                    </header>
                    <nav>
                        <ul class="navbar">
                            <li>
                                <a>Portada</a>
                            </li>
                            <li>
                                <a href="./rexistro/index.php">Rexístrate</a>
                            </li>
                            <li>
                                <a>Axuda</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="form-modal" id="iniciar-session">
                        <h2>Iniciar Sessión</h2>
                        <form action="" method="post">
                            <div class="form-modal-row">
                                <label>Nome do usuario:</label>
                                <input name="iniciar-session-login" id="iniciar-session-login" type="text">
                            </div>
                            <div class="form-modal-row">
                                <label>Contrasinal:</label>
                                <input name="iniciar-session-contrasinal" id="iniciar-session-contrasinal" type="password">
                            </div>
                            <div class="form-modal-row">
                                <p class="auth-error">Usuario ou contrasinal incorrectos. Intente de novo!</p>
                            </div>
                            <div class="form-modal-row">
                                <button name="iniciar-session-submit" id="iniciar-session-submit" type="submit">Iniciar sessión</button>
                            </div>
                        </form>
                    </div>
                <?php
            }
                
        }
        else {
    ?>
    <header>
        <div class="header-left">
            <h1>Dixicole</h1>
            <p>Unha educación para todos</p>
        </div>
        <div class="header-right">
            <button id="form-iniciar-session">Iniciar sessión</button>
        </div>
    </header>
    <nav>
        <ul class="navbar">
            <li>
                <a>Portada</a>
            </li>
            <li>
                <a href="./rexistro/index.php">Rexístrate</a>
            </li>
            <li>
                <a>Axuda</a>
            </li>
        </ul>
    </nav>
    <div class="form-modal" id="iniciar-session">
        <h2>Iniciar Sessión</h2>
        <form action="" method="post">
            <div class="form-modal-row">
                <label>Nome do usuario:</label>
                <input name="iniciar-session-login" id="iniciar-session-login" type="text">
            </div>
            <div class="form-modal-row">
                <label>Contrasinal:</label>
                <input name="iniciar-session-contrasinal" id="iniciar-session-contrasinal" type="password">
            </div>
            <div class="form-modal-row">
                <button name="iniciar-session-submit" id="iniciar-session-submit" type="submit">Iniciar sessión</button>
            </div>
        </form>
    </div>
    <script>
        amosarFormularioLogin();
    </script>
    <?php }
    mysqli_close($conexion);
    ?>
</body>
</html>