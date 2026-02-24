<?php
include("../Model/db.php");
include("../Model/dataProduct.php");

// Filtro de precios
$min = $_GET['min'] ?? 0;
$max = $_GET['max'] ?? 9999;

$sql = "SELECT * FROM productos WHERE Precio BETWEEN $min AND $max";
$result = mysqli_query($link, $sql);
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Catálogo de productos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4 text-center">

  <!-- Encabezado centrado -->
  <h1 class="mb-4">Catálogo de productos</h1>

  <!-- Botón y filtro en una sola línea centrada -->
  <div class="d-flex justify-content-center align-items-end mb-4 gap-3">
    <a href="crud.php" class="btn btn-primary">Configuración de productos</a>

  <!-- Filtro a la derecha -->
  <form method="GET" class="d-flex align-items-end gap-3">
    <div class="form-group">
      <label class="form-label">Precio mínimo</label>
      <input type="number" step="0.01" name="min" class="form-control" value="<?php echo $min; ?>">
    </div>
    <div class="form-group">
      <label class="form-label">Precio máximo</label>
      <input type="number" step="0.01" name="max" class="form-control" value="<?php echo $max; ?>">
    </div>
    <button type="submit" class="btn btn-success">Filtrar</button>
  </form>

</div>

  <!-- Cuadrícula de productos -->
  <div class="row">
    <?php while($row = mysqli_fetch_assoc($result)){ ?>
      <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm">
          <?php if($row['imagen']): ?>
            <img src="../<?php echo $row['imagen']; ?>" 
                 class="card-img-top" 
                 alt="<?php echo $row['Nombre']; ?>" 
                 style="height:200px; object-fit:cover;">
          <?php else: ?>
            <img src="https://via.placeholder.com/300x300?text=Sin+Imagen" 
                 class="card-img-top" 
                 alt="Sin imagen">
          <?php endif; ?>
          <div class="card-body text-center">
            <h5 class="card-title"><?php echo $row['Nombre']; ?></h5>
            <p class="card-text fw-bold">$<?php echo number_format($row['Precio'], 2); ?></p>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>