<?php
$servername = "localhost";
$username = "root";
$password = "witty";
$dbname = "TiendaEnLinea";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Error en la conexion: " . $conn->connect_error);
}
?>