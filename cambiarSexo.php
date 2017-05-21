<?php
require_once ('usuario.php');
require_once ('historia.php');

session_start();

if(isset($_GET["sexo"])){

    if ($_GET["sexo"] != $_SESSION["sexo"]) {

        Usuario::modificarSexo($_SESSION["usuario"], $_GET["sexo"]);

        $user = Usuario::obtenerUsuario($_SESSION["usuario"]);

        $_SESSION["sexo"] = $user->devolverValor("sexo");

        header('Location: informacion.php');
        exit;
    }
}
else {
    echo "Ocurrió un error";
    exit;
}
?>