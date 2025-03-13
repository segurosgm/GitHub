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
    $nombreAseguradora = $_POST['Nombre_Aseguradora'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $tipoDocumento = $_POST['tipo_documento'];
    $numeroIdentidad = $_POST['numero_identidad'];
    $poliza = $_POST['num_poliza'];
    $fechaVencimiento = $_POST['fecha_vencimiento'];  
    $tipoPoliza = $_POST['tipoPoliza'];
    $tipoVehiculo = isset($_POST['tipoVehiculo']) ? $_POST['tipoVehiculo'] : null;
    $placa = isset($_POST['placa']) ? $_POST['placa'] : null;
    $marca = isset($_POST['marca']) ? $_POST['marca'] : null;

    // Verificar la aseguradora 
    $stmt = $conn->prepare("SELECT Id_Aseguradora FROM aseguradoras WHERE Nombre_Aseguradora = ?");
    $stmt->bind_param("s", $nombreAseguradora);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $rowAseguradora = $result->fetch_assoc();
        $idAseguradora = $rowAseguradora['Id_Aseguradora'];
    }

    // Verificar la tiposeguro
    $stmt = $conn->prepare("SELECT Id_tipoPoliza FROM tipopoliza WHERE NombrePoliza = ?");
    $stmt->bind_param("s", $tipoPoliza);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $rowTipoPoliza = $result->fetch_assoc();
        $idtipoPoliza = $rowTipoPoliza['Id_tipoPoliza'];
    }

    // Verificar si el usuario ya existe en la tabla usuario
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE Numero_Identidad = ?");
    $stmt->bind_param("s", $numeroIdentidad);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si el usuario ya existe, solo agregar la información a las otras tablas
        
        // Insertar en la tabla vehiculo
        $stmt = $conn->prepare("INSERT INTO vehiculo (Placa, TipoVehiculo, Marca) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $placa, $tipoVehiculo, $marca);
        $stmt->execute();
        $idVehiculo = $stmt->insert_id;

        // Insertar en la tabla poliza
        $stmt = $conn->prepare("INSERT INTO poliza (Numero_Poliza, Id_Aseguradora, Id_tipoPoliza, Fecha_Inicio, Fecha_Final) VALUES (?, ?, ?, NOW(), ?)");
        $stmt->bind_param("siis", $poliza, $idAseguradora, $idtipoPoliza, $fechaVencimiento);
        $stmt->execute();
        $idPoliza = $stmt->insert_id;

        // Insertar en la tabla segurovehiculo
        $stmt = $conn->prepare("INSERT INTO segurovehiculo (Id_Aseguradora, Id_Vehiculo, Id_Poliza, Estado) VALUES (?, ?, ?, 'Activo')");
        $stmt->bind_param("iii", $idAseguradora, $idVehiculo, $idPoliza);
        $stmt->execute();
        
    } else {
        // Si el usuario no existe, insertar en la tabla usuario y las demás tablas

        // Insertar en la tabla usuario
        $stmt = $conn->prepare("INSERT INTO usuario (Numero_Identidad, Nombre, Apellidos, Tipo_Documento) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $numeroIdentidad, $nombre, $apellidos, $tipoDocumento);
        $stmt->execute();
        $idUsuario = $stmt->insert_id;

        // Insertar en la tabla vehiculo
        $stmt = $conn->prepare("INSERT INTO vehiculo (Placa, TipoVehiculo, Marca) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $placa, $tipoVehiculo, $marca);
        $stmt->execute();
        $idVehiculo = $stmt->insert_id;

        // Insertar en la tabla poliza
        $stmt = $conn->prepare("INSERT INTO poliza (Numero_Poliza, Id_tipoPoliza, Id_Aseguradora, Fecha_Inicio, Fecha_Final) VALUES (?, ?, ?, NOW(), ?)");
        $stmt->bind_param("siis", $poliza, $idtipoPoliza, $idAseguradora, $fechaVencimiento);
        $stmt->execute();
        $idPoliza = $stmt->insert_id;

        // Insertar en la tabla segurovida
        $stmt = $conn->prepare("INSERT INTO segurovida (Id_Aseguradora, Id_Usuario, Id_Poliza, Estado) VALUES (?, ?, ?, 'Activo')");
        $stmt->bind_param("iii", $idAseguradora, $idUsuario, $idPoliza);
        $stmt->execute();

        // Insertar en la tabla segurovehiculo
        $stmt = $conn->prepare("INSERT INTO segurovehiculo (Id_Aseguradora, Id_Vehiculo, Id_Poliza, Estado) VALUES (?, ?, ?, 'Activo')");
        $stmt->bind_param("iii", $idAseguradora, $idVehiculo, $idPoliza);
        $stmt->execute();
    }

    // Mensaje de éxito
    echo "Datos ingresados correctamente.";
}

$conn->close();
?>