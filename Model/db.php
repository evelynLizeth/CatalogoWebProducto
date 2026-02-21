<?php
function connectDB(){
    $CON = mysli_connect("localhost","root","tareaacompaniamiento");
    return $con;
}

$link = connectDB();
