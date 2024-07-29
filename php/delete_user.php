<?php
include("connection.php");
$con = connection();

$socio_id = $_GET['id_socio'];

$sql_delete = "DELETE FROM socios WHERE socio_id = $socio_id";
$query = mysqli_query($con, $sql);

if($query){
    header("Location: socios.php");
}else{
    echo "Error al eliminar usuario";
}
?>
