<?php
function connection(){
    $host = "localhost";
    $user = "root"; // Cambiar por tu nombre de usuario de MySQL
    $password = ""; // Cambiar por tu contraseña de MySQL
    $db = "water_db"; // Cambiar por el nombre de tu base de datos
    $con = mysqli_connect($host, $user, $password, $db);
    if(!$con){
        die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
    }                                                                                                                                                                       
    return $con;
}
?>
