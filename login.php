<?php
  require_once ('usuario.php');

  session_start();

  if(Usuario::validarUsuario($_GET["user"],$_GET["password"]) ){

      $_SESSION["usuario"] = $_GET["user"];

      if (empty($_SESSION["conectados"])){

          $_SESSION["conectados"] = array();

          $_SESSION["conectados"][] = $_GET["user"];
      }
      else{
          $_SESSION["conectados"][] = $_GET["user"];
      }

      header("Location: portada.php");
      exit;
  }
  else{
      echo "Usuario o contraseña incorrecto";
      exit;
  }

?>
