<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'water_db');

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$deudor_id = $_GET['id'];

// Eliminar el cobro
$sql = "DELETE FROM deudores WHERE deudor_id='$deudor_id'";
if ($conn->query($sql) === TRUE) {
    header("Location: registro_deuda.php?status=deleted");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
