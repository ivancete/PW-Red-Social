<?php

  require_once ('usuario.php');

  //Comprobamos que las casillas han sido rellenadas de datos, y que los password son equivalentes.

  if($_GET["registropassword"] != $_GET["registropasswordrepeticion"]) {
      echo "El password no es equivalente al de la repetición de password";
      exit;
  }

  $directorioUser = trim($_GET["correo"]);

  if(!mkdir($directorioUser, 0777)) {
      die('Fallo al crear las carpetas...');
  }


  Usuario::insertarUsuario($_GET["correo"], $_GET["registropassword"], $_GET["registronombre"],
      $_GET["registroapellidos"], $_GET["sexo"]);

  header("Location: portada.php?usuario_activo=$_GET[correo]");
  exit;


?>
