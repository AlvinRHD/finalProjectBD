<?php
include '../config/db_config.php';

// Verificar si se ha pasado un ID de categoría
if (isset($_GET['id'])) {
    $categoria_id = $_GET['id'];

    // Obtener los datos actuales de la categoría
    $sql = "SELECT * FROM Categorias WHERE categoria_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoria_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $categoria = $result->fetch_assoc();

    // Si la categoría no existe
    if (!$categoria) {
        echo "Categoría no encontrada.";
        exit;
    }

    // Actualizar los datos si el formulario es enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre_categoria = $_POST['nombre_categoria'];

        // Validación básica
        if (!empty($nombre_categoria)) {
            $sql = "UPDATE Categorias SET nombre_categoria = ? WHERE categoria_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $nombre_categoria,$categoria_id);

            if ($stmt->execute()) {
                echo "Categoría actualizada exitosamente.";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Por favor, completa todos los campos obligatorios.";
        }
    }
} else {
    echo "ID de categoría no especificado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoría</title>
    <link rel="stylesheet" href="../css/categories.css">
</head>
<body>

    <h1>Editar Categoría</h1>

    <form action="edit_categories.php?id=<?php echo $categoria['categoria_id']; ?>" method="POST" class="form-container">
        <label for="nombre_categoria">Nombre de la Categoría:</label>
        <input type="text" id="nombre_categoria" name="nombre_categoria" value="<?php echo $categoria['nombre_categoria']; ?>" required>

    
        <button type="submit" class="btn-save">Actualizar Categoría</button>
    </form>

    <a href="../pages/categories.php" class="btn-save">Volver a la lista de categorías</a>

</body>
</html>
