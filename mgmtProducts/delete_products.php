<?php
include '../config/db_config.php';

// Verificar si se ha pasado un ID de producto
if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];

    // Consultar el producto para obtener el nombre de la imagen antes de eliminar
    $sql = "SELECT imagen FROM Productos WHERE producto_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $producto_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();
    $stmt->close();

    // Verificar que el producto exista
    if (!$producto) {
        echo "Producto no encontrado.";
        exit;
    }

    // Confirmar y ejecutar eliminación
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        // Eliminar el producto de la base de datos
        $sql = "DELETE FROM Productos WHERE producto_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $producto_id);

        if ($stmt->execute()) {
            // Eliminar la imagen asociada del servidor si existe
            if (!empty($producto['imagen']) && file_exists("../uploads/" . $producto['imagen'])) {
                unlink("../uploads/" . $producto['imagen']);
            }
            echo "<script>alert('Producto eliminado exitosamente.'); window.location.href = '../pages/products.php';</script>";
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Mostrar mensaje de confirmación si no se ha confirmado aún
        echo "<script>
            if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
                window.location.href = '?id={$producto_id}&confirm=yes';
            } else {
                window.location.href = '../pages/products.php';
            }
        </script>";
    }
} else {
    echo "ID de producto no especificado.";
}
?>
