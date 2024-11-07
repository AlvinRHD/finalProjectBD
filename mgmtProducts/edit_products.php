<?php
include '../config/db_config.php';

// Verificar si se ha pasado un ID de producto
if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];

    // Obtener los datos actuales del producto
    $sql = "SELECT * FROM Productos WHERE producto_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $producto_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    // Si el producto no existe
    if (!$producto) {
        echo "Producto no encontrado.";
        exit;
    }

    // Actualizar los datos si el formulario es enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $cantidad_disponible = $_POST['cantidad'];
        $categoria_id = $_POST['categoria'];

        // Validación básica
        if (!empty($nombre) && !empty($precio) && !empty($cantidad_disponible) && !empty($categoria_id)) {
            $sql = "UPDATE Productos SET nombre = ?, descripcion = ?, precio = ?, cantidad_disponible = ?, categoria_id = ? WHERE producto_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdiii", $nombre, $descripcion, $precio, $cantidad_disponible, $categoria_id, $producto_id);

            if ($stmt->execute()) {
                echo "Producto actualizado exitosamente.";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Por favor, completa todos los campos obligatorios.";
        }
    }
} else {
    echo "ID de producto no especificado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../css/productos.css"> <!-- Asegúrate de que esté aquí -->
</head>
<body>

    <h1>Editar Producto</h1>
    
    <form action="edit_products.php?id=<?php echo $producto['producto_id']; ?>" method="POST" class="form-container">
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $producto['nombre']; ?>" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion"><?php echo $producto['descripcion']; ?></textarea>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" value="<?php echo $producto['precio']; ?>" required>

        <label for="cantidad">Cantidad Disponible:</label>
        <input type="number" id="cantidad" name="cantidad" value="<?php echo $producto['cantidad_disponible']; ?>" required>

        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <?php
            // Obtener categorías para el menú desplegable
            $sql = "SELECT * FROM Categorias";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                $selected = ($row['categoria_id'] == $producto['categoria_id']) ? 'selected' : '';
                echo "<option value='{$row['categoria_id']}' $selected>{$row['nombre_categoria']}</option>";
            }
            ?>
        </select>

        <button type="submit" class="btn-save">Actualizar Producto</button>
    </form>

    <a href="../pages/products.php" class="btn-save">Volver a la lista de productos</a>

</body>
</html>
