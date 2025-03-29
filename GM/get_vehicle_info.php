<?php
header('Content-Type: application/json');
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "GMK"; // Nombre de la base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$userId = $_POST['ID'];

$sql = "SELECT * FROM poliza WHERE 	Id_Usuario = $userId";
$result = $conn->query($sql);

$vehicles = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $vehicles[] = $row;
    }
}

echo json_encode($vehicles);

$conn->close();
?>