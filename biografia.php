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
    <meta charset="UTF-8"/>
    <title>Biografía</title>
    <link rel="stylesheet"  href="diseno.css"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">

        function mostrarTitulos(usuario) {

            var variable = usuario.target.id;


            $.ajax({

                type: "GET",

                url: "titulosUsuario.php?usuario="+variable+"",

                success: function (response){
                    var myWindow = window.open("", "Títulos", "width=300,height=300");
                    myWindow.document.write(response);
                },

                error: function(response) {
                    alert("Error al mostrar los títulos");
                },
            });
        }

        function cerrarTitulos(){
            myWindow.close();
        }
    </script>
</head>
<body onload="cerrarTitulos()">
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
        <form action='salir.php' method='post'>
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
                        <img id='$usuario' class='fotoconectado' alt='fotoAmigo' src='$imagenfriend' onmouseover='mostrarTitulos(event)'/>
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
                    <img id='$usuario' class='fotoconectado' alt='fotoAmigo' src='$imagenfriend' onmouseover='mostrarTitulos(event)'/>
                </article>
              </a>";
        }
        ?>
    </aside>
    <section class="historia">
        <?php

        $historias_mias = Historia::obtenerHistoriasMiasOrdenadas($usuario_mostrar, $numerosig, 9);

        $flechas = true;

        if(count($historias_mias) < 9)
            $flechas = false;

        for($i = 0; $i < count($historias_mias); ++$i) {

            $descripcion = $historias_mias[$i]->devolverValor("descripcion");

            $descripcionSub = substr($descripcion,0,50);

            if(strlen($descripcion) > 50)
                $descripcionSub = $descripcionSub." +";

            $titulo = $historias_mias[$i]->devolverValor("titulo");

            $fecha = $historias_mias[$i]->devolverValor("fecha");

            $titulo_mayuscula = strtoupper($titulo);

            $usuario = $historias_mias[$i]->devolverValor("usuario");

            $persona = Usuario::obtenerUsuario($usuario);

            $imagenPerfil = $persona->devolverValor("fotoperfil");

            $nombrePerfil = $persona->devolverValor("nombre");

            $nombrePerfil_mayuscula = strtoupper($nombrePerfil);

            $idhistoria = $historias_mias[$i]->devolverValor("idhistoria");

            echo "<a href='detalleHistoria.php?historia=$idhistoria&usuarioamigo=$usuario'>                                   
                    <article class='historiaIndividual'>
                        <p>$nombrePerfil_mayuscula</p>
                        <img class='fotoconectado' alt='perfilAmigo' src='$imagenPerfil'/>
                        <h4>$titulo_mayuscula</h4>
                        <p>$descripcionSub</p>
                        <p>$fecha</p>
                    </article>
                  </a>";
        }
        ?>
    </section>
</section>
<section>
    <?php

    if ($flechas) {

        $auxNumSigIzq = $numerosig - 9;

        if ($auxNumSigIzq < 0)
            $auxNumSigIzq = 0;

        echo "<a href='portada.php?numerosig=$auxNumSigIzq&usuarioamigo=$usuario_mostrar'>
                    <img class='flecha' alt='flechaIzq' src='flecha_izq.png'/>
              </a>";

        $auxNumSigDer = $numerosig + 9;

        $historias_amigos = Historia::obtenerHistoriasMiasOrdenadas($usuario_mostrar, $auxNumSigDer, 9);

        if (!$historias_amigos)
            $auxNumSigDer = $numerosig;

        echo "<a href='portada.php?numerosig=$auxNumSigDer&usuarioamigo=$usuario_mostrar'>
                     <img class='flecha' alt='flechaDch' src='flecha_der.png' />
              </a>";
    }
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
