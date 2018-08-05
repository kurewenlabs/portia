<?php
// Datos para la conexion
/* $host = 'localhost';
$database = 'postulacion';
$username = 'postulacion';
$password = 'Web.Portia.2018'; */
$host = 'localhost';
$database = 'kurewenc_db_portia';
$username = 'root';
$password = '';
global $conn;
// Conectarse a MySQL
$conn = mysqli_connect($host, $username, $password, $database);
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// session_start();
// echo "<pre>";
// print_r($_SESSION["postdata"]);
// echo "</pre>";

?>
