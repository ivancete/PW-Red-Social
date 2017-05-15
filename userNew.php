<?php

  require_once ('usuario.php');
  session_start();

  //Comprobamos que las casillas han sido rellenadas de datos, y que los password son equivalentes.

  if(!isset($_GET["registropassword"]) && !isset($_GET["registronombre"]) && !isset($_GET["registroapellidos"]) &&
      !isset($_GET["correo"]) && !isset($_GET["telefono"]) && !isset($_GET["registronacimiento"]) &&
      !isset($_GET["sexo"])) {
      echo "Ocurrió un error con el registro, vuelva a intentarlo.";
      exit;
  }

  $directorioUser = trim($_GET["correo"]);

  if(!mkdir($directorioUser, 0777)) {
      die('Fallo al crear el directorio del usuario.');
  }


  Usuario::insertarUsuario($_GET["correo"], $_GET["registropassword"], $_GET["registronombre"],
      $_GET["registroapellidos"], $_GET["sexo"], $_GET["telefono"], $_GET["registronacimiento"]);

    if (empty($_SESSION["conectados"])){

        $_SESSION["conectados"] = array();

        $_SESSION["conectados"][] = $_GET["correo"];
    }
    else{
        $_SESSION["conectados"][] = $_GET["correo"];
    }

    $_SESSION["usuario"] = $_GET["correo"];

  header("Location: portada.php");
  exit;


?>
