<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gmk";

// Crear conexión
$conn = new mysqli(hostname: $servername, username: $username, password: $password, database: $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$usuario = null;
$error = null;
// Buscar usuario por cédula
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Numero_Identidad'])) {
    $cedula = $_POST['Numero_Identidad'];

    // Consulta SQL para buscar usuario
    $query = "SELECT * FROM usuarios WHERE Numero_Identidad = $cedula";
    $stmt = $conn->prepare($query);

    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
    } else {
        $error = "No se encontraron resultados para la cédula ingresada.";
    }

    $stmt->close();
}


    $conn->close();

?>
