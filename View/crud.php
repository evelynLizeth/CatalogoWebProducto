<?php
include("../Model/db.php");
include("../Model/dataProduct.php");

// Si viene un id por GET, cargamos ese producto para edición
$editProduct = null;
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $result = mysqli_query($link, "SELECT * FROM productos WHERE id=$id");
    $editProduct = mysqli_fetch_assoc($result);
}

// Obtener todos los productos
$productos = Producto::all($link);
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Crud de productos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <center><h1>Crud de productos</h1></center>

  <!-- Mensajes -->
  <?php if(isset($_GET['msg'])): ?>
    <div class="alert alert-success" id="alertMsg">
      <?php echo $_GET['msg']; ?>
    </div>
  <?php endif; ?>

  <!-- Formulario -->
  <div class="card mb-4">
    <div class="card-header">
      <?php echo $editProduct ? "Editar producto" : "Agregar nuevo producto"; ?>
    </div>
    <div class="card-body">
      <form action="../Controller/producto.php" method="POST">
        <input type="hidden" name="action" value="<?php echo $editProduct ? 'update' : 'create'; ?>">
        <?php if($editProduct): ?>
          <input type="hidden" name="id" value="<?php echo $editProduct['id']; ?>">
        <?php endif; ?>

        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" name="Nombre" 
                   value="<?php echo $editProduct['Nombre'] ?? ''; ?>" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Descripción</label>
            <input type="text" class="form-control" name="Descripcion" 
                   value="<?php echo $editProduct['Descripcion'] ?? ''; ?>" required>
          </div>
          <div class="col-md-2">
            <label class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" name="Precio" 
                   value="<?php echo $editProduct['Precio'] ?? ''; ?>" required>
          </div>
          <div class="col-md-2">
            <label class="form-label">Estado</label>
            <select class="form-select" name="estado">
              <option value="1" <?php echo ($editProduct && $editProduct['estado']==1) ? 'selected' : ''; ?>>Activo</option>
              <option value="0" <?php echo ($editProduct && $editProduct['estado']==0) ? 'selected' : ''; ?>>Inactivo</option>
            </select>
          </div>
        </div>
          <!-- Imagen -->
        <div class="col-md-4">
          <label class="form-label">Imagen</label>
          <input type="file" class="form-control" name="imagen">
          <?php if($editProduct && $editProduct['imagen']): ?>
            <p class="mt-2">Imagen actual:</p>
            <img src="<?php echo $editProduct['imagen']; ?>" width="120">
            <input type="hidden" name="imagen_actual" value="<?php echo $editProduct['imagen']; ?>">
          <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-<?php echo $editProduct ? 'warning' : 'success'; ?> mt-3">
          <?php echo $editProduct ? "Actualizar" : "Guardar"; ?>
        </button>
      </form>
    </div>
  </div>

  <!-- Tabla -->
  <div class="card">
    <div class="card-header">Lista de productos</div>
    <!-- Tabla -->  <div class="card-body">
      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
            <th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Estado</th><th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = mysqli_fetch_assoc($productos)){ ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['Nombre']; ?></td>
            <td><?php echo $row['Descripcion']; ?></td>
            <td><?php echo $row['Precio']; ?></td>
            <td><?php echo $row['estado'] ? 'Activo' : 'Inactivo'; ?></td>
            <td>
              <a href="crud.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
              <a href="../Controller/producto.php?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  // Ocultar mensajes después de 2 segundos
  setTimeout(function(){
    let alertBox = document.getElementById('alertMsg');
    if(alertBox){ alertBox.style.display = 'none'; }
  }, 2000);
</script>
</body>
</html>