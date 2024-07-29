<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'water_db');

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$result_check_socio = null; // Definir $result_check_socio inicialmente como null

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numero_medidor = $_POST['numero_medidor'];
    $nombre = $_POST['nombre'];
    $fecha_lectura = $_POST['fecha_lectura'];
    $lectura_anterior = $_POST['lectura_anterior'];
    $lectura_actual = $_POST['lectura_actual'];

    // Verificar si el socio existe
    $sql_check_socio = "SELECT * FROM socios WHERE numero_medidor = '$numero_medidor'";
    $result_check_socio = $conn->query($sql_check_socio);

    if ($result_check_socio->num_rows > 0) {
        // Verificar el número de registros existentes para el usuario
        $sql_check_readings = "SELECT COUNT(*) as total FROM lecturas_agua WHERE numero_medidor = '$numero_medidor'";
        $result_check_readings = $conn->query($sql_check_readings);
        $row_check_readings = $result_check_readings->fetch_assoc();
        
        if ($row_check_readings['total'] < 12) {
            // Insertar nueva lectura
            $sql_insert_reading = "INSERT INTO lecturas_agua (numero_medidor, fecha_lectura, lectura_anterior, lectura_actual) 
                                   VALUES ('$numero_medidor', '$fecha_lectura', '$lectura_anterior', '$lectura_actual')";
            if ($conn->query($sql_insert_reading) === TRUE) {
                // Redirigir después de una inserción exitosa
                header("Location: registro_medidor.php?status=success");
                exit();
            } else {
                echo "Error: " . $sql_insert_reading . "<br>" . $conn->error;
            }
        } else {
            echo "Solo se puede añadir 12 veces al mismo usuario.";
        }
    } else {
        echo "El socio no existe en la base de datos.";
    }
}

// Mostrar datos actualizados
$sql = "SELECT s.numero_medidor, s.ci_socio, s.apellidos, s.nombre, l.lectura_id, l.fecha_lectura, l.lectura_anterior, l.lectura_actual
        FROM socios s
        JOIN lecturas_agua l ON s.numero_medidor = l.numero_medidor";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registro de lecturas</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<h1>Sistema de Lecturas</h1>
    <form method="POST" action="registro_medidor.php">
        Número de Medidor: <input type="number" name="numero_medidor" required><br>
        Nombre: <input type="text" name="nombre" required><br>
        Fecha de lectura: <input type="date" name="fecha_lectura" required><br>
        <?php if ($result_check_socio && $result_check_socio->num_rows > 0) { ?>
            Lectura anterior: <input type="number" name="lectura_anterior" value="" readonly><br>
        <?php } else { ?>
            Lectura anterior: <input type="number" name="lectura_anterior" required><br>
        <?php } ?>
        Lectura actual: <input type="number" name="lectura_actual" required><br>
        <input type="submit" value="Registrar">
    </form>

    <div class="wrapper">
        <nav class="sidebar">
            <div class="logo">Menú Lateral</div>
            <div class="profile">
                <img src="../img/logo.jpeg">
                <h3>Sistema de Medidor</h3>
                <p>Agua Potable</p>
            </div>
            <ul>
                <li><a href="../html/inicio.html">Inicio</a></li>
                <li><a href="../php/socios.php">Registrar Socio</a></li>
                <li><a href="../html/factura.html">Comprobante</a></li>
                <li><a href="../php/registro_cobro.php">Extras</a></li>
                <li><a href="../php/registro_medidor.php">Lecturas</a></li>
                <li><a href="../php/registro_deuda1.php">Deudores</a></li>
                <li><a href="../php/registro_tarifas.php">Tarifas</a></li>
            </ul>
        </nav>
    </div>

    <table border="1">
        <tr>
            <th>Número de Medidor</th>
            <th>Cédula de Identidad (CI)</th>
            <th>Apellidos</th>
            <th>Nombre</th>
            <th>Fecha de lectura</th>
            <th>Lectura anterior</th>
            <th>Lectura actual</th>
            <th>Acciones</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['numero_medidor']}</td>";
            echo "<td>{$row['ci_socio']}</td>";
            echo "<td>{$row['apellidos']}</td>";
            echo "<td>{$row['nombre']}</td>";
            echo "<td>{$row['fecha_lectura']}</td>";
            echo "<td>{$row['lectura_anterior']}</td>";
            echo "<td>{$row['lectura_actual']}</td>";
            echo "<td>
                <a href='editar_medidor.php?id={$row['lectura_id']}' class='btn btn-editar'>Editar</a> |
                <a href='eliminar_medidor.php?id={$row['lectura_id']}' class='btn btn-eliminar'>Eliminar</a>
                </td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
  
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
        *{
            margin: 0;
            padding: 0;
            font-family: 'poppins',sans-serif;
        }

        body {
            color: #fff;
            min-height: 200vh;
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

        h1 {
            top: 20px;
            left: 110px;
        }

        h2 {
            left: 130px;
            top: 50px;
        }

        .class {
            margin: 60px auto;
            color: white;
            border-bottom: solid 4px rgba(255, 255, 255, 0.2);
            text-align: center;
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

        table {
            width: 65%;
            margin: 20px 0;
            color: #fff;
            font-size: 14px;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            background-color: transparent;
        }

        .error {
            color: red;
        }

        .sidebar {
            width: 250px;
            background-color: #333;
            color: #fff;
            padding: 20px;
            position: fixed;
            height: 100%;
            overflow-y: auto;
        }

        .sidebar .logo, .sidebar .profile, .sidebar ul {
            margin-bottom: 20px;
        }

        .sidebar .profile img {
            width: 100%;
            border-radius: 50%;
        }

        .sidebar h3 {
            margin: 10px 0;
        }

        .sidebar p {
            margin: 5px 0;
            font-size: 0.9em;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #fff;
            padding: 10px 15px;
            display: block;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #575757;
        }

        .btn {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
            display: inline-block;
        }

        .btn-editar {
            background-color: #4CAF50; /* Verde */
            color: white;
        }

        .btn-editar:hover {
            background-color: #45a049;
            transform: scale(1.1);
        }

        .btn-eliminar {
            background-color: black; /* Rojo */
            color: white;
        }

        .btn-eliminar:hover {
            background-color: #da190b;
            transform: scale(1.1);
        }
    </style>
</body>
</html>
