
<?php
// Incluye la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gmk";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreAseguradora = $_POST['nom_Aseguradora'];
    $tipoSeguro = $_POST['tipo_seguro'];
    $numPoliza = $_POST['num_poliza'];
    $fechaVencimiento = $_POST['fecha_vencimiento'];
    $placa = $_POST['placa'];
    $tipoVehiculo = $_POST['tipo_Vehiculo'];
    $marca = $_POST['marca'];

    // Verificar si la aseguradora existe
    $sqlAseguradora = "SELECT Id_Aseguradora FROM Aseguradoras WHERE Nombre_Aseguradora = '$nombreAseguradora'";
    $resultAseguradora = $conn->query($sqlAseguradora);

    if ($resultAseguradora->num_rows > 0) {
        $aseguradora = $resultAseguradora->fetch_assoc();
        $idAseguradora = $aseguradora['Id_Aseguradora'];

        // Insertar en la tabla Poliza
        $sqlPoliza = "INSERT INTO Poliza (Numero_Poliza, Id_tipoPoliza, Id_Aseguradora, Fecha_Inicio, Fecha_Final, Descripcion)
                      VALUES ('$numPoliza', 1, '$idAseguradora', CURDATE(), '$fechaVencimiento', 'Seguro registrado')";
        if ($conn->query($sqlPoliza) === TRUE) {
            $idPoliza = $conn->insert_id;  // Obtener el ID de la póliza recién insertada

            // Dependiendo del tipo de seguro, insertar en la tabla correspondiente
            if ($tipoSeguro == 'Vida') {
                // Insertar en SeguroVida
                $sqlSeguroVida = "INSERT INTO SeguroVida (Id_Aseguradora, Id_Usuario, Id_Poliza, Estado)
                                  VALUES ('$idAseguradora', 1, '$idPoliza', 'Activo')";
                $conn->query($sqlSeguroVida);
            } else {
                // Insertar en Vehiculo y SeguroVehiculo
                $sqlVehiculo = "INSERT INTO Vehiculo (Placa, TipoVehiculo, Marca, Descripcion)
                                VALUES ('$placa', '$tipoVehiculo' '$marca', 'Descripción del vehículo')";
                if ($conn->query($sqlVehiculo) === TRUE) {
                    $idVehiculo = $conn->insert_id;

                    // Insertar en SeguroVehiculo
                    $sqlSeguroVehiculo = "INSERT INTO SeguroVehiculo (Id_Aseguradora, Id_Vehiculo, Id_Poliza, Estado)
                                          VALUES ('$idAseguradora', '$idVehiculo', '$idPoliza', 'Activo')";
                    $conn->query($sqlSeguroVehiculo);
                }
            }
        } else {
            die("Error al insertar la póliza: " . $conn->error);
        }
    } else {
        die("La aseguradora no existe.");
    }
}
?>
