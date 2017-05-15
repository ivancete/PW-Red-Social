<?php
require_once ('usuario.php');
require_once ('historia.php');

session_start();

if(!isset($_POST["registronombre"]) && !isset($_POST["registroapellidos"]) &&
    !isset($_POST["registropasswordantiguo"]) && !isset($_POST["registropassword"])
    && !isset($_POST["registropasswordrepeticion"]) && !isset($_POST["sexo"]) && !isset($_POST["registronacimiento"])
    && !isset($_POST["registrotelefono"])){

    if(Usuario::validarUsuario($_SESSION["usuario"],$_POST["registropasswordantiguo"]) &&
        $_POST["registropasswordrepeticion"] == $_POST["registropassword"]){


        Usuario::modificarUsuario($_SESSION["usuario"] ,$_POST["registropasswordrepeticion"],
            $_POST["registronombre"] ,$_POST["registroapellidos"], $_POST["sexo"]);

        header('Location: informacion.php');
        exit;

    }
    else
        echo "No existe ningún usuario con esa contraseña, o 
        escribió la nueva contraseña incorrectamente en el segundo campo";
}
else
    echo "No se enviaron los registros correspondientes al formulario". var_dump($_POST);
?>