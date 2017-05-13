<?php
require_once ('usuario.php');
require_once ('historia.php');
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title>Portada</title>
    <link rel="stylesheet"  href="diseno.css"/>
    <link rel="stylesheet"  href="dS.css" media="(max-width: 480px)"/>
    <meta charset="UTF-8" name="viewport" content="width=device−width, initial−scale=1.0, url=portada.html"
          http-equiv="refresh"/>
</head>
<body>
<header>
    <section>
        <?php
            echo "<a href='portada.php?usuario_activo=$_GET[usuario_activo]'>
                    <img class='logo' alt='Logo' src='ugrL.png'/>
                 </a>";
        ?>

    </section>
    <section>
        <?php
            echo "<a href='portada.php?usuario_activo=$_GET[usuario_activo]'>
                    <p id='nombre'>VisitsBook</p>
                  </a>";
        ?>
    </section>
    <section>
        <form action='salir.php' method='post'>
            <input class='botonSalir' type='submit' name='salir' value='Salir'/>
        </form>
        <?php

        //Comprobamos en la página de la portada en la que estamos.
        if(isset($_GET["numerosig"])){
            $numerosig = $_GET["numerosig"];
        }
        else
            $numerosig = 0;

        $usuario_activo = $_GET["usuario_activo"];

        $consulta = Usuario::obtenerUsuario($usuario_activo);

        $imagen = $consulta->devolverValor("fotoperfil");

            echo "<a href='paginaEntrada.php?usuario_activo=$usuario_activo'>
                        <img class='fotoPerfil' alt='fotoPerfil' src='$imagen'/>
                  </a>";
        ?>
    </section>
</header>
<section id="botonera">
<?php
echo    "<a href='biografia.php?usuario_activo=$usuario_activo&usuarioamigo=$usuario_activo'>
            Biografía
        </a>
            -
        <a href='fotos.php?usuario_activo=$usuario_activo&usuarioamigo=$usuario_activo'>
            Fotos
        </a>
            -
        <a href='informacion.php?usuario_activo=$usuario_activo&usuarioamigo=$usuario_activo'>
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

        echo "<a href='biografia.php?usuario_activo=$usuario_activo&usuarioamigo=$usuario'>
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

    for ($i = 0; $i < count($_SESSION["conectados"]); ++$i){

        $usuario = $_SESSION["conectados"][$i];

        $datos = Usuario::obtenerUsuario($usuario);

        $nombre = $datos->devolverValor("nombre");

        $nombre = strtoupper($nombre);

        $imagenfriend = $datos->devolverValor("fotoperfil");

        echo "<a href='biografia.php?usuario_activo=$usuario_activo&usuarioamigo=$usuario'>
                <article>
                    <p class='textoConectado'>$nombre</p>
                    <img class='fotoconectado' alt='fotoAmigo' src='$imagenfriend'/>
                </article>
              </a>";
    }
    ?>
    </aside>
    <section class="historia">
        <?php

            $historias_amigos = Historia::obtenerHistoriasAmigos($usuario_activo);

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

                echo "<a href='detalleHistoria.php?historia=$idhistoria&usuario_activo=$usuario_activo&usuarioamigo=$usuario'>                                   
                        <article class='historiaIndividual'>
                            <p>$nombrePerfil_mayuscula</p>
                            <img class='fotoconectado' alt='perfilAmigo' src='$imagenPerfil'/>
                            <h4>$titulo_mayuscula</h4>
                            <p>$descripcion</p>
                            <p>$fecha</p>
                        </article>
                      </a>";
            }
        ?>
    </section>
</section>
<section>
    <?php

        $auxNumSigIzq = $numerosig - 9;

        if ($auxNumSigIzq < 0)
            $auxNumSigIzq = 0;

        echo "<a href='portada.php?usuario_activo=$usuario_activo&numerosig=$auxNumSigIzq&usuarioamigo=$usuario_activo'>
                    <img class='flecha' alt='flechaIzq' src='flecha_izq.png'/>
              </a>";

        $auxNumSigDer = $numerosig + 9;

        $historias_amigos = Historia::obtenerHistoriasAmigosOrdenadas($usuario_activo, $auxNumSigDer,9);

        if(!$historias_amigos)
            $auxNumSigDer = $numerosig;

        echo "<a href='portada.php?usuario_activo=$usuario_activo&numerosig=$auxNumSigDer&usuarioamigo=$usuario_activo'>
                     <img class='flecha' alt='flechaDch' src='flecha_der.png' />
              </a>";
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
