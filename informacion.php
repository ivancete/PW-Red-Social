<?php
require_once ('usuario.php');
require_once ('historia.php');
session_start();

if(!isset($_SESSION["usuario"])) {
    header('Location:index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Información</title>
    <link rel="stylesheet"  href="diseno.css"/>
    <script>
        function validarNombre() {
            var x = document.forms["cambiarDatos"]["registronombre"].value;
            if (x == "") {
                alert("No se ha introducido el nombre nuevo.");
                return false;
            }
        }

        function validarApellido() {
            var x = document.forms["cambiarDatos"]["registroapellidos"].value;
            if (x == "") {
                alert("No se ha introducido el apellido nuevo.");
                return false;
            }
        }

        function validarTelefono() {
            var x = document.forms["cambiarDatos"]["registrotelefono"].value;
            if (x == "") {
                alert("No se ha introducido teléfono.");
                return false;
            }
            else if (x.length > 9) {
                alert("El teléfono debe tener 9 números.");
                return false;
            }
            else if (x.length < 9) {
                alert("El teléfono debe tener 9 números.");
                return false;
            }
            else if (isNaN(x)) {
                alert("El número de teléfono no es válido.");
                return false;
            }
        }

        function validarPassword() {
            var x = document.forms["cambiarDatos"]["registropasswordvieja"].value;
            var y = document.forms["cambiarDatos"]["registropassword"].value;
            if (x == "") {
                alert("No se ha introducido el password viejo.");
                return false;
            }
            else if (y == ""){
                alert("No se ha introducido el password nuevo.");
                return false;
            }
            else if (y == x){
                alert("Por razones de seguridad, el password viejo no puede ser igual al antiguo.");
                return false;
            }
            else if (y.length < 5) {
                alert("Por seguridad la contraseña debe tener más de 5 caracteres.");
                return false;
            }
        }

        function validarNacimiento() {
            var x = document.forms["cambiarDatos"]["registronacimiento"].value;
            if (x == "") {
                alert("No se ha introducido una fecha de nacimiento.");
                return false;
            }
        }

        function validarSexo() {
            var x = document.forms["cambiarDatos"]["sexo"].value;
            if (x == "") {
                alert("No se ha introducido un sexo.");
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

        if (isset($_GET["usuarioamigo"])) {
            //Compruebo si el usuario amigo es el mismo que el usuario que se conectó para saber qué página mostrar.
            if ($_SESSION["usuario"] != $_GET["usuarioamigo"]) {
                $usuario_mostrar = $_GET["usuarioamigo"];

                $pocaInfo = true;

            }
            else {
                $usuario_mostrar = $_SESSION["usuario"];

                $pocaInfo = false;

            }
        }
        else {
            $usuario_mostrar = $_SESSION["usuario"];

            $pocaInfo = false;

        }

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

    if($pocaInfo){
        $usuario_mostrar = $_GET["usuarioamigo"];
    }

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
    <?php
    //Solamente es necesario introducir la contraseña actual para modificar algún datos
    if(!$pocaInfo) {

        echo " <section class='infoDatos'>
                    <h2>Modificar Datos</h2>
                        <form name='cambiarNombre' action='cambiarNombre.php' method='get' onsubmit='return validarNombre()'>
                            <input class ='datos' type='text' id='registronombre' name='registronombre' placeholder='Nombre' size=20 />
                        </form>
                        <form name='cambiarApellido' action='cambiarApellido.php' method='get' onsubmit='return validarApellido()'>
                            <input class ='datos' type='text' id='registroapellidos' name='registroapellidos' placeholder='Apellidos' size=20 />
                        </form>
                        <form name='cambiarTelefono' action='cambiarTelefono.php' method='get' onsubmit='return validarTelefono()'>
                            <input class ='otrosDatos' type='tel' id='registrotelefono' name='registrotelefono' placeholder='Teléfono' size='20' />
                        </form>
                        <form name='cambiarPassword' action='cambiarPassword.php' method='get' onsubmit='return validarPassword()'>
                            <input class ='otrosDatos' type='tel' id='registropasswordvieja' name='registropasswordvieja' placeholder='Contraseña Vieja' size='20' />
                            <input class ='otrosDatos' type='password' name='registropassword' placeholder='Contraseña Nueva' size=20 />
                        </form>  
                        <form name='cambiarNacimiento' action='cambiarNacimiento.php' method='get' onsubmit='return validarNacimiento()'>
                            <label for='registronacimiento'>Fecha de Nacimiento:</label>
                            <br/>
                            <input class ='otrosDatos' type='date' id='registronacimiento' name='registronacimiento' size=46 />
                        </form>
                        <form name='cambiarSexo' action='cambiarSexo.php' method='get' onsubmit='return validarSexo()'>
                            <input class='sexo' type='radio' id='sexo' name='sexo' value='Mujer' /> Mujer
                            <input class='sexo' type='radio' id='sexo' name='sexo' value='Hombre' /> Hombre
                            <input class='sexo' type='radio' id='sexo' name='sexo' value='Otro' /> Otro
                        </form>
                            <input class='botonreg' type='submit' value='Terminado'/> 
                        </form>
                </section>";

        $datosUsuario = Usuario::obtenerUsuario($usuario_mostrar);

        $user = $_SESSION["usuario"];

        $contraseña = "*****";

        $nombre = $datosUsuario->devolverValor("nombre");

        $apellidos = $datosUsuario->devolverValor("apellidos");

        $sexo = $datosUsuario->devolverValor("sexo");

        $telefono = $datosUsuario->devolverValor("telefono");

        $fechaNacimiento = $datosUsuario->devolverValor("nacimiento");

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
                        <p>Teléfono : $telefono</p>
                        <br/>
                        <p>Fecha de Nacimiento : $fechaNacimiento</p>
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

        $fechaNacimiento = $datosUsuario->devolverValor("nacimiento");

        echo "    <section class='infoDatos'>
                    <h2>Datos Actuales</h2>
                        <p>Nombre : $nombre</p>
                        <br/>
                        <p>Apellidos : $apellidos</p>
                        <br/>
                        <p>Sexo : $sexo</p>
                        <br/>
                        <p>Fecha de Nacimiento : $fechaNacimiento</p>
                  </section>";
    }
    ?>

<footer id="informacion">
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
