<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "GMK"; // Aquí deberías colocar el nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombreAseguradora = $_POST['nombreAseguradora'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $numeroIdentidad = $_POST['numeroIdentidad'];
    $poliza = $_POST['Numero_Poliza'];
   
    $fechaVencimiento = $_POST['fechaVencimiento'];
    $tipoPoliza = $_POST['tipoPoliza'];
    $tipoVehiculo = $_POST['tipoVehiculo'];
    $placa = $_POST['placa'];
    $marca = $_POST['marca'];

    // Verificar si el usuario ya existe en la tabla usuario
    $sql = "SELECT * FROM usuarios WHERE Numero_Identidad = '$numeroIdentidad'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Si el usuario ya existe, solo agregar la información a las otras tablas
        
        // Insertar en la tabla vehiculo
        $sqlVehiculo = "INSERT INTO vehiculo (Placa, TipoVehiculo, Marca) 
                        VALUES ('$placa', '$tipoVehiculo', '$marca')";
        $conn->query($sqlVehiculo);
        
        // Obtener el Id del Vehículo insertado
        $idVehiculo = $conn->insert_id;

        // Insertar en la tabla poliza
        $sqlPoliza = "INSERT INTO poliza (Numero_Poliza, Id_tipoPoliza, Id_Aseguradora, Fecha_Inicio, Fecha_Final) 
                      VALUES ('$poliza', '$tipoPoliza', '$nombreAseguradora', NOW(), '$fechaVencimiento')";
        $conn->query($sqlPoliza);
        
        // Obtener el Id de la Póliza insertada
        $idPoliza = $conn->insert_id;

        // Insertar en la tabla segurovehiculo
        $sqlSeguroVehiculo = "INSERT INTO segurovehiculo (Id_Aseguradora, Id_Vehiculo, Id_Poliza, Estado) 
                              VALUES ('$nombreAseguradora', '$idVehiculo', '$idPoliza', 'Activo')";
        $conn->query($sqlSeguroVehiculo);
        
    } else {
        // Si el usuario no existe, insertar en la tabla usuario y las demás tablas

        // Insertar en la tabla usuario
        $sqlUsuario = "INSERT INTO usuario (Numero_Identidad, Nombre, Apellidos, Tipo_Documento) 
                       VALUES ('$numeroIdentidad', '$nombre', '$apellidos', '$tipoDocumento')";
        $conn->query($sqlUsuario);

        // Obtener el Id del Usuario insertado
        $idUsuario = $conn->insert_id;

        // Insertar en la tabla vehiculo
        $sqlVehiculo = "INSERT INTO vehiculo (Placa, TipoVehiculo, Marca) 
                        VALUES ('$placa', '$tipoVehiculo', '$marca')";
        $conn->query($sqlVehiculo);

        // Obtener el Id del Vehículo insertado
        $idVehiculo = $conn->insert_id;

        // Insertar en la tabla poliza
        $sqlPoliza = "INSERT INTO poliza (Numero_Poliza, Id_tipoPoliza, Id_Aseguradora, Fecha_Inicio, Fecha_Final) 
                      VALUES ('$poliza', '$tipoPoliza', '$nombreAseguradora', NOW(), '$fechaVencimiento')";
        $conn->query($sqlPoliza);

        // Obtener el Id de la Póliza insertada
        $idPoliza = $conn->insert_id;

        // Insertar en la tabla segurovida
        $sqlSeguroVida = "INSERT INTO segurovida (Id_Aseguradora, Id_Usuario, Id_Poliza, Estado) 
                          VALUES ('$nombreAseguradora', '$idUsuario', '$idPoliza', 'Activo')";
        $conn->query($sqlSeguroVida);

        // Insertar en la tabla segurovehiculo
        $sqlSeguroVehiculo = "INSERT INTO segurovehiculo (Id_Aseguradora, Id_Vehiculo, Id_Poliza, Estado) 
                              VALUES ('$nombreAseguradora', '$idVehiculo', '$idPoliza', 'Activo')";
        $conn->query($sqlSeguroVehiculo);
    }

    // Mensaje de éxito
    echo "Datos ingresados correctamente.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Aseguradora</title>
</head>
<body>
    <h2>Formulario de Seguro</h2>
    <form method="POST">
        <label for="nombreAseguradora">Nombre de la Aseguradora:</label>
        <input type="text" name="nombreAseguradora" required><br>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" required><br>

        <label for="tipoDocumento">Tipo de Documento:</label>
        <input type="text" name="tipoDocumento" required><br>

        <label for="numeroIdentidad">Número de Identidad:</label>
        <input type="text" name="numeroIdentidad" required><br>

        <label for="poliza">Número de Póliza:</label>
        <input type="text" name="Numero_Poliza" required><br>

        <label for="fechaVencimiento">Fecha de Vencimiento:</label>
        <input type="date" name="fechaVencimiento" required><br>

        <label for="tipoPoliza">Tipo de Póliza:</label>
        <input type="text" name="tipoPoliza" required><br>

        <label for="tipoVehiculo">Tipo de Vehículo:</label>
        <input type="text" name="tipoVehiculo" required><br>

        <label for="placa">Placa del Vehículo:</label>
        <input type="text" name="placa" required><br>

        <label for="marca">Marca del Vehículo:</label>
        <input type="text" name="marca" required><br>

        <input type="submit" value="Registrar Seguro">
    </form>
</body>
</html>
