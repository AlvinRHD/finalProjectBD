<?php
include 'db_config.php';

if ($conn) {
    echo "Conexion exitosa a base de datos tienda xd";
}else {
    echo "Erroe en la conexion a la base de datos";
}

$conn->close();
?>