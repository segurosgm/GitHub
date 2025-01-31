<?php
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$basedatos = "gmk";

// Crear conexión
$conn = new mysqli($servidor, $usuario, $contraseña, $basedatos);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del departamento desde el parámetro de la URL
if (isset($_GET['departamento_id'])) {
    $departamento_id = $_GET['departamento_id'];

    // Obtener las ciudades del departamento seleccionado
    $sql = "SELECT Id_ciudad, Nombre FROM ciudad WHERE Id_Departamento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $departamento_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $ciudades = [];
    while ($row = $result->fetch_assoc()) {
        $ciudades[] = $row;
    }

    // Devolver las ciudades en formato JSON
    echo json_encode($ciudades);
}

$conn->close();
?>
