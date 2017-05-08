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
<?php
if($usuario_amigo == $_SESSION["usuario"]) {
    echo " <section class='infoDatos'>
                <h2>Modificar Datos</h2>
    
                  <form action='cambiarInformacion.php' method='post'>
                    <input class ='datos' type='text' name='registronombre' placeholder='Nombre' size=20/>
                    <input class ='datos' type='text' name='registroapellidos' placeholder='Apellidos' size=20/>
                    <br/>
                    <input class ='otrosDatos' type='text' name='correo' placeholder='Correo electrónico' size=46/>
                    <br/>
                    <input class ='otrosDatos' type='password' name='registropassword' placeholder='Contraseña' size=20/>
                    <input class ='otrosDatos' type='password' name='registropasswordrepeticion'
                           placeholder='Repita Contraseña' size=20/>
                    <br/>
                    <input class='sexo' type='radio' name='sexo' value='Mujer'> Mujer
                    <input class='sexo' type='radio' name='sexo' value='Hombre'> Hombre
                    <br/>
                    <input type='file' value='Subir Imagen de Perfil'/>
                    <input class='botonreg' type='submit' value='Terminado'/>
                  </form>
            </section>";
}

    $datosUsuario = Usuario::obtenerUsuario($_GET["usuarioamigo"]);

    $user = $_GET["usuarioamigo"];

    $contraseña = $datosUsuario->devolverValor("password");

    $nombre = $datosUsuario->devolverValor("nombre");

    $apellidos = $datosUsuario->devolverValor("apellidos");

    $sexo = $datosUsuario->devolverValor("sexo");

    echo"    <section class='infoDatos'>
                <h2>Datos Actuales</h2>
                    <p>Usuario : $user </p>
                    <br/>
                    <p>Contraseña : $contraseña</p>
                    <br/>
                    <p>Nombre : $nombre</p>
                    <br/>
                    <p>Apellidos : $apellidos</p>
                    <br/>
                <p>Sexo : $sexo</p>
            </section>";
?>

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
