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

  // Almacenar el hash de la contraseña
  $consulta  = sprintf("INSERT INTO login(usuario,password) VALUES('%s','%s');",
                  pg_escape_string($user),
                  password_hash($password, PASSWORD_DEFAULT));

  $resultado = pg_query($conn, $consulta);

  echo "succefully register";

  header('Location: portada.html');
  exit;


?>
