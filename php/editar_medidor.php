<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'water_db');

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lectura_id = $_POST['lectura_id'];
    $medidor_id = $_POST['medidor_id'];
    $fecha_lectura = $_POST['fecha_lectura'];
    $lectura_anterior = $_POST['lectura_anterior'];
    $lectura_actual = $_POST['lectura_actual'];

    // Actualizar la información del medidor
    $sql = "UPDATE lecturas_agua SET fecha_lectura='$fecha_lectura', lectura_anterior='$lectura_anterior', lectura_actual='$lectura_actual' WHERE lectura_id='$lectura_id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: registro_medidor.php?status=updated");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $lectura_id = $_GET['id'];
    $sql = "SELECT * FROM lecturas_agua WHERE lectura_id='$lectura_id'";
    $result = $conn->query($sql);
    $medidor = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar lecturas</title>
</head>
<body>
    <h1>Editar lecturas</h1>
    <form method="POST" action="editar_medidor.php">
        <input type="hidden" name="lectura_id" value="<?php echo $medidor['lectura_id']; ?>">
        Fecha de lectura: <input type="date" name="fecha_lectura" value="<?php echo $medidor['fecha_lectura']; ?>" required><br>
        Lectura Anterior: <input type="number" name="lectura_anterior" value="<?php echo $medidor['lectura_anterior']; ?>" required><br>
        Lectura Actual: <input type="number" name="lectura_actual" value="<?php echo $medidor['lectura_actual']; ?>" required><br>
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
            background-image: url('../img/azul.jpg');
            background-size: cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding-top: 50px;
        }

        h1 {
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
        input[type="date"],
        input[type="number"] {
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
            background-color: rgb(181, 195, 233);
            transform: scale(1.2);
        }
    </style>
</body>
</html>
