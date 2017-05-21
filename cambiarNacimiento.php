<?php
require_once ('usuario.php');
require_once ('historia.php');

session_start();

if(isset($_GET["registronacimiento"])){

    if ($_GET["registronacimiento"] != $_SESSION["nacimiento"]) {

        Usuario::modificarNacimiento($_SESSION["usuario"], $_GET["registronacimiento"]);

        $user = Usuario::obtenerUsuario($_SESSION["usuario"]);

        $_SESSION["nacimiento"] = $user->devolverValor("nacimiento");

        header('Location: informacion.php');
        exit;
    }
}
else{
    echo "Ocurrió un error";
    exit;
}
?>