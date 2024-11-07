<?php
include '../config/db_config.php';

if (isset($_GET['id'])) {
    $categoria_id = $_GET['id'];

    if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        $sql = "DELETE FROM Categorias WHERE categoria_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $categoria_id);

        if ($stmt->execute()) {
            echo "<script>alert('Categoria eliminado exitosamente.'); window.location.href = '../pages/categories.php';</script>";
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Si no se confirma, redirige o muestra un mensaje de cancelación
        echo "<script>
            if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
                window.location.href = '?id={$categoria_id}&confirm=yes';
            } else {
                window.location.href = '../pages/categories.php';
            }
        </script>";
    }
} else {
    echo "ID de la categotia no especificado.";
}
?>
