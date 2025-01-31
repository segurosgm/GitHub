<?php

//  conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gmk";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
    
}

   // Consultar las aseguradoras
   $sql = "SELECT * FROM aseguradoras";
   $result = $conn->query($sql);

   // Llenar la lista desplegable con las aseguradoras
   if ($result->num_rows > 0) {
       while ($row = $result->fetch_assoc()) {
           echo "<option value='" . $row['Id_Aseguradora'] . "'>" . $row['Nombre_Aseguradora'] . "</option>";
       }
   } else {
       echo "<option value=''>No hay aseguradoras disponibles</option>";
   }

   // Cerrar la conexión
   $conn->close();




// Verificar si la aseguradora existe

$sqlAseguradora = "SELECT Id_Aseguradora FROM aseguradoras WHERE Nombre_Aseguradora = '$nombreAseguradora'";
$resultAseguradora = $conn->query( $sqlAseguradora);

// Si no se encuentra la aseguradora, finalizar y mostrar mensaje de error
if ($resultAseguradora->num_rows > 0) {
    $aseguradora = $resultAseguradora->fetch_assoc();
    $idAseguradora = $aseguradora['Id_Aseguradora'];
} else {
    die("La aseguradora '$nombreAseguradora' no existe en la base de datos.");
}


