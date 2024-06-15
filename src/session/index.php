<?php 
    session_start();

    ob_start();

    require '../req/conbd.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/global.css">
    <title>Dixicole</title>
    <!--<script src="../../js/iframe.js"></script>-->
    <link rel="stylesheet" href="../css/campus.css">
    <link rel="stylesheet" href="../css/form.css">
    <script>
        function amosarMenu() {
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

        function amosarFormularioEngadirCurso() {
            const formulario = document.getElementById("engadir-curso");
            const engadirCurso = document.getElementById("opcion-engadir-curso");
            engadirCurso.addEventListener("click", function(){
                formulario.style.display = "block";
            });
        }

        function amosarFormularioMatricula() {
            const formulario = document.getElementById("matricula-curso");
            const matriculaCurso = document.getElementById("opcion-matricula-curso");
            matriculaCurso.addEventListener("click", function(){
                formulario.style.display = "block";
            });
        }
    </script>
</head>
<body>
    <header>
        <div class="header-left">
            <h1>Dixicole</h1>
            <p>Benvido <?php echo $_SESSION["apelido1"] . " " . $_SESSION["apelido2"] . ", " . $_SESSION["nome"];?></p>
        </div>
        <div class="header-right">
            <img src="../icons/user.svg" alt="user-logo" id="user-logo">
        </div>
    </header>
    <nav>
        <ul class="navbar">
            <li>
                <a>Campus</a>
            </li>
            <li>
                <a href="./mail/index.php">Buzón de correo</a>
            </li>
            <li>
                <a href="./arquivos/index.php">Arquivos</a>
            </li>
            <li>
                <a>Axustes</a>
            </li>
        </ul>
    </nav>
    <section id="campus" name="campus" class="seccion">
        <div class="title">
            <h1>Os meus cursos</h1>
            <img src="../icons/options-menu.svg" id="boton-menu-cursos">
        </div>
        <ul id="menu-cursos">
            <li class="odd" id="opcion-engadir-curso">Engadir novo curso</li>
            <li class="even" id="opcion-matricula-curso">Matricularse nun curso existente</li>
        </ul>
        <script>
            amosarMenu();
            pecharMenu();
        </script>
        <?php 
            $query = "SELECT * FROM vis_cursos_usuario WHERE usu_idalumno = \"" . $_SESSION["id_usuario"] . "\";";

            $data_cursos = mysqli_query($conexion,$query);
        ?>
        <div class="vista-cursos">
            <?php while ($curso = mysqli_fetch_assoc($data_cursos)) { ?>
                <a id="<?php echo $curso["cur_id"];?>" class="tarxeta-curso" href="campus/index.php?curso=<?php echo $curso["cur_id"];?>">
                    <div class="fondo-curso"></div>
                    <div class="descricion-curso">
                        <h2><?php echo $curso["cur_nome"];?></h2>
                        <p><?php echo $curso["usu_nomeprofe"];?></p>
                    </div>
                </a>
            <?php }?>
        </div>

        <!-- Formulario engadir curso -->
        <div class="form-modal" id="engadir-curso">
            <h2>Engadir curso</h2>
            <form action="../scripts/engadir-curso.php" method="post">
                <div class="form-modal-row">
                    <label>Nome:</label>
                    <input name="engadir-curso-nome" id="engadir-curso-nome" type="text">
                </div>
                <div class="form-modal-row">
                    <label>Descricion:</label>
                    <textarea name="engadir-curso-descricion" id="engadir-curso-descricion"></textarea>
                </div>
                <div class="form-modal-row">
                    <button name="curso-submit" id="curso-submit" type="submit" value="engadir-curso">Engadir curso</button>
                </div>
            </form>
        </div>

        <!-- Formulario matricular curso -->
        <div class="form-modal" id="matricula-curso">
            <h2>Matricularse nun curso</h2>
            <form action="../scripts/matricula-curso.php" method="post">
                <div class="form-modal-row">
                    <label>Código curso:</label>
                    <input name="matricula-curso-codigo" id="matricula-curso-codigo" type="text">
                </div>
                <div class="form-modal-row">
                    <button name="curso-submit" id="curso-submit" type="submit" value="matricula-curso">Matricula</button>
                </div>
            </form>
        </div>

        <!--Execución de código xavascript dos formularios modais -->
        <script>
            amosarFormularioEngadirCurso();
            amosarFormularioMatricula();
        </script>
    </section>
    <?php mysqli_close($conexion);?>
</body>
</html>