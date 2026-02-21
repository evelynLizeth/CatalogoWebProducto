<?php
function connectDB(){
    // OJO: el orden correcto es host, usuario, contraseña, base de datos
    $CON = mysqli_connect("localhost", "root", "", "tareaacompaniamiento");

    if(!$CON){
        die("Error de conexión: " . mysqli_connect_error());
    }
    return $CON;
}

$link = connectDB();
?>
