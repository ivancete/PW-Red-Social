<?php
require_once ('usuario.php');
require_once ('historia.php');
require_once ('comentario.php');
session_start();

if(!isset($_SESSION["usuario"])) {
    header('Location:index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Detalle entrada</title>
    <link rel="stylesheet" type="text/css" href="diseno.css"/>

    <!--Validación de la creación de un comentario -->
    <script>
        function validarComentario() {
            var x = document.forms["comentario"]["areaComentario"].value;
            if (x == "") {
                alert("No se ha introducido comentario.");
                return false;
            }
            if (x.length > 190) {
                alert("Se han introducido más de 190 caracteres en el comentario.");
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

        $usuario_mostrar = $_SESSION["usuario"];

        if (isset($_GET["usuarioamigo"])) {
            //Compruebo si el usuario amigo es el mismo que el usuario que se conectó para saber qué página mostrar.
            if ($_SESSION["usuario"] != $_GET["usuarioamigo"]) {

                $usuario_mostrar = $_GET["usuarioamigo"];

            }
        }

        echo "<a href='paginaEntrada.php'>
                        <img class='fotoPerfil' alt='fotoPerfil' src='$_SESSION[imagen]'/>
                  </a>";
        ?>
    </section>
</header>
<section id="botonera">
    <?php
    echo    "<a href='biografia.php?usuarioamigo=$usuario_mostrar'>
            Biografía
        </a>
            -
        <a href='fotos.php?usuarioamigo=$usuario_mostrar'>
            Fotos
        </a>
            -
        <a href='informacion.php?usuarioamigo=$usuario_mostrar'>
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

        echo "<a href='biografia.php?usuarioamigo=$usuario'>
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
    <section class="entrada">
        <?php

            $usuario = Usuario::obtenerUsuario($_GET["usuarioamigo"]);

            $_SESSION["usuariohistoria"] = $usuario->devolverValor("usuario");

            $nombre = $usuario->devolverValor("nombre");

            $imagenUsuario = $usuario->devolverValor("fotoperfil");

            $historia = Historia::obtenerHistoria($_GET["usuarioamigo"], $_GET["historia"]);

            $titulo = $historia->devolverValor("titulo");

            $descripcion = $historia->devolverValor("descripcion");

            $nombre = strtoupper($nombre);

            echo "<article class='comentario'>
                    <p>$nombre</p>
                    <img class='imagenComentarioOtra' alt='Perfil' src='$imagenUsuario'/>
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

                $nombre = strtoupper($usuarioComentario->devolverValor("nombre"));

                echo "<article class='comentario'>
                          <p>$nombre - $fecha</p>
                          <img class='imagenComentarioOtra' alt='Perfil' src='$imagen'/>
                          <p>$descripcion</p>
                      </article>";
            }
        
             echo "</section>";
        }

        $nombre = strtoupper($_SESSION["nombre"]);

        $_SESSION["idhistoria"] = $_GET["historia"];

        echo "<section class='entradaPropia'>
            <article  class='comentario'>
                <img class='imagenComentarioOtra' alt='Perfil' src='$_SESSION[imagen]'/>
                <p>$nombre</p>";
        ?>
                <form name='comentario' action='procesarComentario.php' method='get' onsubmit='return validarComentario()'>
                    <textarea id = 'areaComentario' name='areaComentario' rows='6' cols='80' placeholder='Escriba su Comentario'></textarea>
                    <input id = 'areaBoton' type='submit' name='enviar' value='Publicar'/>
                </form>
            </article>
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
