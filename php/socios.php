<?php
include("connection.php");
$con = connection();

$sql = "SELECT * FROM socios";
$query = mysqli_query($con, $sql);
?>
<!DOCTYPE html> 
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Usuarios</title>
    
</head>
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

<body>
    <div class="users-form">
        <h1>Socios de Agua Potable</h1>
        <form action="insert_user.php" method="POST">
            <input type="number" id="ci_socio" name="ci_socio" placeholder="Carnet" required>
            <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" required>
            <input type="text" id="nombre" name="nombre" placeholder="Nombres" required>
            <input type="text" id="direccion" name="direccion" placeholder="Direccion" required>
            <input type="number" id="telefono" name="telefono" placeholder="Telefono" required>
            <input type="text" id="numero_medidor" name="numero_medidor" placeholder="Número de Medidor" required> <!-- Agregamos el campo para el número de medidor -->
            <input type="date" id="fecha_alta" name="fecha_alta" placeholder="Fecha alta" required>
            <button type="submit" value="agregar">Agregar Cliente</button>
        </form>
    </div>

    <div class="users-table">
        <h2>Registro de Socios</h2>
        <form class="for1" action="" method="POST">
            <input type="text" name="search" placeholder="Buscar por nombre o carnet">
            <button type="submit">Buscar</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Carnet</th>
                    <th>Apellidos</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Número de Medidor</th> <!-- Agregamos la columna para mostrar el número de medidor -->
                    <th>Teléfono</th>
                    <th>Fecha Alta</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (isset($_POST['search'])) {
                    $search = $_POST['search'];
                    $sql_search = "SELECT * FROM socios WHERE nombre LIKE '%$search%' OR ci_socio LIKE '%$search%'";
                    $query_search = mysqli_query($con, $sql_search);
                    while ($row_search = mysqli_fetch_array($query_search)): ?>
                        <tr class="highlight">
                            <td><?= $row_search['id_socio'] ?></td>
                            <td><?= $row_search['ci_socio'] ?></td>
                            <td><?= $row_search['apellidos'] ?></td>
                            <td><?= $row_search['nombre'] ?></td>
                            <td><?= $row_search['direccion'] ?></td>
                            <td><?= $row_search['numero_medidor'] ?></td> <!-- Mostramos el número de medidor -->
                            <td><?= $row_search['telefono'] ?></td>
                            <td><?= $row_search['fecha_alta'] ?></td>
                            <td><a href="update.php?id_socio=<?= $row_search['id_socio'] ?>" class="users-table--edit">Editar</a></td>
                            <td><a href="delete_user.php?id_socio=<?= $row_search['id_socio'] ?>" class="users-table--delete">Eliminar</a></td>
                        </tr>
                    <?php endwhile;
                } else {
                    while ($row = mysqli_fetch_array($query)): ?>
                        <tr>
                            <td><?= $row['id_socio'] ?></td>
                            <td><?= $row['ci_socio'] ?></td>
                            <td><?= $row['apellidos'] ?></td>
                            <td><?= $row['nombre'] ?></td>
                            <td><?= $row['direccion'] ?></td>
                            <td><?= $row['numero_medidor'] ?></td> <!-- Mostramos el número de medidor -->
                            <td><?= $row['telefono'] ?></td>
                            <td><?= $row['fecha_alta'] ?></td>
                            <td><a href="update.php?id_socio=<?= $row['id_socio'] ?>" class="users-table--edit">Editar</a></td>
                            <td><a href="delete_user.php?id_socio=<?= $row['id_socio'] ?>" class="users-table--delete">Eliminar</a></td>
                        </tr>
                    <?php endwhile;
                }
                ?>
            </tbody>
        </table>
    </div>
    <style>
        /* Estilos del buscador */
        
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
*{
    margin: 0;
    padding: 0;
    font-family: 'poppins',sans-serif;
}
        .users-table .for1 {
            position: relative;
            top: 470px;
            left: 10px;
            margin: 10px;
            text-align: right;
            width: 50%;
        }
        h1{
            position: relative;
            top: 670px;
            left: 550px;
        }

        .users-table .for1 input[type="text"] {
            width: auto;
            display: inline-block;
            
        }

        .users-table .for1 button[type="submit"] {
            padding: 10px;
            background-color: #333; /* Cambio de color */
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            border-radius: 20px;
            transition: 0.5s;
           
        }

        .users-table .for1 button[type="submit"]:hover {
            background-color: #111; /* Cambio de color */
            transform: scale(1.2);
        }
        * {
            margin: 0;
            padding: 0;
            font-family: 'poppins', sans-serif;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
            min-height: 200vh;
            background-image: url(../img/cool2.jpg);
            background-size: cover;
            display: flex;
        }

        .uno {
            position: relative;
            margin: auto;
            color: white;
            top: 20px;
            left: 610px;
            border-bottom: solid 4px rgba(255, 255, 255, 0.2);
            text-align: center;
        }

        .class {
            position: relative;
            margin: auto;
            color: white;
            top: 60px;
            left: 600px;
            border-bottom: solid 4px rgba(255, 255, 255, 0.2);
            text-align: center;
        }

        form {
            background: #fff;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: transparent;
            color: white;
            text-align: center;
            position: relative;
            margin: auto;
            left: 500px;
            top: 40px;
        }
        h2{
            position: relative;
            left: 50px;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            color: white;
            border-radius: 3px;
            box-sizing: border-box;
            background-color: transparent;
            border-color: transparent;
            border-bottom: solid 1px rgba(255, 255, 255, 0.2);
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            color: white;
            border-radius: 3px;
            box-sizing: border-box;
            background-color: transparent;
            border-color: transparent;
            border-bottom: solid 1px rgba(255, 255, 255, 0.2);
            margin-bottom: 15px;
        }

        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            color: white;
            border-radius: 3px;
            box-sizing: border-box;
            background-color: transparent;
            border-color: transparent;
            border-bottom: solid 1px rgba(255, 255, 255, 0.2);
            margin-bottom: 15px;
            text-align: center;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: white;
            color: black;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            border-radius: 20px;
            transition: 0.5s;
            margin-top: 10px;
            position: relative;
            left: 20px;
        }

        button[type="submit"]:hover {
            background-color: rgb(181, 195, 233);
            transform: scale(1.2);
        }

        table {
            width: 78%;
            margin-top: 10px;
            position: absolute;
            margin: auto;
            color: #fff;
            font-size: 14px;
            border-collapse: collapse;
            top: 750px;
            left: 260px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            background-color: transparent;
            position: relative;
        }

        .error {
            color: red;
        }
       /* Estilos mejorados para los botones oscuros */
button[type="submit"],
.users-table--edit,
.users-table--delete {
    background-color: black; /* Color de fondo oscuro */
    color: #fff; /* Color del texto blanco */
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
    background-color: #222; /* Color de fondo más oscuro al pasar el ratón */
    transform: translateY(-2px); /* Efecto de elevación al pasar el ratón */
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

    </style>
</body>

</html>
