<?php 
    session_start();

    ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/campus.css">
    <link rel="stylesheet" href="../../css/form.css">
    <script>
        function amosarMenuCurso() {
            const menuDesplegable = document.getElementById("menu-curso");
            const boton = document.getElementById("boton-menu-curso");
            
            boton.addEventListener("mouseover",function(e) {
                menuDesplegable.style.display = "block";
            });
        }

        function pecharMenuCurso() {
            const menuDesplegable = document.getElementById("menu-curso");
            const boton = document.getElementById("boton-menu-curso");
            
            boton.addEventListener("click",function(e) {
                menuDesplegable.style.display = "none";
            });
        }

        function amosarMenuTopico() {
            const menuDesplegable = document.getElementById("menu-topico");
            const boton = document.getElementById("boton-menu-topico");
            
            boton.addEventListener("mouseover",function(e) {
                menuDesplegable.style.display = "block";
            });
        }

        function pecharMenuTopico() {
            const menuDesplegable = document.getElementById("menu-topico");
            const boton = document.getElementById("boton-menu-topico");
            
            boton.addEventListener("click",function(e) {
                menuDesplegable.style.display = "none";
            });
        }

        function amosarFormularioEngadirTopico() {
            const formulario = document.getElementById("engadir-topico");
            const engadirCurso = document.getElementById("opcion-engadir-topico");
            engadirCurso.addEventListener("click", function(){
                formulario.style.display = "block";
            });
        }

        function amosarFormularioEngadirApuntes() {
            const formulario = document.getElementById("engadir-apuntes");
            const engadirCurso = document.getElementById("opcion-engadir-apuntes");
            engadirCurso.addEventListener("click", function(){
                formulario.style.display = "block";
            });
        }

        function amosarFormularioEngadirActividade() {
            const formulario = document.getElementById("engadir-actividade");
            const engadirCurso = document.getElementById("opcion-engadir-actividade");
            engadirCurso.addEventListener("click", function(){
                formulario.style.display = "block";
            });
        }

        function amosarFormularioEngadirRecurso() {
            const formulario = document.getElementById("engadir-recurso");
            const engadirCurso = document.getElementById("opcion-engadir-recurso");
            engadirCurso.addEventListener("click", function(){
                formulario.style.display = "block";
            });
        }
    </script>
</head>
<?php

    require '../../req/conbd.php';

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        $curso = $_GET["curso"];

        $rol = mysqli_fetch_assoc(mysqli_query($conexion,"SELECT rol FROM vis_cursos_usuario WHERE usu_idalumno = " . $_SESSION["id_usuario"] . " AND cur_id = " . $curso . ";"))["rol"];

        $_SESSION["rol"] = $rol;
        
        $query_topicos = "SELECT * FROM vis_topicos_curso WHERE top_curso = \"" . $curso . "\"ORDER BY top_id";

        $data_topicos = mysqli_query($conexion,$query_topicos);

        $listado_topicos = mysqli_fetch_all($data_topicos,MYSQLI_ASSOC);
?>
<body>
    <header>
        <div class="header-left">
            <h1><?php echo mysqli_fetch_assoc(mysqli_query($conexion,"SELECT cur_nome FROM tab_curso WHERE cur_id = " . $curso . ";"))["cur_nome"]; ?></h1>
            <p>Contidos do curso</p>
        </div>
        <div class="header-right">
            <img src="../../icons2/user.svg" alt="user-logo" id="user-logo">
        </div>
    </header>
    <nav>
        <ul class="navbar">
            <li>
                <a>Contidos</a>
            </li>
            <?php if ($rol != "Profesor") {?>
            <li>
                <a>Calificacións</a>
            </li>
            <?php } else {?>
            <li>
                <a>Administrar</a>
            </li>
            <?php }?>
        </ul>
    </nav>
    <section id="contidos" name="contidos" class="seccion">
        <div class="title">
            <h1>Detalles Curso</h1>
            <?php if ($rol == "Profesor") {?>
            <img src="../../icons/options-menu.svg" id="boton-menu-curso">
            <?php }?>
        </div>
        <ul id="menu-curso">
            <li class="odd" id="opcion-engadir-topico">Engadir topico</li>
            <li class="even" id="opcion-engadir-apuntes">Engadir apuntes</li>
            <li class="odd" id="opcion-engadir-recurso">Engadir ligazón</li>
            <li class="even" id="opcion-engadir-actividade">Engadir actividade</li>
        </ul>
        <script>
            amosarMenuCurso();
            pecharMenuCurso();
        </script>
        <?php foreach ($listado_topicos as $elemento) { 
        ?>
            <div class="apartado">
                <div class="title" id="<?php echo $elemento["top_id"];?>">
                    <h1><?php echo $elemento["top_nome"];?></h1>
                    <?php if ($rol == "Profesor") {?>
                    <img src="../../icons2/options-menu.svg" id="boton-menu-topico">
                    <?php }?>
                </div>
                <div class="contido">
                    <?php 
                        $query_recursos = "SELECT * FROM vis_recursos WHERE topico = " . $elemento["top_id"] . ";";

                        $listado_recursos = mysqli_fetch_all(mysqli_query($conexion,$query_recursos),MYSQLI_ASSOC);

                        foreach($listado_recursos as $entrada) {
                    ?>
                    <div class="entrada">
                        <?php if ($entrada["ubicacion"] == "URL") { ?>
                            <img src="../../icons2/link.png"/>
                            <p><a href="<?php echo $entrada["url"];?>"><?php echo $entrada["nome"];?></a></p>
                        <?php } else if ($entrada["ubicacion"] == "Local") {?>
                            <img src="../../icons2/documento.png"/>
                            <p><a href="<?php echo $entrada["url"];?>"><?php echo $entrada["nome"];?></a></p>
                        <?php } else if ($entrada["ubicacion"] == "Actividade") {?>
                            <img src="../../icons2/actividade.jpg"/>
                            <p><a href="actividade/index.php<?php echo $entrada["url"];?>"><?php echo $entrada["nome"];?></a></p>
                        <?php }?>
                    </div>
                    <?php }?>
                </div>
                <?php #}?>
                <!--<ul id="menu-topico">
                    <li class="odd" id="opcion-engadir-recurso">Engadir recurso</li>
                    <li class="even" id="opcion-engadir-actividade">Engadir actividade</li>
                </ul>
                <script>
                    amosarMenuTopico();
                    pecharMenuTopico();
                </script>-->
            </div>
        <?php } ?>

        <!-- Formulario engadir topico -->
        <div class="form-modal" id="engadir-topico">
            <h2>Engadir topico</h2>
            <form action="../../scripts/engadir-topico.php" method="post">
                <div class="form-modal-row">
                    <label>Nome:</label>
                    <input name="engadir-topico-nome" id="engadir-topico-nome" type="text">
                </div>
                <div class="form-modal-row">
                    <input name="engadir-topico-cursoid" id="engadir-topico-cursoid" type="hidden" value="<?php echo $curso;?>">
                </div>
                <div class="form-modal-row">
                    <input name="rol" id="rol-usuario" type="hidden" value="<?php echo $rol;?>">
                </div>
                <div class="form-modal-row">
                    <button name="topico-submit" id="topico-submit" type="submit" value="engadir-topico">Engadir topico</button>
                </div>
            </form>
        </div>

        <!-- Formulario engadir apuntes -->
        <div class="form-modal" id="engadir-apuntes">
            <h2>Engadir apuntes</h2>
            <form enctype="multipart/form-data" action="../../scripts/engadir-apuntes.php" method="post">
                <div class="form-modal-row">
                    <label>Nome:</label>
                    <input name="engadir-apuntes-nome" id="engadir-apuntes-nome" type="text">
                </div>
                <div class="form-modal-row">
                    <label>Tópico:</label>
                    <select name="engadir-apuntes-topico" id="engadir-apuntes-topico">
                        <option value="0">Sen topico</option>
                        <?php foreach($listado_topicos as $elemento) {
                            echo "<option value=\"" . $elemento["top_id"] . "\">" . $elemento["top_nome"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-modal-row">
                    <label>Subir ficheiro</label>
                    <input name="engadir-apuntes-path" id="engadir-apuntes-path" type="file">
                </div>
                <div class="form-modal-row">
                    <input name="engadir-apuntes-cursoid" id="engadir-apuntes-cursoid" type="hidden" value="<?php echo $curso;?>">
                </div>
                <div class="form-modal-row">
                    <button name="apuntes-submit" id="apuntes-submit" type="submit" value="engadir-apuntes">Engadir topico</button>
                </div>
            </form>
        </div>

        <!-- Formulario engadir recurso -->
        <div class="form-modal" id="engadir-recurso">
            <h2>Engadir recurso</h2>
            <form enctype="multipart/form-data" action="../../scripts/engadir-recurso.php" method="post">
                <div class="form-modal-row">
                    <label>Nome:</label>
                    <input name="engadir-recurso-nome" id="engadir-recurso-nome" type="text">
                </div>
                <div class="form-modal-row">
                    <label>Tópico:</label>
                    <select name="engadir-recurso-topico" id="engadir-recurso-topico">
                        <option value="0">Sen topico</option>
                        <?php foreach($listado_topicos as $elemento) {
                            echo "<option value=\"" . $elemento["top_id"] . "\">" . $elemento["top_nome"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-modal-row">
                    <label>Ligazón:</label>
                    <input name="engadir-recurso-url" id="engadir-recurso-url" type="text">
                </div>
                <div class="form-modal-row">
                    <input name="engadir-recurso-cursoid" id="engadir-recurso-cursoid" type="hidden" value="<?php echo $curso;?>">
                </div>
                <div class="form-modal-row">
                    <button name="apuntes-submit" id="apuntes-submit" type="submit" value="engadir-apuntes">Engadir recurso</button>
                </div>
            </form>
        </div>

        <!-- Formulario engadir actividade -->
        <div class="form-modal" id="engadir-actividade">
            <h2>Engadir actividade</h2>
            <form enctype="multipart/form-data" action="../../scripts/engadir-actividade.php" method="post">
                <div class="form-modal-row">
                    <label>Nome:</label>
                    <input name="engadir-actividade-nome" id="engadir-actividade-nome" type="text">
                </div>
                <div class="form-modal-row">
                    <label>Descrición:</label>
                    <textarea name="engadir-actividade-descricion" id="engadir-actividade-descricion"></textarea>
                </div>
                <div class="form-modal-row">
                    <label>Tópico:</label>
                    <select name="engadir-actividade-topico" id="engadir-actividade-topico">
                        <option value="0">Sen topico</option>
                        <?php foreach($listado_topicos as $elemento) {
                            echo "<option value=\"" . $elemento["top_id"] . "\">" . $elemento["top_nome"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-modal-row">
                    <label>Puntuación:</label>
                    <input type="text" name="engadir-actividade-puntuacion" id="engadir-actividade-puntuacion">
                </div>
                <div class="form-modal-row">
                    <input name="engadir-actividade-cursoid" id="engadir-actividade-cursoid" type="hidden" value="<?php echo $curso;?>">
                </div>
                <div class="form-modal-row">
                    <button name="apuntes-submit" id="apuntes-submit" type="submit" value="engadir-apuntes">Engadir topico</button>
                </div>
            </form>
        </div>
        <script>
            amosarFormularioEngadirActividade();
            amosarFormularioEngadirTopico();
            amosarFormularioEngadirApuntes();
            amosarFormularioEngadirRecurso();
        </script>
    </section>
</body>
<?php 
mysqli_close($conexion);
?>
<?php }?>
</html>