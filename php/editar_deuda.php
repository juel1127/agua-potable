<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'water_db');

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deudor_id = $_POST['deudor_id'];
    $fecha_ultimo_aviso = $_POST['fecha_ultimo_aviso'];
    $monto_adeudado = $_POST['monto_adeudado'];

    // Actualizar la deuda
    $sql = "UPDATE deudores SET fecha_ultimo_aviso='$fecha_ultimo_aviso', monto_adeudado='$monto_adeudado' WHERE deudor_id='$deudor_id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: registro_deuda.php?status=updated");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $deudor_id = $_GET['id'];
    $sql = "SELECT * FROM deudores WHERE deudor_id='$deudor_id'";
    $result = $conn->query($sql);
    $deudor = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Deuda</title>
</head>
<body>
    <form method="POST" action="editar_deuda.php">
        <input type="hidden" name="deudor_id" value="<?php echo $deudor['deudor_id']; ?>">
        Fecha último aviso: <input type="date" name="fecha_ultimo_aviso" value="<?php echo $deudor['fecha_ultimo_aviso']; ?>" required><br>
        Monto Adeudado: <input type="text" name="monto_adeudado" value="<?php echo $deudor['monto_adeudado']; ?>" required><br>
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
    background-image: url(img/azul.jpg);
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
