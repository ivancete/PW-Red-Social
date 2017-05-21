<?php
require_once ('usuario.php');
require_once ('historia.php');
require_once ('comentario.php');

session_start();

if (!empty($_GET["areaComentario"])){

    $idhistoria = $_SESSION["idhistoria"];

    $usuariohistoria = $_SESSION["usuariohistoria"];

    $usuariocomentario = $_SESSION["usuario"];

    Comentario::insertarComentario($idhistoria, $usuariohistoria, $usuariocomentario,$_GET["areaComentario"]);

    header("Location: detalleHistoria.php?historia=$idhistoria&usuarioamigo=$usuariohistoria");
    exit;
}
else
    echo "Debe rellenar el campo para que se guarde su comentario.";

?>