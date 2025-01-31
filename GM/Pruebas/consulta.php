<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "gmk");


if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$usuario = null;
$error = null;

// Buscar usuario por cédula
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];

    // Consulta SQL para buscar usuario
    $query = "SELECT * FROM usuarios WHERE numero_identidad = $cedula";
    $stmt = $conexion->prepare($query);
    
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
    } else {
        $error = "No se encontraron resultados para la cédula ingresada.";
    }

    $stmt->close();
}

// Guardar cambios si el formulario de edición es enviado
if (isset($_POST['guardar_cambios'])) {
    $numero_identidad = $_POST['numero_identidad'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    

    // Consulta SQL para actualizar los datos
    $query = "UPDATE usuarios SET nombre = ?, apellidos = ?, correo = ?, telefono = ? WHERE numero_identidad = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sssssss", $nombre, $apellidos, $correo, $telefono,  $numero_identidad);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Datos actualizados correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar los datos: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

$conexion->close();
?>