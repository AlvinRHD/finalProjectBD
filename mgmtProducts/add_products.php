<?php
include '../config/db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura de los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad_disponible = $_POST['cantidad'];
    $categoria_id = $_POST['categoria'];

    if (!empty($nombre) && !empty($precio) && !empty($cantidad_disponible) && !empty($categoria_id)) {
        $sql = "INSERT INTO Productos (nombre, descripcion, precio, cantidad_disponible, categoria_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $cantidad_disponible, $categoria_id);

        if ($stmt->execute()) {
            echo "Producto agregado exitosamente.";
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
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="../css/productos.css">
</head>
<body>

    <h1>Agregar Nuevo Producto</h1>

    <form action="add_products.php" method="POST" class="form-container">
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion"></textarea>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" required>

        <label for="cantidad">Cantidad Disponible:</label>
        <input type="number" id="cantidad" name="cantidad" required>

        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <?php
            $sql = "SELECT * FROM Categorias";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['categoria_id']}'>{$row['nombre_categoria']}</option>";
            }
            ?>
        </select>

        <button type="submit" class="btn-save">
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path class="icon-path" d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zM10 17l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            Guardar
        </button>
    </form>

    <a href="../pages/products.php" class="btn-save">Volver a la lista de productos</a>

</body>
</html>
