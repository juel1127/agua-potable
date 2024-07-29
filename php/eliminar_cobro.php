<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'water_db');

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$cobro_id = $_GET['id'];

// Eliminar el cobro
$sql = "DELETE FROM cobros WHERE cobro_id='$cobro_id'";
if ($conn->query($sql) === TRUE) {
    header("Location: registro_cobro.php?status=deleted");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
