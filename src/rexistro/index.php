<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/form.css">
    <title>Dixicole</title>
</head>
<body>
    <header>
        <div class="header-left">
            <h1>Dixicole. Rexístrate gratis</h1>
            <p>Unha educación para todos</p>
        </div>
        <div class="header-right">
        </div>
    </header>
    <nav>
        <ul class="navbar">
            
        </ul>
    </nav>
    <?php 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nome = htmlspecialchars($_POST['rexistrar-usuario-nome']);

            $apelido1 = htmlspecialchars($_POST['rexistrar-usuario-apelido1']);

            $apelido2 = htmlspecialchars($_POST['rexistrar-usuario-apelido2']);

            $telefono = htmlspecialchars($_POST['rexistrar-usuario-telefono']);

            $correo = htmlspecialchars($_POST['rexistrar-usuario-email']);

            $nomeusuario = htmlspecialchars($_POST['rexistrar-usuario-nomeusuario']);

            $contrasinal1 = htmlspecialchars($_POST['rexistrar-usuario-contrasinal1']);

            $contrasinal2 = htmlspecialchars($_POST['rexistrar-usuario-contrasinal2']);

            if ($contrasinal1 != $contrasinal2) {

                ?>
                <section class="seccion" id="rexistrar-usuario">
                    <h2>Rexistrar usuario:</h2>
                    <hr>
                    <br>
                    <form action="" method="post">
                        <div class="form-modal-row">
                            <label>Nome:</label>
                            <input name="rexistrar-usuario-nome" id="rexistrar-usuario-nome" type="text">
                        </div>
                        <div class="form-modal-row">
                            <label>Primeiro Apelido:</label>
                            <input name="rexistrar-usuario-apelido1" id="rexistrar-usuario-apelido1" type="text">
                        </div>
                        <div class="form-modal-row">
                            <label>Segundo Apelido:</label>
                            <input name="rexistrar-usuario-apelido2" id="rexistrar-usuario-apelido2" type="text">
                        </div>
                        <div class="form-modal-row">
                            <label>Telefono:</label>
                            <input name="rexistrar-usuario-telefono" id="rexistrar-usuario-telefono" type="telf">
                        </div>
                        <div class="form-modal-row">
                            <label>Correo:</label>
                            <input name="rexistrar-usuario-email" id="rexistrar-usuario-email" type="email">
                        </div>
                        <div class="form-modal-row">
                            <label>Nome usuario:</label>
                            <input name="rexistrar-usuario-nomeusuario" id="rexistrar-usuario-nomeusuario" type="text">
                        </div>
                        <div class="form-modal-row">
                            <label>Contrasinal:</label>
                            <input name="rexistrar-usuario-contrasinal1" id="rexistrar-usuario-contrasinal1" type="password">
                        </div>
                        <div class="form-modal-row">
                            <label>Confirmar contrasinal:</label>
                            <input name="rexistrar-usuario-contrasinal2" id="rexistrar-usuario-contrasinal2" type="password">
                        </div>
                        <div class="form-modal-row">
                                <p class="auth-error">As contrasinais ten que ser iguais</p>
                            </div>
                        <div class="form-modal-row">
                            <button name="rexistrar-usuario-submit" id="rexistrar-usuario-submit" type="submit">Rexistrar</button>
                        </div>
                    </form>
                </section>
                <?php
            } elseif ($contrasinal1 == $contrasinal2 && strlen($contrasinal1) < 8) {
                ?>
                <section class="seccion" id="rexistrar-usuario">
                    <h2>Rexistrar usuario:</h2>
                    <hr>
                    <br>
                    <form action="" method="post">
                        <div class="form-modal-row">
                            <label>Nome:</label>
                            <input name="rexistrar-usuario-nome" id="rexistrar-usuario-nome" type="text">
                        </div>
                        <div class="form-modal-row">
                            <label>Primeiro Apelido:</label>
                            <input name="rexistrar-usuario-apelido1" id="rexistrar-usuario-apelido1" type="text">
                        </div>
                        <div class="form-modal-row">
                            <label>Segundo Apelido:</label>
                            <input name="rexistrar-usuario-apelido2" id="rexistrar-usuario-apelido2" type="text">
                        </div>
                        <div class="form-modal-row">
                            <label>Telefono:</label>
                            <input name="rexistrar-usuario-telefono" id="rexistrar-usuario-telefono" type="telf">
                        </div>
                        <div class="form-modal-row">
                            <label>Correo:</label>
                            <input name="rexistrar-usuario-email" id="rexistrar-usuario-email" type="email">
                        </div>
                        <div class="form-modal-row">
                            <label>Nome usuario:</label>
                            <input name="rexistrar-usuario-nomeusuario" id="rexistrar-usuario-nomeusuario" type="text">
                        </div>
                        <div class="form-modal-row">
                            <label>Contrasinal:</label>
                            <input name="rexistrar-usuario-contrasinal1" id="rexistrar-usuario-contrasinal1" type="password">
                        </div>
                        <div class="form-modal-row">
                            <label>Confirmar contrasinal:</label>
                            <input name="rexistrar-usuario-contrasinal2" id="rexistrar-usuario-contrasinal2" type="password">
                        </div>
                        <div class="form-modal-row">
                                <p class="auth-error">As contrasinais non superan os oito caracteres</p>
                            </div>
                        <div class="form-modal-row">
                            <button name="rexistrar-usuario-submit" id="rexistrar-usuario-submit" type="submit">Rexistrar</button>
                        </div>
                    </form>
                </section>
                <?php
            } else {

                # Alta na base de datos.
                $query = "CALL pro_rexistrar_usuario (\"{$nome}\",\"{$apelido1}\",\"{$apelido2}\",\"{$telefono}\",\"{$correo}\",\"{$nomeusuario}\",\"{$contrasinal1}\");";

                if (mysqli_query($conexion,$query)) {
   
                    $id_usuario = mysqli_fetch_assoc(mysqli_query($conexion,"SELECT usu_id FROM vis_usuario WHERE usu_nomeusuario = \"{$nomeusuario}\";"))["usu_id"];

                    mkdir($_SERVER['DOCUMENT_ROOT'] . "/arquivos/usuario/" . $id_usuario);

                    $conexion_sshftp = ssh2_connect(
                        "172.16.20.10",
                        22
                    );

                    if (ssh2_auth_password($conexion_sshftp,"root","Abc123.,")) {

                        $cmd = "/usr/sbin/useradd -d /home/{$nomeusuario} -m -p $(mkpasswd --method=sha512crypt {$contrasinal1}) -s /bin/bash --user-group {$nomeusuario}";

                        ssh2_exec($conexion_sshftp, $cmd);

                    }

                    # Creacion del usuario de correo
                    $conexion_sshmail = ssh2_connect(
                        "172.16.50.10",
                        22
                    );

                    if (ssh2_auth_password($conexion_sshmail,"root","Abc123.,")) {

                        $cmd = "/usr/sbin/useradd -d /home/{$nomeusuario} -m -p $(mkpasswd --method=sha512crypt {$contrasinal1}) -s /bin/bash --user-group {$nomeusuario}";

                        ssh2_exec($conexion_sshmail, $cmd);

                    }

                } else {
                    echo "error";
                }


                # Creacion de las carpetas.

                

                # Creacion del usuario ftp.
                /*$conexion_sshftp = ssh2_connect(
                    "172.16.20.10",
                    22
                );

                if (ssh2_auth_password($conexion_sshftp,"root","Abc123.,")) {

                    $cmd = "/usr/sbin/useradd -d /home/{$nomeusuario} -m -p $(mkpasswd --method=sha512crypt {$contrasinal1}) -s /bin/bash --user-group -c {$nomeusuario}";

                    ssh2_exec($conexion_sshftp, $cmd);

                }

                # Creacion del usuario de correo
                $conexion_sshftp = ssh2_connect(
                    "172.16.50.10",
                    22
                );

                if (ssh2_auth_password($conexion_sshftp,"root","Abc123.,")) {

                    $cmd = "/usr/sbin/useradd -d /home/{$nomeusuario} -m -p $(mkpasswd --method=sha512crypt {$contrasinal1}) -s /bin/bash --user-group -c {$nomeusuario}";

                    ssh2_exec($conexion_sshftp, $cmd);

                }*/

            }
        }
        else {
    ?>
    <section class="seccion" id="rexistrar-usuario">
        <h2>Rexistrar usuario:</h2>
        <hr>
        <br>
        <form action="" method="post">
            <div class="form-modal-row">
                <label>Nome:</label>
                <input name="rexistrar-usuario-nome" id="rexistrar-usuario-nome" type="text">
            </div>
            <div class="form-modal-row">
                <label>Primeiro Apelido:</label>
                <input name="rexistrar-usuario-apelido1" id="rexistrar-usuario-apelido1" type="text">
            </div>
            <div class="form-modal-row">
                <label>Segundo Apelido:</label>
                <input name="rexistrar-usuario-apelido2" id="rexistrar-usuario-apelido2" type="text">
            </div>
            <div class="form-modal-row">
                <label>Telefono:</label>
                <input name="rexistrar-usuario-telefono" id="rexistrar-usuario-telefono" type="telf">
            </div>
            <div class="form-modal-row">
                <label>Correo:</label>
                <input name="rexistrar-usuario-email" id="rexistrar-usuario-email" type="email">
            </div>
            <div class="form-modal-row">
                <label>Nome usuario:</label>
                <input name="rexistrar-usuario-nomeusuario" id="rexistrar-usuario-nomeusuario" type="text">
            </div>
            <div class="form-modal-row">
                <label>Contrasinal:</label>
                <input name="rexistrar-usuario-contrasinal1" id="rexistrar-usuario-contrasinal1" type="password">
            </div>
            <div class="form-modal-row">
                <label>Confirmar contrasinal:</label>
                <input name="rexistrar-usuario-contrasinal2" id="rexistrar-usuario-contrasinal2" type="password">
            </div>
            <div class="form-modal-row">
                <button name="rexistrar-usuario-submit" id="rexistrar-usuario-submit" type="submit">Rexistrar</button>
            </div>
        </form>
    </section>
    <?php }?>
</body>
</html>