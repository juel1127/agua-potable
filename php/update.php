<?php 
include("connection.php");
$con = connection();

$id_socio = $_GET['id_socio'];

$sql = "SELECT * FROM socios WHERE id_socio='$id_socio'";
$query = mysqli_query($con, $sql);

$row = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <title>Editar usuario</title>
</head>
<body>
    <div class="users-form">
        <form action="edit_user.php" method="POST">
            <input type="hidden" name="id_socio" value="<?= $row['id_socio']?>">
            <input type="text" name="ci_socio" placeholder="Carnet" value="<?= $row['ci_socio']?>">
            <input type="text" name="apellidos" placeholder="Apellidos" value="<?= $row['apellidos']?>">
            <input type="text" name="nombre" placeholder="Nombre" value="<?= $row['nombre']?>">
            <input type="text" name="direccion" placeholder="Dirección" value="<?= $row['direccion']?>">
            <input type="text" name="numero_medidor" placeholder="Número de Medidor" value="<?= $row['numero_medidor']?>">
            <input type="text" name="telefono" placeholder="Teléfono" value="<?= $row['telefono']?>">
            <input type="text" name="fecha_alta" placeholder="Fecha Alta" value="<?= $row['fecha_alta']?>">
            <input type="submit" value="Actualizar">
        </form>
    </div>
</body>
</html>

<style>
    * {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
    }
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        color: #fff;
        min-height: 100vh;
        background-image: url(cool2.jpg);
        background-size: cover;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .users-form {
        background-color: transparent;
        color: rgb(255, 255, 255);
        text-align: center;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(255, 2, 2, 0.1);
        max-width: 400px;
        margin-top: 90px;
        position: relative;
        left: 120px;
        bottom: 90px;
    }
    input[type="text"], input[type="email"], input[type="number"], input[type="date"] {
        width: 80%;
        padding: 10px;
        margin: 5px 0 15px;
        background-color: transparent;
        border-color: transparent;
        border-bottom: solid 1px rgba(255, 255, 255, 0.2);
        color: white;
    }
    input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: white;
        color: black;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        transition: 0.5s;
        margin-top: 10px;
    }
    input[type="submit"]:hover {
        background-color: white;
        transform: scale(1.2);
    }
</style>