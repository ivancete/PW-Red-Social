<?php
require_once ('usuario.php');
require_once ('historia.php');
require_once ('comentario.php');
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Detalle entrada</title>
    <link rel="stylesheet" type="text/css" href="diseno.css"/>
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

        //Compruebo si el usuario amigo es el mismo que el usuario que se conectó para saber qué página mostrar.
        if(!empty($_GET)) {
            if ($_GET["usuarioamigo"] == $_SESSION["usuario"]) {
                $usuario_amigo = $_GET["usuarioamigo"];
            }
        }

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

    $usuario = $_SESSION["usuario"];

    if($usuario_amigo != $_SESSION["usuario"]){
        $usuario = $_GET["usuarioamigo"];
    }

    echo    "<a href='biografia.php?usuarioamigo=$usuario'>
            Biografía
        </a>
            -
        <a href='fotos.php?usuarioamigo=$usuario'>
            Fotos
        </a>
            -
        <a href='informacion.php?usuarioamigo=$usuario'>
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
    <section class="entrada">
        <?php

            $usuario = Usuario::obtenerUsuario($_GET["usuarioamigo"]);

            $_SESSION["usuariohistoria"] = $usuario->devolverValor("usuario");

            $nombre = $usuario->devolverValor("nombre");

            $imagenUsuario = $usuario->devolverValor("fotoperfil");

            $historia = Historia::obtenerHistoria($_GET["usuarioamigo"], $_GET["historia"]);

            $titulo = $historia->devolverValor("titulo");

            $descripcion = $historia->devolverValor("descripcion");

            $nombre = strtoupper($name);

            echo "<article class='comentario'>
                    <p>$nombre</p>
                    <img class='imagenComentario' alt='Perfil' src='$imagenUsuario'/>
                    </article>
                  <article class='comentario'>
                  <h4>$titulo</h4>
                  <p>$descripcion</p>
                  </article>";
        ?>

    </section>
    <?php

        $comentarios = Comentario::obtenerComentarios($_GET["usuarioamigo"], $_GET["historia"]);

        if($comentarios) {

            echo "<section class='comentariosEntrada'>";

            for ($i = 0; $i < count($comentarios); ++$i) {

                $usuario = $comentarios[$i]->devolverValor("usuariocreadorcomentario");

                $fecha = $comentarios[$i]->devolverValor("fecha");

                $descripcion = $comentarios[$i]->devolverValor("descripcion");

                $usuarioComentario = Usuario::obtenerUsuario($usuario);

                $imagen = $usuarioComentario->devolverValor("fotoperfil");

                $nombre = strtoupper($nombre);

                echo "<article class='comentario'>
                          <p>$nombre - $fecha</p>
                          <img class='imagenComentario' alt='Perfil' src='$imagen'/>
                          <p>$descripcion</p>
                      </article>";
            }
        
             echo "</section>";
        }

        $usuario = Usuario::obtenerUsuario($_SESSION["usuario"]);

        $imagen = $usuario->devolverValor("fotoperfil");

        $nombre = $usuario->devolverValor("nombre");

        $nombre = strtoupper($nombre);

        $_SESSION["idhistoria"] = $_GET["historia"];

        echo "<section class='entradaPropia'>
            <article  class='comentario'>
                <img class='imagenComentario' alt='Perfil' src='$imagen'/>
                <p>$nombre</p>
                <form action='procesarComentario.php' method='post'>
                    <textarea id = 'areaComentario' name='areaComentario' rows='6' cols='80' placeholder='Escriba su Comentario'></textarea>
                    <input id = 'areaBoton' type='submit' name='enviar' value='Publicar'/>
                </form>
            </article>
        </section>";
    ?>
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
