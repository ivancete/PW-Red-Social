<?php
require_once ('usuario.php');
require_once ('historia.php');
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title>Información</title>
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

        if(isset($_GET["numerosig"])){
            $numerosig = $_GET["numerosig"];
        }
        else
            $numerosig = 0;

        //Compruebo si el usuario amigo es el mismo que el usuario que se conectó para saber qué página mostrar.
        if ($_GET["usuario_activo"] != $_GET["usuarioamigo"]) {
            $usuario_mostrar = $_GET["usuarioamigo"];
            $pocaInfo = true;
        }
        else {
            $usuario_mostrar = $_GET["usuario_activo"];
        }

        $consulta = Usuario::obtenerUsuario($_GET["usuario_activo"]);

        $imagen = $consulta->devolverValor("fotoperfil");

        echo "<a href='paginaEntrada.php?usuario_activo=$_GET[usuario_activo]'>
                        <img class='fotoPerfil' alt='fotoPerfil' src='$imagen'/>
                  </a>";
        ?>
    </section>
</header>
<section id="botonera">
    <?php

    $usuario = $_GET["usuario_activo"];

    if($pocaInfo){
        $usuario_mostrar = $_GET["usuarioamigo"];
    }

    echo    "<a href='biografia.php?usuario_activo=$usuario_activo&usuarioamigo=$usuario_mostrar'>
            Biografía
        </a>
            -
        <a href='fotos.php?usuario_activo=$usuario_activo&usuarioamigo=$usuario_mostrar'>
            Fotos
        </a>
            -
        <a href='informacion.php?usuario_activo=$usuario_activo&usuarioamigo=$usuario_mostrar'>
            Información
        </a>";
    ?>
</section>
    <?php
    //Solamente es necesario introducir la contraseña actual para modificar algún datos
    if(!$pocaInfo) {
        echo " <section class='infoDatos'>
                    <h2>Modificar Datos</h2>
                        <form action='cambiarDatos.php' method='post'>
                            <input class ='datos' type='text' id='registronombre' name='registronombre' placeholder='Nombre' size=20 required/>
                            <input class ='datos' type='text' id='registroapellidos' name='registroapellidos' placeholder='Apellidos' size=20 required/>
    
                            <input class ='otrosDatos' type='password' name='registropasswordantiguo'
                                    placeholder='Contraseña Actual' size=20 required/>
                            <input class ='otrosDatos' type='password' name='registropassword' placeholder='Contraseña Nueva' size=20 required/>
                            <input class ='otrosDatos' type='password' name='registropasswordrepeticion'
                                    placeholder='Repita Contraseña Nueva' size=20 required/>
    
                            <input class='sexo' type='radio' name='sexo' value='Mujer' required/> Mujer
                            <input class='sexo' type='radio' name='sexo' value='Hombre' required/> Hombre
    
                            <input type='file' value='Subir Imagen de Perfil'/>
                            <input class='botonreg' type='submit' value='Terminado'/> 
                        </form>
                </section>";

        $datosUsuario = Usuario::obtenerUsuario($usuario_mostrar);

        $user = $_GET["usuarioamigo"];

        $contraseña = "*****";

        $nombre = $datosUsuario->devolverValor("nombre");

        $apellidos = $datosUsuario->devolverValor("apellidos");

        $sexo = $datosUsuario->devolverValor("sexo");

        echo "    <section class='infoDatos'>
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
    }
    else{
        $datosUsuario = Usuario::obtenerUsuario($usuario_mostrar);

        $user = $_GET["usuarioamigo"];

        $nombre = $datosUsuario->devolverValor("nombre");

        $apellidos = $datosUsuario->devolverValor("apellidos");

        $sexo = $datosUsuario->devolverValor("sexo");

        echo "    <section class='infoDatos'>
                    <h2>Datos Actuales</h2>
                        <p>Usuario : $user </p>
                        <br/>
                        <p>Nombre : $nombre</p>
                        <br/>
                        <p>Apellidos : $apellidos</p>
                        <br/>
                        <p>Sexo : $sexo</p>
                  </section>";
    }
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
