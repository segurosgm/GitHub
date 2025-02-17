<?php
// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "gmk");

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
num_poliza: null;
fecha_vencimiento: null;
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

// Comprobar si los campos requeridos están vacíos
if (empty($nombreAseguradora) || empty($nombre) || empty($apellidos) || empty($tipoDocumento) || empty($numeroIdentidad) || empty($poliza) || empty($fechaVencimiento)) {
    echo "Por favor complete todos los campos obligatorios.";
    exit();
}


if(tipoPoliza=="Transporte")

// Insertar los datos en la base de datos
$sql = "INSERT INTO segurovehiculo  (Nombre_Aseguradora, Nombre, Apellidos, Tipo_Documento, Numero_Identidad, Numero_Poliza, Fecha_Vencimiento, Tipo_Poliza)
        VALUES ('$nombreAseguradora', '$nombre', '$apellidos', '$tipoDocumento', '$numeroIdentidad', '$poliza', '$fechaVencimiento', '$tipoPoliza')";
        "INSERT INTO vehiculo ( Placa, Tipo_Vehiculo,  Marca) VALUES (  '$tipoVehiculo', '$placa', '$marca')";
    "INSERT INTO usuario
// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    echo "Datos registrados correctamente.";
} else {
    echo "Error al registrar los datos: " . $conn->error;
}




// Cerrar la conexión
$conn->close();
?>
