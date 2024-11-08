<?php
include 'db_config.php';

if ($conn) {
    echo "Conexion exitosa a base de datos tienda xd";
}else {
    echo "Error en la conexion a la base de datos";
}

$conn->close();
?>