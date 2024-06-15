<?php 
    session_start();

    ob_start();

    require '../../req/conbd.php';

    require "../../req/dateutils.php";

    $config_file_path_imap = $_SERVER['DOCUMENT_ROOT'] . "/config.json";

    $datos_imap = json_decode(file_get_contents($config_file_path_imap),true)["imap"];

    $imap_host = "{" . $datos_imap["imap_host"] . ":" . $datos_imap["imap_port"] . "/imap/notls}INBOX";

    $imap_username = $_SESSION["nomeusuario"] . "@" . $datos_imap["imap_host"];

    $imap_password = $_SESSION["contrasinal"];
    
    $mbox = imap_open($imap_host, $imap_username, $imap_password, NIL, 0, ['DISABLE_AUTHENTICATOR' => 'PLAIN']);

    $_SESSION["mbox"] = $mbox;
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
        function amosarFormularioEnviarCorreo() {
            const formulario = document.getElementById("enviar-correo");
            const enviarCorreo = document.getElementById("opcion-enviar-correo");
            enviarCorreo.addEventListener("click", function(){
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

        function amosarCorreoElectronico() {
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
        }

    </script>
</head>
<body>
    <header>
        <div class="header-left">
            <h1>Correo de Dixicole</h1>
            <p>Benvido <?php echo $_SESSION["apelido1"] . " " . $_SESSION["apelido2"] . ", " . $_SESSION["nome"];?></p>
        </div>
        <div class="header-right">
            <img src="../../icons/user.svg" alt="user-logo" id="user-logo">
        </div>
    </header>
    <nav>
        <ul class="navbar">
            <li>
                <a>Consultar buzón</a>
            </li>
            <li id="opcion-enviar-correo">
                <a>Escribir correo</a>
            </li>
        </ul>
    </nav>
    <section id="mbox" name="mbox" class="mbox">
        <div class="mbox-list">
            <?php
                $emails = array_reverse(imap_search($mbox,'ALL'));

                foreach ($emails as $email) {

                    $header = imap_headerinfo($mbox,$email);

                    $asunto = $header->subject;

                    $remitente = $header->fromaddress;

                    $hora = procesar_datamail($header->date);

                    if ($email%2 == 0) {
            ?>
            <div id="<?php echo $email;?>" class="mail-listing even">
                <div class="mail-listing-top">
                    <h3><?php echo $remitente; ?></h3>
                    <p><?php echo $hora; ?></p>
                </div>
                <div class="mail-listing-bottom">
                    <h3><?php echo $asunto; ?></h3>
                </div>
            </div>
            <?php } else {?>
            <div id="<?php echo $email;?>" class="mail-listing odd">
                <div class="mail-listing-top">
                    <h3><?php echo $remitente; ?></h3>
                    <p><?php echo $hora; ?></p>
                </div>
                <div class="mail-listing-bottom">
                    <h3><?php echo $asunto; ?></h3>
                </div>
            </div>
            <!--<div id="2" class="mail-listing odd">
                <div class="mail-listing-top">
                    <h3>Bernier ADMIN, Tulio</h3>
                    <p>07:44</p>
                </div>
                <div class="mail-listing-bottom">
                    <h3>Hola de nuevo!!</h3>
                </div>
            </div>
            <div id="3" class="mail-listing even">
                <div class="mail-listing-top">
                    <h3>Bernier ADMIN, Tulio</h3>
                    <p>07:42</p>
                </div>
                <div class="mail-listing-bottom">
                    <h3>Hola de nuevooo!!</h3>
                </div>
            </div>-->
            <?php
            } 
                }
            ?>
        </div>
        <div class="mbox-view">
        <?php
                $emails = imap_search($mbox,'ALL');

                foreach ($emails as $email) {

                    $header = imap_headerinfo($mbox,$email);

                    $remitente = $header->from[0]->mailbox . "@" . $header->from[0]->host;

                    $destinatario = $header->to[0]->mailbox . "@" . $header->from[0]->host;

                    $data = $header->date;

                    $asunto = $header->subject;

                    $body = imap_body($mbox,$email);
        ?>
            <div id="<?php echo $email;?>" class="mail-content">
                <ul>
                    <li>Remitente: <?php echo $remitente;?></li>
                    <li>Destinatario: <?php echo $destinatario;?></li>
                    <li>Enviado: <?php echo $data;?></li>
                </ul>
                <h3><?php echo $asunto;?></h3>
                <p><?php echo imap_qprint($body);?></p>
            </div>
            <!--<div id="2" class="mail-content">
                <ul>
                    <li>Remitente: ubuntu@mail.dixicole.gal</li>
                    <li>Destinatario: tuliobernier@mail.dixicole.gal</li>
                    <li>Enviado: Mércores, 1 de maio, 2024 07:44</li>
                </ul>
                <h3>Hola de nuevo!!</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipiscing elit curae enim, porttitor ridiculus lectus feugiat odio parturient tortor luctus lacus, maecenas nostra ultrices nascetur pretium himenaeos nisl viverra. Vitae neque auctor sapien dictum lacinia hac blandit tellus, leo rhoncus egestas accumsan purus aptent proin faucibus sollicitudin, primis tristique pretium luctus potenti congue morbi. Vitae penatibus venenatis arcu egestas non id curae etiam, hendrerit posuere nostra dictumst nisi ornare faucibus conubia porttitor, felis odio mollis himenaeos at integer tortor.

Euismod dis orci dui lacus pellentesque senectus tortor, nisl arcu nostra malesuada risus tempor mollis gravida, inceptos mauris est vivamus feugiat vestibulum. Vulputate cras taciti lobortis viverra morbi lacus nascetur, inceptos natoque ligula malesuada mus scelerisque, sociosqu ornare a quis arcu purus. Mus facilisis per tortor libero ligula orci dui, eleifend posuere placerat integer cubilia penatibus, taciti risus luctus ultricies quam feugiat proin, torquent pretium dictumst eu vulputate.</p>
            </div>
            <div id="3" class="mail-content">
                <ul>
                    <li>Remitente: ubuntu@mail.dixicole.gal</li>
                    <li>Destinatario: tuliobernier@mail.dixicole.gal</li>
                    <li>Enviado: Mércores, 1 de maio, 2024 07:42</li>
                </ul>
                <h3>Hola de nuevooo!!</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipiscing elit curae enim, porttitor ridiculus lectus feugiat odio parturient tortor luctus lacus, maecenas nostra ultrices nascetur pretium himenaeos nisl viverra. Vitae neque auctor sapien dictum lacinia hac blandit tellus, leo rhoncus egestas accumsan purus aptent proin faucibus sollicitudin, primis tristique pretium luctus potenti congue morbi. Vitae penatibus venenatis arcu egestas non id curae etiam, hendrerit posuere nostra dictumst nisi ornare faucibus conubia porttitor, felis odio mollis himenaeos at integer tortor.

Euismod dis orci dui lacus pellentesque senectus tortor, nisl arcu nostra malesuada risus tempor mollis gravida, inceptos mauris est vivamus feugiat vestibulum. Vulputate cras taciti lobortis viverra morbi lacus nascetur, inceptos natoque ligula malesuada mus scelerisque, sociosqu ornare a quis arcu purus. Mus facilisis per tortor libero ligula orci dui, eleifend posuere placerat integer cubilia penatibus, taciti risus luctus ultricies quam feugiat proin, torquent pretium dictumst eu vulputate.</p>
            </div>-->
            <?php } ?>
        </div>
    </section>
    <script>
        amosarCorreoElectronico();
    </script>
    <div class="form-modal" id="enviar-correo">
        <h2>Escribir correo</h2>
        <form action="../../scripts/enviar-correo.php" method="post">
            <div class="form-modal-row">
                <label>Destinatario:</label>
                <input name="enviar-correo-destinatario" id="enviar-correo-destinatario" type="email">
            </div>
            <div class="form-modal-row">
                <label>Asunto:</label>
                <input name="enviar-correo-asunto" id="enviar-correo-asunto" type="text">
            </div>
            <div class="form-modal-row">
                <label>Mensaxe:</label>
                <textarea name="enviar-correo-mensaxe" id="enviar-correo-mensaxe"></textarea>
            </div>
            <div class="form-modal-row">
                <button name="topico-submit" id="topico-submit" type="submit" value="engadir-topico">Enviar correo</button>
            </div>
        </form>
    </div>
    <script>
        amosarFormularioEnviarCorreo();
    </script>
</body>
<?php 
    imap_close($mbox);
?>