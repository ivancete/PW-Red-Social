<?php
require_once ('usuario.php');
require_once ('historia.php');
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
        <?php
        echo "<a href='portada.php?usuarioamigo=$_SESSION[usuario]'>
                    <img class='logo' alt='Logo' src='ugrL.png'/>
                 </a>";
        ?>

    </section>
    <section>
        <?php
        echo "<a href='portada.php?usuarioamigo=$_SESSION[usuario]'>
                    <p id='nombre'>VisitsBook</p>
                  </a>";
        ?>
    </section>
    <section>
        <form action='salir.php' method='post'>
            <input class='botonSalir' type='submit' name='salir' value='Salir'/>
        </form>
        <?php

        $usuario_activo = $_SESSION["usuario"];

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
    echo    "<a href='biografia.php?usuarioamigo=$usuario_activo'>
            Biografía
        </a>
            -
        <a href='fotos.php?usuarioamigo=$usuario_activo'>
            Fotos
        </a>
            -
        <a href='informacion.php?usuarioamigo=$usuario_activo'>
            Información
        </a>";
    ?>
</section>
<section class="scroll">
    <?php

    $conectados = Usuario::devolverAmigos();

    for($i = 0; $i < count($conectados); ++$i) {

        $usuario = $conectados[$i]->devolverValor("usuario");

        $name = $conectados[$i]->devolverValor("nombre");

        $imagenfriend = $conectados[$i]->devolverValor("fotoperfil");

        $name_mayuscula = strtoupper($name);

        echo "<a href='portada.php?usuarioamigo=$usuario'>
                    <article class='textofoto'>
                        <p>$name_mayuscula</p>
                        <img class='fotoconectado' alt='fotoAmigo' src='$imagenfriend'/>
                    </article>
                  </a>
    

              </section
              <section class='contenidoInferior'>
                  <input id='mostrar' name='mostrar' type='checkbox'>
                  <label class='inputlabel' for='mostrar'></label>
                  <h4 class='cabecera'>USUARIOS ACTIVOS</h4>
                  <aside>";

        echo "<a href='portada.php?usuarioamigo=$usuario'>
                <article>
                    <p class='textoConectado'>$name_mayuscula</p>
                    <img class='fotoconectado' alt='fotoAmigo' src='$imagenfriend'/>
                </article>
              </a>";
    }
    ?>
    </aside>
    <section class="crearEntrada">
        <article>
            <?php

            $consulta = Usuario::obtenerUsuario($_SESSION["usuario"]);

            $nombre = $consulta->devolverValor("nombre");

            $nombre = strtoupper($nombre);

            echo "  <p>$nombre</p>
                    <img class='imagenComentario' alt='imagen perfil' src='$imagen'/>
                    ";
            ?>
            <article class="texto">
                <form action="entrada.php" method="post" enctype="multipart/form-data">
                    <input size="102" type="text" name="titulo" placeholder="Escriba aquí el título"
                           maxlength="100" required />
                    <br/>
                    <br/>
                    <textarea rows="10" cols="100" name="descripcion" placeholder="Escribe su Comentario"
                              maxlength="190" required/>
                    <br/>
                    <input class="enviar" type="submit" value="Enviar" />
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

            $nombrePerfil_mayuscula = strtoupper($nombrePerfil);

            echo "<a href='biografia.php?usuarioamigo=$usuario'>                                   
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
