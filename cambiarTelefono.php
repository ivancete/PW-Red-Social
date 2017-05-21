<?php
require_once ('usuario.php');
require_once ('historia.php');

session_start();

if(isset($_GET["registrotelefono"]) ) {

    if ($_GET["registrotelefono"] != $_SESSION["telefono"]) {

        Usuario::modificarTelefono($_SESSION["usuario"], $_GET["registrotelefono"]);

        $user = Usuario::obtenerUsuario($_SESSION["usuario"]);

        $_SESSION["telefono"] = $user->devolverValor("telefono");

        header('Location: informacion.php');
        exit;
    }
}
else{
    echo "Ocurrió un error";
    exit;
}
?>