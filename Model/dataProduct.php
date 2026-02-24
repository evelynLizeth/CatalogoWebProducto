<?php
class Producto {
    public static function all($link){
        $sql = "SELECT * FROM productos";
        return mysqli_query($link, $sql);
    }

   public static function create($link, $nombre, $descripcion, $precio, $estado, $imagen){
        // Verificar si ya existe un producto con ese nombre
        $check = mysqli_query($link, "SELECT * FROM productos WHERE Nombre='$nombre'");
        if(mysqli_num_rows($check) > 0){
            return "duplicado"; // devolvemos un indicador
        }

        $sql = "INSERT INTO productos (Nombre, Descripcion, Precio, estado, imagen) 
                VALUES ('$nombre','$descripcion','$precio','$estado','$imagen')";
        return mysqli_query($link, $sql);
    }

    public static function update($link, $id, $nombre, $descripcion, $precio, $estado, $imagen){
    $sql = "UPDATE productos SET 
                Nombre='$nombre',
                Descripcion='$descripcion',
                Precio='$precio',
                estado='$estado',
                imagen='$imagen'
            WHERE id=$id";
    return mysqli_query($link, $sql);

    }

    public static function delete($link, $id){
        $sql = "DELETE FROM productos WHERE id=$id";
        return mysqli_query($link, $sql);
    }
    
}