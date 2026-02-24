<?php
include("../Model/db.php");
include("../Model/dataProduct.php");

$action = $_POST['action'] ?? $_GET['action'] ?? null;

switch($action){
   case 'create':
    $imagen = null;
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0){
        $ruta = "uploads/" . basename($_FILES['imagen']['name']);
        move_uploaded_file($_FILES['imagen']['tmp_name'], "../" . $ruta);
        $imagen = $ruta;
    }

    $result = Producto::create(
        $link,
        $_POST['Nombre'],
        $_POST['Descripcion'],
        $_POST['Precio'],
        $_POST['estado'],
        $imagen   // <-- aquí agregamos el sexto argumento
    );

    if($result === "duplicado"){
        header("Location: ../View/crud.php?msg=El producto ya existe");
    } else {
        header("Location: ../View/crud.php?msg=Producto creado correctamente");
    }
    break;

   case 'update':
    $imagen = null;

    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0){
        $ruta = "uploads/" . basename($_FILES['imagen']['name']);
        move_uploaded_file($_FILES['imagen']['tmp_name'], "../" . $ruta);
        $imagen = $ruta;
    } else {
        // Si no se subió nueva imagen, recupera la que ya está en BD
        $producto = mysqli_fetch_assoc(mysqli_query($link, "SELECT imagen FROM productos WHERE id=".$_POST['id']));
        $imagen = $producto['imagen'];
    }

    Producto::update(
        $link,
        $_POST['id'],
        $_POST['Nombre'],
        $_POST['Descripcion'],
        $_POST['Precio'],
        $_POST['estado'],
        $imagen
    );

    header("Location: ../View/crud.php?msg=Producto actualizado correctamente");
    break;
    
    case 'delete':
        Producto::delete($link, $_GET['id']);
        header("Location: ../View/crud.php?msg=Producto eliminado correctamente");
        break;

    default:
        header("Location: ../View/crud.php");
}