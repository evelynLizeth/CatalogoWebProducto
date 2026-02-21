<?php
include("../Model/db.php");
include("../Model/dataProduct.php");

$action = $_POST['action'] ?? $_GET['action'] ?? null;

switch($action){
    case 'create':
        $result = Producto::create($link, $_POST['Nombre'], $_POST['Descripcion'], $_POST['Precio'], $_POST['estado']);
        if($result === "duplicado"){
            header("Location: ../View/crud.php?msg=El producto ya existe");
        } else {
            header("Location: ../View/crud.php?msg=Producto creado correctamente");
        }
        break;
    case 'update':
        Producto::update($link, $_POST['id'], $_POST['Nombre'], $_POST['Descripcion'], $_POST['Precio'], $_POST['estado']);
        header("Location: ../View/crud.php?msg=Producto actualizado correctamente");
        break;

    case 'delete':
        Producto::delete($link, $_GET['id']);
        header("Location: ../View/crud.php?msg=Producto eliminado correctamente");
        break;

    default:
        header("Location: ../View/crud.php");
}