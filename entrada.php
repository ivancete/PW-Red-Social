<?php

    require_once ('usuario.php');
    require_once ('historia.php');
    session_start();

    if (isset($_GET["descripcion"]) && isset($_GET["titulo"]) && isset($_SESSION["creador_historia"]) && !empty($_SESSION["creador_historia"])) {

        $descripcion = $_GET["descripcion"];

        $titulo = $_GET["titulo"];

        $user = Usuario::obtenerUsuario($_SESSION["creador_historia"]);

        $refimagen = $user->devolverValor("fotoperfil");

        Historia::insertarHistoria($descripcion ,$titulo , $refimagen , $_SESSION["creador_historia"]);
    }

    header("Location: portada.php?usuario_activo=$_SESSION[creador_historia]");
    exit;
?>