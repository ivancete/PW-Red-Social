<?php
require_once ('usuario.php');
require_once ('historia.php');

session_start();

if(isset($_GET["registropassword"])){

    Usuario::modificarPassword($_SESSION["usuario"],$_GET["registropassword"]);

    header('Location: informacion.php');
    exit;
}
else
    echo "Ocurrió un error";
?>