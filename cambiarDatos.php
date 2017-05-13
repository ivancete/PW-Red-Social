<?php
require_once ('usuario.php');
require_once ('historia.php');

session_start();

if(!empty($_POST["registronombre"]) && !empty($_POST["registroapellidos"]) &&
    !empty($_POST["registropasswordantiguo"]) && !empty($_POST["registropassword"])
    && !empty($_POST["registropasswordrepeticion"]) && !empty($_POST["sexo"])){

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