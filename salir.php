<?php
require_once ('usuario.php');

session_start();

Usuario::modificarADesconectado($_SESSION["usuario"]);

session_unset();
session_destroy();
header('Location: index.php');
exit;

?>