<?php
  require_once ('usuario.php');

  session_start();

  if(Usuario::validarUsuario($_GET["user"],$_GET["password"]) ){

      $_SESSION["usuario"] = $_GET["user"];

      header('Location: portada.php');
      exit;
  }
  else{
      echo "Usuario o contraseña incorrecto";
      exit;
  }

?>
