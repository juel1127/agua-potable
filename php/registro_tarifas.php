<?php
session_start();

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'water_db');
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener las tarifas actuales
$sql_tarifas = "SELECT * FROM tarifas ORDER BY tarifa_id DESC LIMIT 1";
$resultado_tarifas = $conn->query($sql_tarifas);
$tarifa_actual = $resultado_tarifas->fetch_assoc();

// Si no se encuentra una tarifa actual, inicializar con valores por defecto
if (!$tarifa_actual) {
    $tarifa_actual = [
        'descripcion' => '',
        'precio_m3_estandar' => 0,
        'precio_m3_medio' => 0,
        'precio_m3_elevado' => 0,
        'rango_estandar_min' => 0,
        'rango_estandar_max' => 10,
        'rango_medio_min' => 11,
        'rango_medio_max' => 20,
        'rango_elevado_min' => 21,
        'rango_elevado_max' => 9999
    ];
} else {
    // Asegurar que todos los campos están inicializados
    $tarifa_actual = array_merge([
        'descripcion' => '',
        'precio_m3_estandar' => 0,
        'precio_m3_medio' => 0,
        'precio_m3_elevado' => 0,
        'rango_estandar_min' => 0,
        'rango_estandar_max' => 10,
        'rango_medio_min' => 11,
        'rango_medio_max' => 20,
        'rango_elevado_min' => 21,
        'rango_elevado_max' => 9999
    ], $tarifa_actual);
}

// Si el formulario se envía, actualiza las tarifas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descripcion = $_POST['descripcion'];
    $precio_m3_estandar = $_POST['precio_m3_estandar'];
    $precio_m3_medio = $_POST['precio_m3_medio'];
    $precio_m3_elevado = $_POST['precio_m3_elevado'];

    $rango_estandar_min = $_POST['rango_estandar_min'];
    $rango_estandar_max = $_POST['rango_estandar_max'];
    $rango_medio_min = $_POST['rango_medio_min'];
    $rango_medio_max = $_POST['rango_medio_max'];
    $rango_elevado_min = $_POST['rango_elevado_min'];
    $rango_elevado_max = $_POST['rango_elevado_max'];
    
    // Verificar si hay tarifas existentes
    if (isset($tarifa_actual['tarifa_id'])) {
        // Actualizar la tarifa existente
        $sql_update = "UPDATE tarifas SET 
                       descripcion='$descripcion', 
                       precio_m3_estandar='$precio_m3_estandar', 
                       precio_m3_medio='$precio_m3_medio', 
                       precio_m3_elevado='$precio_m3_elevado',
                       rango_estandar_min='$rango_estandar_min',
                       rango_estandar_max='$rango_estandar_max',
                       rango_medio_min='$rango_medio_min',
                       rango_medio_max='$rango_medio_max',
                       rango_elevado_min='$rango_elevado_min',
                       rango_elevado_max='$rango_elevado_max'
                       WHERE tarifa_id=" . $tarifa_actual['tarifa_id'];
        if ($conn->query($sql_update) === TRUE) {
            echo "<p>Tarifas actualizadas correctamente.</p>";
        } else {
            echo "Error: " . $sql_update . "<br>" . $conn->error;
        }
    } else {
        // Insertar una nueva tarifa si no existe
        $sql_insert = "INSERT INTO tarifas (descripcion, precio_m3_estandar, precio_m3_medio, precio_m3_elevado, 
                                             rango_estandar_min, rango_estandar_max, 
                                             rango_medio_min, rango_medio_max, 
                                             rango_elevado_min, rango_elevado_max) 
                       VALUES ('$descripcion', '$precio_m3_estandar', '$precio_m3_medio', '$precio_m3_elevado', 
                               '$rango_estandar_min', '$rango_estandar_max', 
                               '$rango_medio_min', '$rango_medio_max', 
                               '$rango_elevado_min', '$rango_elevado_max')";
        if ($conn->query($sql_insert) === TRUE) {
            echo "<p>Tarifas registradas correctamente.</p>";
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    }
    
    // Actualizar las tarifas actuales después de la actualización
    $tarifa_actual['descripcion'] = $descripcion;
    $tarifa_actual['precio_m3_estandar'] = $precio_m3_estandar;
    $tarifa_actual['precio_m3_medio'] = $precio_m3_medio;
    $tarifa_actual['precio_m3_elevado'] = $precio_m3_elevado;
    $tarifa_actual['rango_estandar_min'] = $rango_estandar_min;
    $tarifa_actual['rango_estandar_max'] = $rango_estandar_max;
    $tarifa_actual['rango_medio_min'] = $rango_medio_min;
    $tarifa_actual['rango_medio_max'] = $rango_medio_max;
    $tarifa_actual['rango_elevado_min'] = $rango_elevado_min;
    $tarifa_actual['rango_elevado_max'] = $rango_elevado_max;
    
    $_SESSION['tarifa_actual'] = $tarifa_actual;
}

// Si existe una sesión para la tarifa actual, utiliza esos valores
if (isset($_SESSION['tarifa_actual'])) {
    $tarifa_actual = $_SESSION['tarifa_actual'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Tarifas</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }
        .blow {
            position: relative;
            margin-left: 450px;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
            min-height: 160vh;
            background-image: url('../img/cool2.jpg');
            background-size: cover;
            display: flex;
            flex-direction: column;
        }
        .wrapper {
            display: flex;
            height: 150vh;
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
        .main-content {
            flex-grow: 1;
            padding: 20px;
            position: relative;
            margin-left: 250px; /* Added to ensure content is not overlapped by sidebar */
            top: 20px;
        }
        form {
            background: rgba(255, 255, 255, 0.8);
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #333;
            max-width: 600px;
            margin: auto;
        }
        form label {
            display: block;
            margin-bottom: 5px;
        }
        form input[type="text"],
        form input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        form input[type="submit"] {
            background: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            transition: background 0.3s;
        }
        form input[type="submit"]:hover {
            background: #575757;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <nav class="sidebar">
        <div class="logo">Menú Lateral</div>
        <div class="profile">
            <img src="../img/logo.jpeg" alt="Logo">
            <h3>Sistema de Socios</h3>
            <p>Agua Potable</p>
        </div>
        <ul>
            <li><a href="../html/inicio.html">Inicio</a></li>
            <li><a href="../php/socios.php">Registrar Socio</a></li>
            <li><a href="../html/factura.html">Comprobante</a></li>
            <li><a href="registro_cobro.php">Extras</a></li>
            <li><a href="registro_medidor.php">Lecturas</a></li>
            <li><a href="registro_deuda1.php">Deudores</a></li>
            <li><a href="registro_tarifas.php">Tarifas</a></li>
        </ul>
    </nav>
    <div class="main-content">
        <h1 class="blow">Registro de Tarifas</h1>
        <form method="POST" action="registro_tarifas.php">
            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" value="<?php echo $tarifa_actual['descripcion']; ?>" required>
            <label for="precio_m3_estandar">Precio m3 estándar:</label>
            <input type="number" id="precio_m3_estandar" name="precio_m3_estandar" value="<?php echo $tarifa_actual['precio_m3_estandar']; ?>" required>
            <label for="precio_m3_medio">Precio m3 medio:</label>
            <input type="number" id="precio_m3_medio" name="precio_m3_medio" value="<?php echo $tarifa_actual['precio_m3_medio']; ?>" required>
            <label for="precio_m3_elevado">Precio m3 elevado:</label>
            <input type="number" id="precio_m3_elevado" name="precio_m3_elevado" value="<?php echo $tarifa_actual['precio_m3_elevado']; ?>" required>
            <label for="rango_estandar_min">Rango estándar mínimo:</label>
            <input type="number" id="rango_estandar_min" name="rango_estandar_min" value="<?php echo $tarifa_actual['rango_estandar_min']; ?>" required>
            <label for="rango_estandar_max">Rango estándar máximo:</label>
            <input type="number" id="rango_estandar_max" name="rango_estandar_max" value="<?php echo $tarifa_actual['rango_estandar_max']; ?>" required>
            <label for="rango_medio_min">Rango medio mínimo:</label>
            <input type="number" id="rango_medio_min" name="rango_medio_min" value="<?php echo $tarifa_actual['rango_medio_min']; ?>" required>
            <label for="rango_medio_max">Rango medio máximo:</label>
            <input type="number" id="rango_medio_max" name="rango_medio_max" value="<?php echo $tarifa_actual['rango_medio_max']; ?>" required>
            <label for="rango_elevado_min">Rango elevado mínimo:</label>
            <input type="number" id="rango_elevado_min" name="rango_elevado_min" value="<?php echo $tarifa_actual['rango_elevado_min']; ?>" required>
            <label for="rango_elevado_max">Rango elevado máximo:</label>
            <input type="number" id="rango_elevado_max" name="rango_elevado_max" value="<?php echo $tarifa_actual['rango_elevado_max']; ?>" required>
            <input type="submit" value="Guardar">
        </form>
    </div>
</div>
</body>
</html>
