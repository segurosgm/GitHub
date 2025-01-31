<?php
// Conexión a la base de datos
include('conexion.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_identidad = $_POST['numero_identidad'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $departamento = $_POST['departamento'];
    $ciudad = $_POST['ciudad'];

    // Consulta para actualizar los datos
    $query = "UPDATE usuarios SET nombre = ?, apellidos = ?, correo = ?, telefono = ?, departamento_id = ?, ciudad_id = ? WHERE numero_identidad = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sssssss", $nombre, $apellidos, $correo, $telefono, $departamento, $ciudad, $numero_identidad);

    if ($stmt->execute()) {
        echo "Datos actualizados correctamente.";
    } else {
        echo "Error al actualizar los datos: " . $stmt->error;
    }

    $stmt->close();
}
$conexion->close();
?>
