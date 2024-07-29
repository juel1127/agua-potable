<?php
include("connection.php");
$con = connection();

$id_socio = $_POST["id_socio"];
$ci_socio = $_POST['ci_socio'];
$apellidos = $_POST['apellidos'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$numero_medidor = $_POST['numero_medidor']; // Agregamos la variable para el número de medidor
$telefono = $_POST['telefono'];
$fecha_alta = $_POST['fecha_alta'];

$sql = "UPDATE socios SET ci_socio='$ci_socio', apellidos='$apellidos', nombre='$nombre', direccion='$direccion',  numero_medidor='$numero_medidor', telefono='$telefono', fecha_alta='$fecha_alta' WHERE id_socio='$id_socio'";
$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: socios.php");
} else {
    echo "Error al actualizar usuario";
}
?>
