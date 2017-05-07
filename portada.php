<?php
require_once ('usuario.php');
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title>Portada Red Social</title>
    <link rel="stylesheet"  href="diseno.css"/>
    <link rel="stylesheet"  href="dS.css" media="(max-width: 480px)"/>
    <meta charset="UTF-8" name="viewport" content="width=device−width, initial−scale=1.0, url=portada.html"
          http-equiv="refresh"/>
</head>
<body>
<header>
    <section>
        <a href="portada.php">
            <img class="logo" alt="Logo" src="ugrL.png"/>
        </a>
    </section>
    <section>
        <a href="portada.php">
            <p id="nombre">VisitsBook</p>
        </a>
    </section>
    <section>
        <form action='salir.php' method='post'>
            <input class='botonSalir' type='submit' name='salir' value='Salir'/>
        </form>
        <?php

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

        $conectados = Usuario::devolverAmigos();

        for($i = 0; $i < count($conectados); ++$i) {

            $name = $conectados[$i]->devolverValor("nombre");

            $imagenfriend = $conectados[$i]->devolverValor("fotoperfil");

            echo "<a href='portada.php?usuarioamigo=$name'>
                    <article class='textofoto'>
                        <p>$name</p>
                        <img class='fotoconectado' alt='fotoAmigo' src='$imagenfriend'/>
                    </article>
                  </a>";
        }
    ?>

</section>
<section class="contenidoInferior">
    <input id="mostrar" name="mostrar" type="checkbox">
    <label class="inputlabel" for="mostrar"></label>
    <h4 class="cabecera">USUARIOS ACTIVOS</h4>
    <aside>
        <?php

        for($i = 0; $i < count($conectados); ++$i) {

            $name = $conectados[$i]->devolverValor("nombre");

            $imagenfriend = $conectados[$i]->devolverValor("fotoperfil");

            echo "<a href='portada.php?usuarioamigo=$name'>
                <article>
                    <p class='textoConectado'>$name</p>
                    <img class='fotoconectado' alt='fotoAmigo' src='$imagenfriend'/>
                </article>
            </a>";
        }
        ?>
    </aside>
    <section class="historia">
        <a href="albert/albert_20170305_1533.html">
            <article id="historiaIndividual">
                <p>Albert</p>
                <img class="fotoconectado" alt="PerfilAlbert" src="albert_20170305_1533_01.JPEG"/>
                <h4>Título</h4>
                <p>Físico alemán de origen judío.</p>
                <p>Hace 10 horas.</p>
            </article>
        </a>
    </section>
</section>
</body>
</html>
