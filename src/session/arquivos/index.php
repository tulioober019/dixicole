<?php 
    session_start();

    ob_start();

    require '../../req/conbd.php';

    $config_file_path_ftp = $_SERVER['DOCUMENT_ROOT'] . "/config.json";

    $datos_ftp = json_decode(file_get_contents($config_file_path_ftp),true)["ftp"];

    $ftp = ftp_connect(
        $datos_ftp["ftp_host"],
        $datos_ftp["ftp_connect_port"],
        90
    );

    $ftp_user = ftp_login($ftp,$_SESSION["nomeusuario"],$_SESSION["contrasinal"]);

    ftp_pasv($ftp, true);

    $ftp_path = ftp_pwd($ftp);

    //$contidos_ftp = ftp_rawlist($ftp,$ftp_user_path);
    function tipo_de_arquivo(string $tipo) {
        $tipo = '';
        if (substr($tipo,0,1) == 'd') { 
            $tipo = 'DIRECTORIO';
        }

        else if (substr($tipo,0,1) == '') {
            $tipo = 'ARQUIVO';
        }

        return $tipo;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/global.css">
    <title>Dixicole</title>
    <!--<script src="../../js/iframe.js"></script>-->
    <link rel="stylesheet" href="../../css/campus.css">
    <link rel="stylesheet" href="../../css/form.css">
    <script>
        /*function amosarMenu() {
            const menuDesplegable = document.getElementById("menu-cursos");
            const boton = document.getElementById("boton-menu-cursos");
            
            boton.addEventListener("mouseover",function(e) {
                menuDesplegable.style.display = "block";
            });
        }

        function pecharMenu() {
            const menuDesplegable = document.getElementById("menu-cursos");
            const boton = document.getElementById("boton-menu-cursos");
            
            boton.addEventListener("click",function(e) {
                menuDesplegable.style.display = "none";
            });
        }
        */
        function amosarFormularioCrearCartafol() {
            const formulario = document.getElementById("crear-cartafol");
            const opcion = document.getElementById("opcion-crear-cartafol");
            opcion.addEventListener("click", function(){
                formulario.style.display = "block";
            });
        }

        function amosarFormularioSubirFicheiro() {
            const formulario = document.getElementById("subir-fichero");
            const opcion = document.getElementById("opcion-subir-fichero");
            opcion.addEventListener("click", function(){
                formulario.style.display = "block";
            });
        }
        /*
        function amosarFormularioMatricula() {
            const formulario = document.getElementById("matricula-curso");
            const matriculaCurso = document.getElementById("opcion-matricula-curso");
            matriculaCurso.addEventListener("click", function(){
                formulario.style.display = "block";
            });
        }*/

        /*function amosarCorreoElectronico() {
            const correos   = Array.from(document.getElementsByClassName("mail-listing"));
            const contidoCorreos    = Array.from(document.getElementsByClassName("mail-content"));

            correos.forEach(correo => {
                contidoCorreos.forEach(contidoCorreo => {

                    if (contidoCorreo.id == correo.id) {

                        correo.addEventListener("click", function(e) {

                            contidoCorreos.forEach(mensaxeAOcultar => {
                                mensaxeAOcultar.style.display = "none";
                            });

                            contidoCorreo.style.display = "block";
                        });
                    } else if (contidoCorreo.id == 1) {
                        contidoCorreo.style.display = "block";
                    }
                });
            });
        }*/

    </script>
</head>
<body>
    <header>
        <div class="header-left">
            <h1>Servizo de transferencia de arquivos de Dixicole</h1>
            <p>Benvido <?php echo $_SESSION["apelido1"] . " " . $_SESSION["apelido2"] . ", " . $_SESSION["nome"];?></p>
        </div>
        <div class="header-right">
            <img src="../../icons/user.svg" alt="user-logo" id="user-logo">
        </div>
    </header>
    <nav>
        <ul class="navbar">
            <li>
                <a>Buscar contido</a>
            </li>
            <li id="opcion-subir-fichero">
                <a>Subir ficheiro</a>
            </li>
            <li id="opcion-crear-cartafol">
                <a>Crear directorio</a>
            </li>
        </ul>
    </nav>
    <?php 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $tipo = explode(":",$_POST["entrada"])[0];

            $nome = explode(":",$_POST["entrada"])[1];

            if ($tipo == "d") {

                $dire = $ftp_path . "/" . $nome;

                ftp_chdir($ftp, $dire);

                $ftp_path = ftp_pwd($ftp);

            }

            else if ($tipo == "-") {

                ftp_get($ftp, $_SERVER['DOCUMENT_ROOT'] . "/download" . "/" . $nome, $nome, FTP_BINARY, 0);

            }
        }
    ?>
    <section id="arquivos" name="arquivos" class="arquivos">
        <form method="post" action="">
        <div class="arquivo-view">
        <?php 
            $ftp_arquivos = ftp_rawlist($ftp, $ftp_path);

            foreach ($ftp_arquivos as $arquivo) {

                $arquivo_data = array_filter(explode(" ",$arquivo));

                $tipo_arquivo = substr($arquivo_data[0],0,1);
                    
                $nome_arquivo = $arquivo_data[26];

                ?>
                    <button type="submit" name="entrada" value="<?php echo $tipo_arquivo;?>:<?php echo $nome_arquivo;?>" class="elemento">
                        <?php 
                        if ($tipo_arquivo == "d") {
                            ?>
                            <img src="folder.png">
                            <?php
                        }
                        else if ($tipo_arquivo == "-") {
                            ?>
                            <img src="documento.png">
                            <?php
                        }
                        ?>
                        <p><?php echo $nome_arquivo;?></p>
                    </button>
                <?php

            }

            ?>
        </div>
        </form>
    </section>
    <div class="form-modal" id="subir-fichero">
        <h2>Nova carpeta</h2>
        <form action="../../scripts/subir-fichero.php" method="post">
            <div class="form-modal-row">
                <label>Nome:</label>
                <input name="subir-fichero-nome" id="subir-fichero-nome" type="text">
            </div>
            <div class="form-modal-row">
                <label>Subir fichero:</label>
                <input name="subir-fichero-fichero" id="subir-fichero-fichero" type="file">
            </div>
            <div class="form-modal-row">
                <button name="subir-fichero-submit" id="subir-fichero-submit" type="submit" value="subir-fichero">Crear cartafol</button>
            </div>
        </form>
    </div>
    <div class="form-modal" id="subir-ficheiro">
        <h2>Nova carpeta</h2>
        <form action="../../scripts/crear-cartafol.php" method="post">
            <div class="form-modal-row">
                <label>Nome:</label>
                <input name="crear-cartafol-nome" id="crear-cartafol-nome" type="text">
            </div>
            <div class="form-modal-row">
                <button name="crear-cartafol-submit" id="crear-cartafol-submit" type="submit" value="crear-cartafol">Crear cartafol</button>
            </div>
        </form>
    </div>
</body>
<script>
    amosarFormularioCrearCartafol();
    amosarFormularioSubirFicheiro();
</script>
<?php 
    ftp_close($ftp);
?>
