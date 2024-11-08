<?php
include '../config/db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de productos</title>
    <link rel="stylesheet" href="../css/productos.css">
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <br>
    <!-- Menu lateral -->
    <input type="checkbox" id="burger" class="burger-checkbox">
    <label for="burger" class="burger">
        <span></span>
        <span></span>
        <span></span>
    </label>

    <nav class="sidebar">
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="products.php">Productos</a></li>
            <li><a href="categories.php">Categorias</a></li>

        </ul>
    </nav>
    <!-- Fin Menu lateral -->

    <h1>Productos en la tienda</h1>
    <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Categoría</th>
            <th>Imagen</th> <!-- Nuevo encabezado para la imagen -->
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT p.producto_id, p.nombre, p.descripcion, p.precio, p.cantidad_disponible, c.nombre_categoria, p.imagen
                FROM Productos p
                JOIN Categorias c ON p.categoria_id = c.categoria_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['producto_id']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['descripcion']}</td>
                        <td>{$row['precio']}</td>
                        <td>{$row['cantidad_disponible']}</td>
                        <td>{$row['nombre_categoria']}</td>
                        <td>";
                
                // Mostrar imagen si existe, de lo contrario mostrar un mensaje
                if (!empty($row['imagen'])) {
                    echo "<img src='../uploads/{$row['imagen']}' alt='Imagen de {$row['nombre']}' width='50' height='50'>";
                } else {
                    echo "Sin imagen";
                }
                
                echo "</td>
                        <td>
                            <form action='../mgmtProducts/edit_products.php' method='GET' style='display:inline-block;'>
                                <input type='hidden' name='id' value='{$row['producto_id']}'>
                                <button class='btn0'>
                                    <svg viewBox='0 0 24 24' height='17.5' width='17.5' xmlns='http://www.w3.org/2000/svg' class='icon'>
                                        <path d='M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34a.9959.9959 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z'/>
                                    </svg>
                                </button>
                            </form>

                            <form action='../mgmtProducts/delete_products.php' method='GET' style='display:inline-block;'>
                                <input type='hidden' name='id' value='{$row['producto_id']}'>
                                <button class='btn'>
                                    <svg viewBox='0 0 15 17.5' height='17.5' width='15' xmlns='http://www.w3.org/2000/svg' class='icon'>
                                        <path transform='translate(-2.5 -1.25)' d='M15,18.75H5A1.251,1.251,0,0,1,3.75,17.5V5H2.5V3.75h15V5H16.25V17.5A1.251,1.251,0,0,1,15,18.75ZM5,5V17.5H15V5Zm7.5,10H11.25V7.5H12.5V15ZM8.75,15H7.5V7.5H8.75V15ZM12.5,2.5h-5V1.25h5V2.5Z' id='Fill'></path>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No hay productos disponibles</td></tr>";
        }
        $conn->close();
        ?>
    </tbody>
    </table>
    <a href="../mgmtProducts/add_products.php">
        <button class="btn-save">Agregar</button>
    </a>
</body>
</html>
