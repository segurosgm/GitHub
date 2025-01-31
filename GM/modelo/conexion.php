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

?>   
