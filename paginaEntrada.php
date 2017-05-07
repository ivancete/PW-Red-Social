<?php
require_once ('usuario.php');
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Crear entrada</title>
    <link rel="stylesheet" type="text/css" href="diseno.css"/>
</head>
<body>
<header>
    <section>
        <a href="portada.php">
            <img class="logo" alt="Logo" src="ugrL.png"/>
        </a>
    </section>
    <section>
        <a href="portada.php">
            <p id="nombre">VisitsBook</p>
        </a>
    </section>
    <section>
        <form action="salir.php" method="post">
            <input class="botonSalir" type="submit" name="salir" value="Salir"/>
        </form>
        <?php
        echo "<a href='paginaEntrada.php'>
                <img class='fotoPerfil' alt='Perfil' src='$_SESSION[usuario]/$_SESSION[fotoperfil]'/>
              </a>";
        ?>
    </section>
</header>
<section id="botonera">
    <a href="biografiaAlan.html">
        Biografía
    </a>
    -
    <a href="fotosAlan.html">
        Fotos
    </a>
    -
    <a href="informacionAlan.html">
        Información
    </a>
</section>
</body>
</html>
