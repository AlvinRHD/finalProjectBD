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
        $imagen = $_FILES['imagen'];

        // Validación básica
        if (!empty($nombre) && !empty($precio) && !empty($cantidad_disponible) && !empty($categoria_id)) {
            
            // Manejo de la carga de la imagen si se ha subido una nueva
            $imagen_nombre = $producto['imagen']; // Mantener la imagen actual si no se cambia
            if (!empty($imagen['name'])) {
                $target_dir = "../uploads/";
                $target_file = $target_dir . basename($imagen["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Verificar que el archivo sea una imagen
                $allowed_types = ["jpg", "jpeg", "png", "gif"];
                if (in_array($imageFileType, $allowed_types)) {
                    if (move_uploaded_file($imagen["tmp_name"], $target_file)) {
                        $imagen_nombre = basename($imagen["name"]); // Actualizar el nombre de la nueva imagen
                    } else {
                        echo "Error al subir la nueva imagen.";
                    }
                } else {
                    echo "Formato de archivo no permitido. Solo JPG, JPEG, PNG y GIF.";
                }
            }

            // Actualizar el producto en la base de datos, incluyendo la imagen si se cambió
            $sql = "UPDATE Productos SET nombre = ?, descripcion = ?, precio = ?, cantidad_disponible = ?, categoria_id = ?, imagen = ? WHERE producto_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdissi", $nombre, $descripcion, $precio, $cantidad_disponible, $categoria_id, $imagen_nombre, $producto_id);

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
    <link rel="stylesheet" href="../css/productos.css">
</head>
<body>

    <h1>Editar Producto</h1>
    
    <form action="edit_products.php?id=<?php echo $producto['producto_id']; ?>" method="POST" enctype="multipart/form-data" class="form-container">
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

        <label for="imagen">Imagen del Producto (opcional):</label>
        <input type="file" id="imagen" name="imagen" accept="image/*">
        <?php if (!empty($producto['imagen'])): ?>
            <p>Imagen actual: <img src="../uploads/<?php echo $producto['imagen']; ?>" alt="Imagen del producto" style="width: 100px;"></p>
        <?php endif; ?>

        <button type="submit" class="btn-save">Actualizar Producto</button>
    </form>

    <a href="../pages/products.php" class="btn-save">Volver a la lista de productos</a>

</body>
</html>
