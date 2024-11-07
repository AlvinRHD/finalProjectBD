<?php
include '../config/db_config.php';

// Verificar si se ha pasado un ID de producto
if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];

    // Eliminar el producto de la base de datos cuando se confirme la acción
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        $sql = "DELETE FROM Productos WHERE producto_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $producto_id);

        if ($stmt->execute()) {
            echo "<script>alert('Producto eliminado exitosamente.'); window.location.href = '../pages/products.php';</script>";
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Si no se confirma, redirige o muestra un mensaje de cancelación
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
