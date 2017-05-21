<?php
require_once ('usuario.php');
require_once ('historia.php');

session_start();

if(isset($_GET["registronombre"]) && isset($_GET["registroapellidos"])){

    if ($_GET["registronombre"] != $_SESSION["nombre"] && $_GET["registroapellidos"] != $_SESSION["apellidos"]) {

        Usuario::modificarNombre($_SESSION["usuario"], $_GET["registronombre"], $_GET["registroapellidos"]);

        $user = Usuario::obtenerUsuario($_SESSION["usuario"]);

        $_SESSION["nombre"] = $user->devolverValor("nombre");

        $_SESSION["apellidos"] = $user->devolverValor("apellidos");

        header('Location: informacion.php');
        exit;
    }
}
else {
    echo "Ocurrió un error";
    exit;
}
?>