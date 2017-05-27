<?php
session_start();

if (isset($_SESSION["usuario"]))
    header('Location: portada.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title>Inicio Red Social</title>
    <link rel="stylesheet" type="text/css" href="diseno.css"/>
    <!--Validación del login de un usuario -->
    <script>
        function validarLogin() {
            var x = document.forms["login"]["user"].value;
            var y = document.forms["login"]["password"].value;
            if (x == "") {
                alert("No se ha introducido usuario.");
                return false;
            }
            else if (y == "") {
                alert("No se ha introducido contraseña.");
                return false;
            }
            else if (x == y){
                alert("No pueden ser iguales el usuario y la contraseña.");
                return false;
            }
        }
    </script>

    <!--Validación del registro de un nuevo usuario -->
    <script>
        function validarRegistro() {
            var x = document.forms["register"]["registronombre"].value;
            var y = document.forms["register"]["registroapellidos"].value;
            var k = document.forms["register"]["correo"].value;
            var t = document.forms["register"]["registropassword"].value;
            var r = document.forms["register"]["registronacimiento"].value;
            var m = document.forms["register"]["sexo"].value;
            var z = document.forms["register"]["registrotelefono"].value;

            expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (x == "") {
                alert("No se ha introducido nombre.");
                return false;
            }
            else if (y == "") {
                alert("No se ha introducido apellidos.");
                return false;
            }
            else if (t == "") {
                alert("No se ha introducido password.");
                return false;
            }
            else if (t.length < 5) {
                alert("Por seguridad la contraseña debe tener más de 5 caracteres.");
                return false;
            }
            else if (t == k) {
                alert("Por seguridad la contraseña no puede ser igual que el correo.");
                return false;
            }
            else if (k == "") {
                alert("No se ha introducido correo.");
                return false;
            }
            else if (!expr.test(k)) {
                alert("La dirección de correo "+ k +" es incorrecta.");
                return false;
            }
            else if (r == "") {
                alert("No se ha introducido fecha de nacimiento.");
                return false;
            }
            else if (m == "") {
                alert("No se ha introducido sexo.");
                return false;
            }
            else if (z == "") {
                alert("No se ha introducido un teléfono.");
                return false;
            }
            else if (z.length < 9) {
                alert("Se ha introducido un número menor que 9.");
                return false;
            }
            else if (z.length > 9) {
                alert("Se ha introducido un número mayor que 9.");
                return false;
            }
            else if (isNaN(z)) {
                alert("No se ha introducido un teléfono válido.");
                return false;
            }
        }
    </script>
</head>
<body>
<header>
    <section>
        <img class="logo" alt="Logo" src="ugrL.png"/>
    </section>
    <section id="nombre">
        <p>VisitsBook</p>
    </section>
    <section id="usuario">
        <form name="login" action="login.php" method="get" onsubmit="return validarLogin()">
            <label for="user">Usuario</label>
            <br/>
            <input id="user" type="text" name="user"/>
            <br/>
            <label for="password">Contraseña</label>
            <br/>
            <input id="password" type="password" name="password" />
            <br/>
            <input type="submit" name="inicio" value="Inicio"/>
        </form>
    </section>
</header>
<section id="cuerpo">
    <section>
        <img  class="fondo" alt="Logo Red Social" src="Logo_ugr.png"/>
    </section>
    <section class="formulario">
        <p class="registro">Registrarse</p>
        <form name="register" action="userNew.php" method="get" onsubmit="return validarRegistro()">
            <input class ="datos" type="text" id="registronombre" name="registronombre" placeholder="Nombre" size=20 />
            <input class ="datos" type="text" id="registroapellidos" name="registroapellidos" placeholder="Apellidos" size=20 />
            <br/>
            <input class ="otrosDatos" type="password" id="registropassword" name="registropassword" placeholder="Contraseña" size=20 />
            <input class ="otrosDatos" type="numeric" id="registrotelefono" name="registrotelefono" size=20 placeholder="Telefono"/>
            <br/>
            <input class ="otrosDatos" type="text" id="correo" name="correo" placeholder="Correo electrónico" size=46 />
            <br/>
            <br/>
            <label for="registronacimiento">Fecha de Nacimiento:</label>
            <br/>
            <input class ="otrosDatos" type="date" id="registronacimiento" name="registronacimiento" size=46 />
            <br/>
            <input class="sexo" type="radio" name="sexo" value="Mujer" /> Mujer
            <input class="sexo" type="radio" name="sexo" value="Hombre" /> Hombre
            <input class="sexo" type="radio" name="sexo" value="Otro" /> Otro
            <br/>
            <input class="botonreg" type="submit" value="Terminado"/>
        </form>
    </section>
</section>
<footer id="footerIndex">
    <h4>
        <a href="contacto.html">
            CONTACTO
        </a>
        -
        <a href="acercaDe.html">
            ACERCA DE
        </a>
    </h4>
</footer>
</body>
</html>
