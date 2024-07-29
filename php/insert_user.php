<?php
include("connection.php");
$con = connection();

$ci_socio = $_POST['ci_socio'];
$apellidos = $_POST['apellidos'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$numero_medidor = $_POST['numero_medidor'];
$telefono = $_POST['telefono'];
$fecha_alta = $_POST['fecha_alta'];

// Verificar si el ci_socio ya existe
$check_sql = "SELECT ci_socio FROM socios WHERE ci_socio = '$ci_socio'";
$check_query = mysqli_query($con, $check_sql);
if(mysqli_num_rows($check_query) > 0) {
    echo "El número de socio ya está en uso.";
} else {
    // Si no existe, realizar la inserción
    $sql = "INSERT INTO socios (ci_socio, apellidos, nombre, direccion, numero_medidor, telefono, fecha_alta) VALUES ('$ci_socio', '$apellidos', '$nombre', '$direccion',  '$numero_medidor', '$telefono', '$fecha_alta')";
    $query = mysqli_query($con, $sql);

    if ($query) {
        header("Location: socios.php");
    } else {
        echo "Error al agregar usuario";
    }
}
?>
