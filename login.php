<?php

  echo "connecting .....";

  $servername = "localhost";
  $database = "miprueba";
  $username = "root";
  $password = "root";

  // Create connection

  $conn = mysqli_connect($servername, $username, $password, $database);

  // Check connection

  if (!$conn) {

      die("Connection failed: " . mysqli_connect_error());

  }


  $user = $_REQUEST["campoUsuario"];
  $password = $_REQUEST["campoPassword"];

  // Consultar si el usuario envió la contraseña correcta
  $consulta = sprintf("SELECT password FROM login WHERE name='%s';",
                  pg_escape_string($user));

  $fila = pg_fetch_assoc(pg_query($conn, $consulta));

  if ($fila && password_verify($contraseña, $fila['password'])) {
      echo 'Bienvenido, ' . htmlspecialchars($user) . '!';
  } else {
      echo 'La autenticación ha fallado para ' . htmlspecialchars($user) . '.';
  }

  echo "succefully connect";

  header('Location: portada.html');
  exit;

?>
