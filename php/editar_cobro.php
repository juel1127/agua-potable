<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'water_db');

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cobro_id = $_POST['cobro_id'];
    $monto = $_POST['monto'];
    $fecha_cobro = $_POST['fecha_cobro'];
    $descripcion = $_POST['descripcion'];

    // Actualizar el cobro
    $sql = "UPDATE cobros SET monto='$monto', fecha_cobro='$fecha_cobro', descripcion='$descripcion' WHERE cobro_id='$cobro_id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: registro_cobro.php?status=updated");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $cobro_id = $_GET['id'];
    $sql = "SELECT * FROM cobros WHERE cobro_id='$cobro_id'";
    $result = $conn->query($sql);
    $cobro = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Cobro</title>
</head>
<body>
    <form method="POST" action="editar_cobro.php">
        <input type="hidden" name="cobro_id" value="<?php echo $cobro['cobro_id']; ?>">
        Monto: <input type="text" name="monto" value="<?php echo $cobro['monto']; ?>" required><br>
        Fecha de Cobro: <input type="date" name="fecha_cobro" value="<?php echo $cobro['fecha_cobro']; ?>" required><br>
        Descripción: <textarea name="descripcion" required><?php echo $cobro['descripcion']; ?></textarea><br>
        <input type="submit" value="Actualizar">
    </form>
    <style>
        * {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
}

body {
    color: #fff;
    min-height: 100vh;
    background-image: url(../img/azul.jpg);
    background-size: cover;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    padding-top: 50px;
}

h1, h2 {
    color: white;
    border-bottom: solid 4px rgba(255, 255, 255, 0.2);
    text-align: center;
    margin-bottom: 20px;
}

form {
    background: transparent;
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    color: white;
    text-align: center;
    position: relative;
}

input[type="text"],
input[type="email"],
input[type="number"],
input[type="date"],
textarea {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: none;
    border-bottom: solid 1px rgba(255, 255, 255, 0.2);
    color: white;
    background-color: transparent;
    border-radius: 3px;
    box-sizing: border-box;
}

textarea {
    height: 100px;
}

button[type="submit"] {
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

button[type="submit"]:hover {
    background-color: rgb(181, 195, 233);
    transform: scale(1.2);
}

.error {
    color: red;
}

    </style>
</body>
</html>
