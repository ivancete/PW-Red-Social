<?php
  require_once ('usuario.php');

  session_start();

  if(Usuario::validarUsuario($_GET["user"],$_GET["password"]) ){

      if (empty($_SESSION["conectados"])){

          $_SESSION["conectados"] = array();

          $_SESSION["conectados"][] = $_GET["user"];
      }
      else{
          $_SESSION["conectados"][] = $_GET["user"];
      }

      header("Location: portada.php?usuario_activo=$_GET[user]");
      exit;
  }
  else{
      echo "Usuario o contraseña incorrecto";
      exit;
  }

?>
