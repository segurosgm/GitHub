<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "gmk");

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos del formulario
$nombreAseguradora = $_POST['Nombre_Aseguradora'];
$idAseguradora = $_POST ['Id_Aseguradora'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$tipoDocumento = $_POST['tipo_documento'];
$numeroIdentidad = $_POST['numero_identidad'];
$tipoSeguro = $_POST['tipo_seguro'];
$numeroPoliza = $_POST['num_poliza'];
$fechaVencimiento = $_POST['fecha_vencimiento'];

// Validación de la cédula en la tabla de usuario
$sqlCedula = "SELECT * FROM usuarios WHERE numero_identidad = '$numeroIdentidad' AND tipo_documento = '$tipoDocumento'";
$resultCedula = $conn->query($sqlCedula);

if ($resultCedula->num_rows == 0) {
    echo "La cédula no está registrada en la base de datos de usuarios.";
    exit();
}

// Obtener el ID del usuario para enlazar con los seguros
$rowCedula = $resultCedula->fetch_assoc();
$idUsuario = $rowCedula['id_usuario']; 

// Validación del tipo de póliza en la tabla tipopoliza
$sqlTipoPoliza = "SELECT * FROM tipopoliza WHERE tipo_poliza = '$tipoSeguro'";
$resultTipoPoliza = $conn->query($sqlTipoPoliza);

if ($resultTipoPoliza->num_rows == 0) {
    echo "El tipo de póliza no es válido.";
    exit();
}

// Obtener el ID del tipo de póliza
$rowTipoPoliza = $resultTipoPoliza->fetch_assoc();
$idTipoPoliza = $rowTipoPoliza['Id_tipoPoliza'];

// Obtener el ID de la aseguradora
$sqlAseguradora = "SELECT * FROM aseguradoras WHERE Id_Aseguradora = '$nombreAseguradora'";
$resultAseguradora = $conn->query($sqlAseguradora);

if ($resultAseguradora->num_rows == 0) {
    echo "La aseguradora no está registrada en la base de datos.";
    exit();
}

// Obtener el ID de la aseguradora
$rowAseguradora = $resultAseguradora->fetch_assoc();
$idAseguradora = $rowAseguradora['Id_Aseguradora'];

// Insertar en la tabla poliza
$fechaInicio = date("Y-m-d"); // Suponemos que la póliza comienza hoy
$descripcion = "Seguro registrado para el usuario $nombre $apellidos"; // Puedes personalizar la descripción si lo deseas

$sqlInsertPoliza = "INSERT INTO poliza (Numero_Poliza, Id_TipoPoliza, Id_Aseguradora, Fecha_Inicio, Fecha_Final, Descripcion) 
                    VALUES ('$numeroPoliza', '$idTipoPoliza', '$idAseguradora', '$fechaInicio', '$fechaVencimiento', '$descripcion')";

if ($conn->query($sqlInsertPoliza) === TRUE) {
    echo "Póliza registrada correctamente.";
} else {
    echo "Error al registrar la póliza: " . $conn->error;
}

// Validar tipo de seguro y agregar a la tabla correspondiente
if ($tipoSeguro == 'Transporte') {
    // Obtener datos adicionales del vehículo si el tipo es 'Transporte'
    $tipoVehiculo = $_POST['tipo_Vehiculo'];
    $placa = $_POST['placa'];
    $marca = $_POST['marca'];
    $descripcionVehiculo = $_POST['descripcion']; // Descripción del vehículo

    // Insertar el vehículo en la tabla vehiculo
    $sqlInsertVehiculo = "INSERT INTO vehiculo (Placa, Descripcion, TipoVehiculo, Marca) 
                          VALUES ('$placa', '$descripcionVehiculo', '$tipoVehiculo', '$marca')";

    if ($conn->query($sqlInsertVehiculo) === TRUE) {
        echo '<script language="javascript">alert("Vehículo registrado correctamente.");</script>';
        
        // Obtener el ID del vehículo recién insertado
        $idVehiculo = $conn->insert_id; // Obtiene el ID del último vehículo insertado

        // Insertar en la tabla segurovehiculo
        $sqlInsertSeguroVehiculo = "INSERT INTO segurovehiculo (Id_Aseguradora, Id_Vehiculo, Id_Poliza) 
                                VALUES (?, ?, ?)";
                                $stmt = $conn->prepare(query: $sql);
                                $stmt->bind_param("sss",$idAseguradora, $idVehiculo, $numeroPoliza);     
 
        if ($conn->query($sqlInsertSeguroVehiculo) === TRUE) {
           // echo "Seguro de vehículo registrado correctamente.";

            echo 
            's<script>
                Swal.fire({
                    icon: "error",
                    title: "Seguro de vehículo registrado correctamente.",
                    text: "",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    window.location.href = "/GM/h.html"; // Redirige a la página de bienvenida
                });
            </script>';





            
        } else {
            echo '<script language="javascript">alert("Error al registrar el seguro de vehículo" );</script>.';
        }
    } else {
        echo '<script language="javascript">alert("Error al registrar el vehículo: " );</script>';
    }
} elseif ($tipoSeguro == 'Vida') {
    // Insertar en la tabla segurovida
    $sqlInsertSeguroVida = "INSERT INTO segurovida (Id_Aseguradora, Id_Usuario, Id_Poliza, Estado) 
                            VALUES ('$idAseguradora', '$idUsuario', '$numeroPoliza', 'Activo')";

    if ($conn->query($sqlInsertSeguroVida) === TRUE) {
       echo '<script language="javascript">alert("Seguro de vida registrado correctamente.");</script>' ;
    } else {
         echo '<script language="javascript">alert("Error al registrar el seguro de vida: " );</script>' . $conn->error;
    }
}

$conn->close();
?>
