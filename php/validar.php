<?php

include('db.php');

$USUARIO = $_POST['usuario'];
$PASSWORD = $_POST['password'];

$consulta = "SELECT* FROM personal where usuario = '$USUARIO' and password ='$PASSWORD' ";
$resultado = mysqli_query($conexion, $consulta);

$filas = mysqli_num_rows($resultado);

if($filas){
    // Redireccionar al archivo inicio.html dentro de la carpeta html
    header("location: ../html/inicio.html");
} else {
    // Incluir el archivo index.html dentro de la carpeta html
    include("../html/index.html");
    ?>
    <h1>ERROR DE AUTENTIFICACION</h1>
    <?php
}

mysqli_free_result($resultado);
mysqli_close($conexion);

?>
