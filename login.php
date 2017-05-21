<?php
  require_once ('usuario.php');

  session_start();

  if(Usuario::validarUsuario($_GET["user"],$_GET["password"]) ){

      $_SESSION["usuario"] = $_GET["user"];

      $_SESSION["password"] = $_GET["password"];

      $user = Usuario::obtenerUsuario($_GET["user"]);

      $_SESSION["nombre"] = $user->devolverValor("nombre");

      $_SESSION["apellidos"] = $user->devolverValor("apellidos");

      $_SESSION["nacimiento"] = $user->devolverValor("nacimiento");

      $_SESSION["sexo"] = $user->devolverValor("sexo");

      $_SESSION["imagen"] = $user->devolverValor("fotoperfil");

      $_SESSION["telefono"] = $user->devolverValor("telefono");

      $_SESSION["amigos"] = array();

      $misAmigos = Usuario::devolverAmigos($_SESSION["usuario"]);

      for ($i=0; $i < count($misAmigos); ++$i)
          $_SESSION["amigos"][] = $misAmigos[$i];

      Usuario::modificarAConectado($_GET["user"]);

      header("Location: portada.php");
      exit;
  }
  else{
      echo "Usuario o contraseña incorrecto";
      exit;
  }

?>
