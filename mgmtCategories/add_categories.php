<?php
include '../config/db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura de los datos del formulario
    $nombre_categoria = $_POST['nombre_categoria'];

    if (!empty($nombre_categoria)) {
        $sql = "INSERT INTO Categorias (nombre_categoria) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre_categoria);

        if ($stmt->execute()) {
            echo "Categoría agregada exitosamente.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Por favor, completa todos los campos obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Categoría</title>
    <link rel="stylesheet" href="../css/categories.css">
</head>
<body>

    <h1>Agregar Nueva Categoría</h1>

    <form action="add_categories.php" method="POST" class="form-container">
        <label for="nombre_categoria">Nombre de la Categoría:</label>
        <input type="text" id="nombre_categoria" name="nombre_categoria" required>

        <button type="submit" class="btn-save">
            Guardar
        </button>
    </form>

    <a href="../pages/categories.php" class="btn-save">Volver a la lista de categorías</a>

</body>
</html>
