<?php
// Datos para la conexion
$host = 'localhost';
$database = 'kurewenc_db_portia';
$username = 'kurewenc_portia';
$password = 'kureportiawenc';
global $conn;
// Conectarse a MySQL
$conn = mysqli_connect($host, $username, $password,$database);
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>
