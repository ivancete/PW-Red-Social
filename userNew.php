<?php

  require_once ('usuario.php');
  session_start();

  //Comprobamos que las casillas han sido rellenadas de datos, y que los password son equivalentes.

  if(!isset($_GET["registropassword"]) && !isset($_GET["registronombre"]) && !isset($_GET["registroapellidos"]) &&
      !isset($_GET["correo"]) && !isset($_GET["telefono"]) && !isset($_GET["registronacimiento"]) &&
      !isset($_GET["sexo"]) && !isset($_GET["registrotelefono"])) {
      echo "Ocurrió un error con el registro, vuelva a intentarlo.";
      exit;
  }

  //Miramos en la Base de datos que no exista un usuario ya con ese correo.
  if (Usuario::validarCorreo($_GET["correo"])){
      echo "Usuario ya existente";
      exit;
  }


  Usuario::insertarUsuario($_GET["correo"], $_GET["registropassword"], $_GET["registronombre"],
      $_GET["registroapellidos"], $_GET["sexo"], $_GET["registrotelefono"], $_GET["registronacimiento"]);

    if (empty($_SESSION["conectados"])){

        $_SESSION["conectados"] = array();

        $_SESSION["conectados"][] = $_GET["correo"];
    }
    else{
        $_SESSION["conectados"][] = $_GET["correo"];
    }

    $user = Usuario::obtenerUsuario($_GET["correo"]);

    $_SESSION["nombre"] = $user->devolverValor("nombre");

    $_SESSION["apellidos"] = $user->devolverValor("apellidos");

    $_SESSION["nacimiento"] = $user->devolverValor("nacimiento");

    $_SESSION["sexo"] = $user->devolverValor("sexo");

    $_SESSION["imagen"] = $user->devolverValor("fotoperfil");

    $_SESSION["telefono"] = $user->devolverValor("telefono");

    $_SESSION["usuario"] = $_GET["correo"];

    Usuario::modificarAConectado($_SESSION["usuario"]);

    $_SESSION["amigos"] = array();

    $misAmigos = Usuario::devolverAmigos($_SESSION["usuario"]);

    for ($i=0; $i < count($misAmigos); ++$i)
        $_SESSION["amigos"][] = $misAmigos[$i];

  header("Location: portada.php");
  exit;


?>
