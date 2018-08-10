<?php
  // Datos para la conexion
  if (isset($_SESSION["mode"])) {
    $host = 'localhost';
    $database = 'kurewenc_db_portia';
    $username = 'root';
    $password = '';
  } else {
    $host = 'localhost';
    $database = 'postulacion';
    $username = 'postulacion';
    $password = 'Web.Portia.2018';   
  }

  // Conectarse a MySQL
  global $conn;
  $conn = mysqli_connect($host, $username, $password, $database);
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>
