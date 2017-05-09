<?php

    require_once ('usuario.php');
    require_once ('historia.php');
    session_start();

    if (isset($_GET)) {

        $descripcion = $_GET["descripcion"];

        $titulo = $_GET["titulo"];

        $user = Usuario::obtenerUsuario($_SESSION["usuario"]);

        $refimagen = $user->devolverValor("fotoperfil");

        Historia::insertarHistoria($descripcion ,$titulo , $refimagen , $_SESSION["usuario"]);
    }

    header('Location: paginaEntrada.php');
    exit;
?>