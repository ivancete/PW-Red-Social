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
            var x = document.forms["cambiarNombre"]["registronombre"].value;
            var y = document.forms["cambiarNombre"]["registroapellidos"].value;
            if (x == "") {
                alert("No se ha introducido el nombre nuevo.");
                return false;
            }
            else if (y == "") {
                alert("No se ha introducido el apellido nuevo.");
                return false;
            }
        }

        function validarPassword() {
            var x = document.forms["cambiarPassword"]["registropasswordvieja"].value;
            var y = document.forms["cambiarPassword"]["registropassword"].value;
            if (x == "") {
                alert("No se ha introducido el password viejo.");
                return false;
            }
            else if (x == ) {
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

        function validarTelefono() {
            var x = document.forms["cambiarTelefono"]["registrotelefono"].value;
            if (x == "") {
                alert("No se ha introducido el teléfono nuevo.");
                return false;
            }
            else if (isNaN(x)) {
                alert("No se ha introducido un teléfono correcto1.");
                return false;
            }
            else if (x.length < 9) {
                alert("No se ha introducido un teléfono correcto2.");
                return false;
            }
            else if (x.length > 9) {
                alert("No se ha introducido un teléfono correcto3.");
                return false;
            }
        }

        function validarNacimiento() {
            var x = document.forms["cambiarNacimiento"]["registronacimiento"].value;
            if (x == "") {
                alert("No se ha introducido una fecha de nacimiento.");
                return false;
            }
        }

        function validarSexo() {
            var x = document.forms["cambiarSexo"]["sexo"].value;
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

        echo "<a href='paginaEntrada.php'>
                        <img class='fotoPerfil' alt='fotoPerfil' src='$_SESSION[imagen]'/>
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
                    <h2>Modificar Datos</h2>";?>
                        <form name="cambiarNombre" action="cambiarNombre.php" method="get" onsubmit="return validarNombre();">
                            <input class ="datos" type="text" id="registronombre" name="registronombre" placeholder="Nombre" size=20 />
                            <input class ='datos' type='text' id='registroapellidos' name='registroapellidos' placeholder='Apellidos' size=20 />
                            <input type="submit" value="Guardar"/>
                        </form>
                        <form name='cambiarPassword' action='cambiarPassword.php' method='get' onsubmit='return validarPassword()'>
                            <input class ='otrosDatos' type='password' id='registropasswordvieja' name='registropasswordvieja' placeholder='Contraseña Vieja' size='20' />
                            <input class ='otrosDatos' type='password' name='registropassword' placeholder='Contraseña Nueva' size=20 />
                            <input type='submit' value='Guardar'/>
                        </form>  
                        <br/>
                        <form name='cambiarTelefono' action='cambiarTelefono.php' method='get' onsubmit='return validarTelefono()'>
                            <label for="registrotelefono">Número de Teléfono:</label>
                            <input class ="otrosDatos" type="number" id="registrotelefono" name="registrotelefono" size=20 placeholder="Telefono"/>
                            <input type='submit' value='Guardar'/>
                        </form>
                        <form name='cambiarNacimiento' action='cambiarNacimiento.php' method='get' onsubmit='return validarNacimiento()'>
                            <label for="registronacimiento">Fecha de Nacimiento:</label>
                            <input class ='otrosDatos' type='date' id='registronacimiento' name='registronacimiento' size=46 placeholder="Nacimiento"/>
                            <input type='submit' value='Guardar'/>
                        </form>
                        <form name='cambiarSexo' action='cambiarSexo.php' method='get' onsubmit='return validarSexo()'>
                            <input class='sexo' type='radio' id='sexo' name='sexo' value='Mujer' /> Mujer
                            <input class='sexo' type='radio' id='sexo' name='sexo' value='Hombre' /> Hombre
                            <input class='sexo' type='radio' id='sexo' name='sexo' value='Otro' /> Otro
                            <input type='submit' value='Guardar'/>
                        </form>
<?php   echo"  </section>";



        echo "    <section class='infoDatos'>
                    <h2>Datos Actuales</h2>
                        <p>Usuario : $_SESSION[usuario] </p>
                        <br/>
                        <p>Contraseña : *********</p>
                        <br/>
                        <p>Nombre : $_SESSION[nombre]</p>
                        <br/>
                        <p>Apellidos : $_SESSION[apellidos]</p>
                        <br/>
                        <p>Fecha de Nacimiento : $_SESSION[nacimiento]</p>
                        <br/>
                        <p>Telefono : $_SESSION[telefono]</p>
                        <br/>
                        <p>Sexo : $_SESSION[sexo]</p>
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
