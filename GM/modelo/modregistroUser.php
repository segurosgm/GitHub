<?php
// Conexión a la base de datos
include('conexion.php');

// Capturar los datos del formulario
$usuario = $_POST['usuario'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$tipo_documento = $_POST['tipo_documento'];
$numero_identidad = $_POST['numero_identidad'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$departamento = $_POST['departamento'];
$ciudad = $_POST['Ciudad'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
$tipo_perfil = $_POST['tipo_perfil'];

// Insertar los datos en la base de datos
$query = "INSERT INTO usuarios (usuario, nombre, apellidos, tipo_documento, numero_identidad, fecha_nacimiento, correo, telefono, departamento_id, ciudad_id, contrasena, tipo_perfil) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ssssssssssss", $usuario, $nombre, $apellidos, $tipo_documento, $numero_identidad, $fecha_nacimiento, $correo, $telefono, $departamento, $ciudad, $contrasena, $tipo_perfil);

if ($stmt->execute()) {
    echo "Registro exitoso.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
