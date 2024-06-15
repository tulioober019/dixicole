<?php 
    session_start();

    ob_start();

    require "../../../req/dateutils.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/global.css">
    <link rel="stylesheet" href="../../../css/campus.css">
    <link rel="stylesheet" href="../../../css/form.css">
    <script>
        /*function amosarMenuCurso() {
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
        }*/
        function amosarFormularioEntregarActividade() {
            const formulario = document.getElementById("entregar-actividade");
            const boton = document.getElementById("opcion-entregar-actividade");
            boton.addEventListener("click", function(){
                formulario.style.display = "block";
            });
        }
    </script>
</head>
<?php
    require '../../../req/conbd.php';

    $id_actividade = $_GET["id"];

    $query_actividade = "SELECT * FROM vis_infoactividade WHERE act_id = " . $id_actividade . ";";

    $resultado_actividade = mysqli_fetch_array(mysqli_query($conexion,$query_actividade));
?>
<body>
    <header>
        <div class="header-left">
            <h1>Estado da actividade</h1>
            <p>Contidos do curso</p>
        </div>
        <div class="header-right">
            <img src="../../../icons2/user.svg" alt="user-logo" id="user-logo">
        </div>
    </header>
    <nav>
        <ul class="navbar">
            <li>
                <a></a>
            </li>
        </ul>
    </nav>
    <section id="contidos" name="contidos" class="seccion">
        <div class="title">
            <h1><?php echo $resultado_actividade["act_nome"];?></h1>
        </div>
        <h2>Descrición da actividade:</h2>
        <hr>
        <div class="descripcion">
            <?php echo $resultado_actividade["act_descricion"];?>
        </div>
        <div class="entrega">
            <table>
                <tr class="even">
                    <th>Puntuación</th>
                    <td><?php echo $resultado_actividade["act_puntmax"];?></td>
                </tr>
                <tr class="odd">
                    <th>Data límite</th>
                    <td><?php echo procesar_diasemana($resultado_actividade["act_datalim"]) . ", " . procesar_dia($resultado_actividade["act_datalim"]) . " de " . procesar_mes($resultado_actividade["act_datalim"]) . ", " . procesar_anho($resultado_actividade["act_datalim"]);?></td>
                </tr>
                <tr class="even">
                    <th>Hora límite</th>
                    <td><?php echo procesar_hora($resultado_actividade["act_datalim"]) . ":" . procesar_minuto($resultado_actividade["act_datalim"]);?></td>
                </tr>
            </table>
        </div>
        <?php if ($_SESSION["rol"] == "Alumno") {?>
            <div class="entregar">
                <button type="button" id="opcion-entregar-actividade">Entregar</button>
            </div>
            <div class="estado">
                <h2>Estado da entrega:</h2>
                <hr>
                <table>
                    <tr class="even">
                        <th>Calificación</th>
                        <td><?php echo $resultado_actividade["act_puntmax"];?></td>
                    </tr>
                    <tr class="odd">
                        <th>Fecha límite</th>
                        <td><?php echo $resultado_actividade["act_datalim"];?></td>
                    </tr>
                </table>
            </div>
        <?php } else if ($_SESSION["rol"] == "Profesor") {?>
            <div class="entregados">
                <h2>Entregados:</h2>
                <hr>
                <?php 
                    $query_entregas_alumnos = "SELECT * FROM vis_entregados WHERE actividade = " . $id_actividade . ";";

                    $entregas_alumnos = mysqli_fetch_all(mysqli_query($conexion,$query_entregas_alumnos), MYSQLI_ASSOC);
                    
                    if (count($entregas_alumnos) > 0) {
                ?>
                <table>
                    <tr class="even">
                        <th>Alumno</th>
                        <th>Recurso</th>
                        <th>Calificación</th>
                        <th>Commentario</th>
                    </tr>
                    <?php 

                        foreach ($entregas_alumnos as $entrega) {
                    ?>
                    <tr class="odd">
                        <td><?php echo $entrega["alumno"];?></td>
                        <td><?php echo $entrega["url"];?></td>
                        <td><?php echo $entrega["calif"];?></td>
                        <td><?php echo $entrega["comment"];?></td>
                    </tr>
                    <?php }}?>
                </table>
                <?php if (count($entregas_alumnos) == 0) {?>
                    <h3>Aínda non hai entregas</h3>
                <?php } else {?>
                    <h3>Han entregado <?php echo count($entregas_alumnos);?></h3>
                <?php }?>
            </div>
        <?php }?>
        <div class="form-modal" id="entregar-actividade">
            <h2>Engadir apuntes</h2>
            <form enctype="multipart/form-data" action="../../../scripts/entregar-actividade.php" method="post">
                <div class="form-modal-row">
                    <label>Nome:</label>
                    <input name="entregar-actividade-nome" id="entregar-actividade-nome" type="text">
                </div>
                <div class="form-modal-row">
                    <label>Subir ficheiro</label>
                    <input name="entregar-actividade-path" id="entregar-actividade-path" type="file">
                </div>
                <div class="form-modal-row">
                    <input name="entregar-actividade-id" type="hidden" value="<?php echo $id_actividade;?>">
                </div>
                <div class="form-modal-row">
                    <button name="actividade-submit" id="actividade-submit" type="submit" value="engadir-actividade">Engadir topico</button>
                </div>
            </form>
        </div>
        <script>
            amosarFormularioEntregarActividade();
        </script>
    </section>
</body>
</html>