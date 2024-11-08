<?php
include 'config/db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>principal</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/cardsproductos.css">
</head>
<body>

<input type="checkbox" id="burger" class="burger-checkbox">
<label for="burger" class="burger">
  <span></span>
  <span></span>
  <span></span>
</label>

<nav class="sidebar">
  <ul>
  <li><a href="index.php">Home</a></li>
    <li><a href="pages/products.php">Productos</a></li>
    <li><a href="pages/categories.php">Categorias</a></li>
  </ul>
</nav>


<h1>Tienda de Productos</h1>

<!-- Filtro de categorías -->
<form method="GET" action="index.php">
    <label for="categoria">Filtrar por Categoría:</label>
    <select id="categoria" name="categoria" onchange="this.form.submit()">
        <option value="">Todas las Categorías</option>
        <?php
        // Obtener todas las categorías para el filtro
        $sql = "SELECT * FROM Categorias";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $selected = (isset($_GET['categoria']) && $_GET['categoria'] == $row['categoria_id']) ? 'selected' : '';
            echo "<option value='{$row['categoria_id']}' $selected>{$row['nombre_categoria']}</option>";
        }
        ?>
    </select>
</form>
<div class="productos-grid">
    <?php
    include 'config/db_config.php';

    // Obtener productos y categorías
    $categoria_id = isset($_GET['categoria']) ? $_GET['categoria'] : '';
    $sql = "SELECT p.*, c.nombre_categoria FROM Productos p
            JOIN Categorias c ON p.categoria_id = c.categoria_id";
    if (!empty($categoria_id)) {
        $sql .= " WHERE p.categoria_id = ?";
    }
    $stmt = $conn->prepare($sql);
    if (!empty($categoria_id)) {
        $stmt->bind_param("i", $categoria_id);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    //<!-- Mostrar productos según la categoría -->

while ($row = $result->fetch_assoc()) {
    echo "
    <div class='card'>
        <img src='uploads/{$row['imagen']}' alt='{$row['nombre']}'>
        <div class='card-details'>
            <p class='text-title'>{$row['nombre']}</p>
            <p>Precio: $ {$row['precio']}</p>
        </div>
        <button class='card-button' onclick='openModal(\"{$row['nombre']}\", \"{$row['imagen']}\", \"{$row['descripcion']}\", \"{$row['precio']}\", \"{$row['cantidad_disponible']}\")'>Más info</button>
    </div>";
}
?>
</div>

<!-- Modal para mostrar más detalles -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <h2 id="modal-title"></h2>
        <img id="modal-image" src="" alt="" style="width: 100%; border-radius: 10px; object-fit: cover; max-height: 200px;">
        <p id="modal-description"></p>
        <p><strong>Precio: $<span id="modal-price"></span></strong></p>
        <p><strong>Cantidad disponible: <span id="modal-quantity"></span></strong></p>
    </div>
</div>

<script>
    function openModal(title, image, description, price, quantity) {
        document.getElementById("modal").style.display = "block";
        document.getElementById("modal-title").textContent = title;
        document.getElementById("modal-image").src = 'uploads/' + image;
        document.getElementById("modal-description").textContent = description;
        document.getElementById("modal-price").textContent = price;
        document.getElementById("modal-quantity").textContent = quantity;
    }

    function closeModal() {
        document.getElementById("modal").style.display = "none";
    }

    // Cerrar modal cuando se hace clic fuera de la modal
    window.onclick = function(event) {
        var modal = document.getElementById("modal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>


</body>
</html>
