<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'water_db');
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener las tarifas actuales
$sql_tarifas = "SELECT * FROM tarifas ORDER BY tarifa_id DESC LIMIT 1";
$resultado_tarifas = $conn->query($sql_tarifas);
$tarifa_actual = $resultado_tarifas->fetch_assoc();

// Verificación de que se haya encontrado una tarifa actual
if (!$tarifa_actual) {
    die("No se encontraron tarifas actuales.");
}

// Consulta para obtener la lista de socios con lecturas registradas y el monto a pagar
$sql = "SELECT s.ci_socio, s.apellidos, s.nombre, 
               l.lectura_anterior, l.lectura_actual, 
               (l.lectura_actual - l.lectura_anterior) AS consumo_agua,
               (CASE 
                    WHEN (l.lectura_actual - l.lectura_anterior) BETWEEN {$tarifa_actual['rango_estandar_min']} AND {$tarifa_actual['rango_estandar_max']} THEN {$tarifa_actual['precio_m3_estandar']}
                    WHEN (l.lectura_actual - l.lectura_anterior) BETWEEN {$tarifa_actual['rango_medio_min']} AND {$tarifa_actual['rango_medio_max']} THEN {$tarifa_actual['precio_m3_medio']}
                    ELSE {$tarifa_actual['precio_m3_elevado']}
                END) * (l.lectura_actual - l.lectura_anterior) AS monto_pagar
        FROM socios s
        INNER JOIN lecturas_agua l ON s.numero_medidor = l.numero_medidor";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Lista de Deudores</title>
</head>

<body>
    <div class="wrapper">
        <nav class="sidebar">
            <div class="logo">Menú Lateral</div>
            <div class="profile">
                <img src="../img/logo.jpeg">
                <h3>Sistema de Socios</h3>
                <p>Agua Potable</p>
            </div>
            <ul>
                <li><a href="../html/inicio.html">Inicio</a></li>
                <li><a href="../php/socios.php">Registrar Socio</a></li>
                <li><a href="../html/factura.html">Comprobante</a></li>
                <li><a href="../php/registro_cobro.php">Extras</a></li>
                <li><a href="../php/registro_medidor.php">Lecturas</a></li>
                <li><a href="../php/registro_deuda1.php">deudores</a></li>
                <li><a href="../php/registro_tarifas.php">Tarifas</a></li>
            </ul>
        </nav>
    </div>

    <div class="content">
        <div class="users-form">
            <h1>Lista de Deudores</h1>
        </div>

        <div class="users-table">
            <form class="for1" action="" method="POST">
                <input type="text" name="search" placeholder="Buscar por nombre o carnet">
                <button type="submit">Buscar</button>
            </form>
            <table border="1">
                <thead>
                    <tr>
                        <th>CI Socio</th>
                        <th>Apellidos</th>
                        <th>Nombre</th>
                        <th>Lectura Anterior (m3)</th>
                        <th>Lectura Actual (m3)</th>
                        <th>Consumo de Agua (m3)</th>
                        <th>Monto a Pagar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Obtener la fecha actual para el campo fecha_ultimo_aviso
                    $fecha_actual = date('Y-m-d');

                    // Iterar sobre los resultados y mostrar los datos
                    while ($row = $resultado->fetch_assoc()) {
                        // Verificar si el registro ya existe en la tabla deudores
                        $ci_socio = $row['ci_socio'];
                        $sql_check = "SELECT * FROM deudores WHERE ci_socio = '$ci_socio'";
                        $resultado_check = $conn->query($sql_check);

                        if ($resultado_check->num_rows == 0) {
                            // Si no existe, insertar el registro en la tabla deudores
                            $sql_insert = "INSERT INTO deudores (ci_socio, fecha_ultimo_aviso, monto_adeudado) VALUES ('$ci_socio', '$fecha_actual', '{$row['monto_pagar']}')";
                            $conn->query($sql_insert);
                        }

                        echo "<tr>";
                        echo "<td>{$row['ci_socio']}</td>";
                        echo "<td>{$row['apellidos']}</td>";
                        echo "<td>{$row['nombre']}</td>";
                        echo "<td>{$row['lectura_anterior']}</td>";
                        echo "<td>{$row['lectura_actual']}</td>";
                        echo "<td>{$row['consumo_agua']}</td>";
                        echo "<td>{$row['monto_pagar']}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>



    <style>
          @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
*{
    margin: 0;
    padding: 0;
    font-family: 'poppins',sans-serif;
}

        body {
            margin: 0;
            padding: 0;
            color: #fff;
            min-height: 200vh;
            background-image: url(../img/cool2.jpg);
            background-size: cover;
            display: flex;
        }

        .wrapper {
            display: flex;
            width: 100%;
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
        .content {
            margin-left: 270px;
            padding: 20px;
            width: calc(100% - 270px);
        }

        .users-form {
            text-align: center;
        }

        .users-form h1 {
            position: relative;
            top: 20px;
        }

        .users-table .for1 {
            position: relative;
            margin: 10px auto;
            text-align: right;
            width: 50%;
        }

        .users-table .for1 input[type="text"] {
            width: auto;
            display: inline-block;
        }

        .users-table .for1 button[type="submit"] {
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: 0.5s;
        }

        .users-table .for1 button[type="submit"]:hover {
            background-color: #111;
            transform: scale(1.2);
        }

        table {
            width: 1000px;
            margin-top: 60px;
            color: #fff;
            font-size: 14px;
            position: relative;
            right: 100px;
           
            background-color: transparent;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            background-color: transparent;
        }

        th {
            background-color: rgba(0, 0, 0, 0.5);
        }

        td {
            background-color: rgba(0, 0, 0, 0.3);
        }

        /* Estilos mejorados para los botones oscuros */
        button[type="submit"],
        .users-table--edit,
        .users-table--delete {
            background-color: black;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s, transform 0.3s;
        }

        button[type="submit"]:hover,
        .users-table--edit:hover,
        .users-table--delete:hover {
            background-color: #222;
            transform: translateY(-2px);
        }
    </style>
</body>

</html>
