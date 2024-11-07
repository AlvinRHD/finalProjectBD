<?php 
include '../config/db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorías</title>
    <link rel="stylesheet" href="../css/categories.css">
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
    <li><a href="#opcion3">Opción 3</a></li>
    <li><a href="#opcion4">Opción 4</a></li>
  </ul>
</nav>
<!-- Fin Menu lateral -->
    <h1>Categorías Disponibles</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de la Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM Categorias";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['categoria_id']}</td>
                            <td>{$row['nombre_categoria']}</td>
                            <td>
                            <!-- Botón de Editar -->
                        <form action='../mgmtCategories/edit_categories.php' method='GET' style='display:inline-block;'>
                            <input type='hidden' name='id' value='{$row['categoria_id']};'>
                            
                            <!-- Botón con icono de edición -->
                            <button class='btn0'>
                                <svg viewBox='0 0 24 24' height='17.5' width='17.5' xmlns='http://www.w3.org/2000/svg' class='icon'>
                                    <path d='M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34a.9959.9959 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z'/>
                                </svg>
                            </button>
                        </form>

                        <form action='../mgmtCategories/delete_categories.php' method='GET' style='display:inline-block;'>
                            <input type='hidden' name='id' value='{$row['categoria_id']}'>
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
                echo "<tr><td colspan='2'>No hay categorías disponibles</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
    <a href="../mgmtCategories/add_categories.php">
    <button class="btn-save">
            Agregar
        </button>
        </a>
</body>
</html>
