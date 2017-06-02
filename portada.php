<?php
require_once ('usuario.php');
require_once ('historia.php');
session_start();

if(!isset($_SESSION["usuario"])){
    header('Location:index.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title>Portada</title>
    <link rel="stylesheet"  href="diseno.css"/>
    <link rel="stylesheet"  href="dS.css" media="(max-width: 480px)"/>
    <meta charset="UTF-8" name="viewport" content="width=device−width, initial−scale=1.0, url=portada.php"
          http-equiv="refresh"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">

        var myWindow;

        function mostrarTitulos(usuario) {

            var variable = usuario.target.id;


            $.ajax({

                type: "GET",

                url: "titulosUsuario.php?usuario="+variable+"",

                success: function (response){
                    myWindow = window.open("", "Títulos", "width=300,height=300");
                    myWindow.document.write(response);
                },

                error: function(response) {
                    alert("Error al mostrar los títulos");
                },
            });
        }
    </script>
</head>
<body">
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

        //Comprobamos en la página de la portada en la que estamos.
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

    for($i = 0; $i < count($_SESSION["amigos"]); ++$i) {

        $usuario = $_SESSION["amigos"][$i]->devolverValor("usuario");

        $name = $_SESSION["amigos"][$i]->devolverValor("nombre");

        $imagenfriend = $_SESSION["amigos"][$i]->devolverValor("fotoperfil");

        $name_mayuscula = strtoupper($name);

        echo "<a href='biografia.php?usuarioamigo=$usuario'>
                    <article class='textofoto'>
                        <p>$name_mayuscula</p>
                        <img id='$usuario' class='fotoconectado' alt='fotoAmigo' src='$imagenfriend' 
                        onmouseover='mostrarTitulos(event)'/>
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

            $historias_amigos = Historia::obtenerHistoriasAmigosOrdenadas($_SESSION["usuario"],$numerosig);

            $flechas = true;

            if(count($historias_amigos) < 9)
                $flechas = false;


            for($i = 0; $i < count($historias_amigos); ++$i) {

                $usuario = $historias_amigos[$i]->devolverValor("usuario");

                $idhistoria = $historias_amigos[$i]->devolverValor("idhistoria");

                $descripcion = $historias_amigos[$i]->devolverValor("descripcion");

                $titulo = $historias_amigos[$i]->devolverValor("titulo");

                $fecha = $historias_amigos[$i]->devolverValor("fecha");

                $persona = Usuario::obtenerUsuario($usuario);

                $imagenPerfil = $persona->devolverValor("fotoperfil");

                $nombrePerfil = $persona->devolverValor("nombre");

                $nombrePerfil_mayuscula = strtoupper($nombrePerfil);

                $titulo_mayuscula = strtoupper($titulo);

                $descripcionSub = substr($descripcion,0,50);

                if(strlen($descripcion) > 50)
                    $descripcionSub = $descripcionSub." +";

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

    if($flechas) {

        $auxNumSigIzq = $numerosig - 9;

        if ($auxNumSigIzq < 0)
            $auxNumSigIzq = 0;

        echo "<a href='portada.php?numerosig=$auxNumSigIzq'>
                    <img class='flecha' alt='flechaIzq' src='flecha_izq.png'/>
              </a>";

        $auxNumSigDer = $numerosig + 9;

        $historias_amigos = Historia::obtenerHistoriasAmigosOrdenadas($_SESSION["usuario"], $auxNumSigDer);

        if (!$historias_amigos)
            $auxNumSigDer = $numerosig;

        echo "<a href='portada.php?numerosig=$auxNumSigDer'>
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
