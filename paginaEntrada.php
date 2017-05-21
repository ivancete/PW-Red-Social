<?php
require_once ('usuario.php');
require_once ('historia.php');
session_start();

if(!isset($_SESSION["usuario"])) {
    header('Location:index.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title>Creación Entrada</title>
    <link rel="stylesheet"  href="diseno.css"/>
    <!--Validación de la creación de una entrada -->
    <script>
        function validarEntrada() {
            var x = document.forms["entrada"]["titulo"].value;
            var y = document.forms["entrada"]["descripcion"].value;
            if (x == "") {
                alert("No se ha introducido título.");
                return false;
            }
            else if (x.length > 100) {
                alert("Se han introducido más de 100 caracteres en el título.");
                return false;
            }
            else if (y == "") {
                alert("No se ha introducido descripción.");
                return false;
            }
            else if (x.length > 190) {
                alert("Se han introducido más de 190 caracteres en la descripción.");
                return false;
            }
        }
    </script>
</head>
<body>
<header>
    <section>
        <?php
        echo "<a href='portada.php'>
                    <img class='logo' alt='Logo' src='ugrL.png'/>
                 </a>";
        ?>

    </section>
    <section>
        <?php
        echo "<a href='portada.php'>
                    <p id='nombre'>VisitsBook</p>
                  </a>";
        ?>
    </section>
    <section>
        <form action='salir.php' method='get'>
            <input class='botonSalir' type='submit' name='salir' value='Salir'/>
        </form>
        <?php

        if(isset($_GET["numerosig"])){
            $numerosig = $_GET["numerosig"];
        }
        else
            $numerosig = 0;


        $consulta = Usuario::obtenerUsuario($_SESSION["usuario"]);

        $imagen = $consulta->devolverValor("fotoperfil");

        echo "<a href='paginaEntrada.php'>
                        <img class='fotoPerfil' alt='fotoPerfil' src='$imagen'/>
                  </a>";
        ?>
    </section>
</header>
<section id="botonera">
    <?php
    echo    "<a href='biografia.php'>
            Biografía
        </a>
            -
        <a href='fotos.php'>
            Fotos
        </a>
            -
        <a href='informacion.php'>
            Información
        </a>";
    ?>
</section>
<section class="scroll">
    <?php

    $conectados = Usuario::devolverAmigos($_SESSION["usuario"]);

    for($i = 0; $i < count($conectados); ++$i) {

        $usuario = $conectados[$i]->devolverValor("usuario");

        $name = $conectados[$i]->devolverValor("nombre");

        $imagenfriend = $conectados[$i]->devolverValor("fotoperfil");

        $name_mayuscula = strtoupper($name);

        echo "<a href='biografia.php?usuarioamigo=$name'>
                    <article class='textofoto'>
                        <p>$name_mayuscula</p>
                        <img class='fotoconectado' alt='fotoAmigo' src='$imagenfriend'/>
                    </article>
                  </a>";
    }
    ?>
</section
<section class="contenidoInferior">
    <input id="mostrar" name="mostrar" type="checkbox">
    <label class="inputlabel" for="mostrar"></label>
    <h4 class="cabecera">USUARIOS ACTIVOS</h4>
    <aside>

        <?php

        $conectados = Usuario::devolverConectados();

        for ($i = 0; $i < count($conectados); ++$i){

            $usuario = $conectados[$i]->devolverValor("usuario");

            $nombre = $conectados[$i]->devolverValor("nombre");

            $nombre = strtoupper($nombre);

            $imagenfriend = $conectados[$i]->devolverValor("fotoperfil");

            echo "<a href='biografia.php?usuarioamigo=$usuario'>
                <article>
                    <p class='textoConectado'>$nombre</p>
                    <img class='fotoconectado' alt='fotoAmigo' src='$imagenfriend'/>
                </article>
              </a>";
        }
        ?>
    </aside>
    <section class="crearEntrada">
        <article>
            <?php

            $_SESSION["creador_historia"] = $_SESSION["usuario"];

            $consulta = Usuario::obtenerUsuario($_SESSION["usuario"]);

            $nombre = $consulta->devolverValor("nombre");

            $nombre = strtoupper($nombre);

            ?>
            <article class="texto">
                <form name="entrada" action="entrada.php" method="get" onsubmit="return validarEntrada()">
                    <table>
                        <tr>
                            <td>
                                <input size="102" type="text" name="titulo" placeholder="Escriba aquí el título"/>
                                <textarea rows="10" cols="100" name="descripcion" placeholder="Escribe su Comentario"></textarea>
                            </td>
                            <td>
                                <?php
                                echo "  <p>$nombre</p>
                                        <img class='imagenComentario' alt='imagen perfil' src='$imagen'/>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><input class="enviar" type="submit" value="Enviar" /></td>
                        </tr>
                    </table>
                </form>
            </article>

        </article>
    </section>
    <section class="historia">
        <?php

        $historias_mias = Historia::obtenerHistoriasMiasOrdenadas($_SESSION["usuario"], 0, 6);

        for($i = 0; $i < count($historias_mias); ++$i) {

            $descripcion = $historias_mias[$i]->devolverValor("descripcion");

            $titulo = $historias_mias[$i]->devolverValor("titulo");

            $fecha = $historias_mias[$i]->devolverValor("fecha");

            $titulo_mayuscula = strtoupper($titulo);

            $usuario = $_SESSION["usuario"];

            $persona = Usuario::obtenerUsuario($usuario);

            $imagen = $historias_mias[$i]->devolverValor("refimagen");

            $nombrePerfil = $persona->devolverValor("nombre");

            $idhistoria = $historias_mias[$i]->devolverValor("idhistoria");

            $nombrePerfil_mayuscula = strtoupper($nombrePerfil);

            echo "<a href='detalleHistoria.php?historia=$idhistoria&usuarioamigo=$_SESSION[usuario]'>
                    <article class='historiaIndividual'>
                        <p>$nombrePerfil_mayuscula</p>
                        <img class='fotoconectado' alt='perfil' src='$imagen'/>
                        <h4>$titulo_mayuscula</h4>
                        <p>$descripcion</p>
                        <p>$fecha</p>
                    </article>
                  </a>";
        }
        ?>
    </section>
</section>
<footer>
    <h4>
        <a href="contacto.html">
            CONTACTO
        </a>
        -
        <a href="explicacion.pdf">
            COMO SE HIZO
        </a>
    </h4>
</footer>
</body>
</html>
