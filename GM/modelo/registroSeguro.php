<?php
include("conexion.php");

// Consulta para obtener las aseguradoras
$sql = "SELECT Id_Aseguradora, Nombre_Aseguradora FROM aseguradoras";
$result = $conn->query($sql);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombreAseguradora = $_POST['Nombre_Aseguradora'];
    $tipoSeguro = $_POST['Tipo_Seguro'];  // Puede ser 'Vida 2' o 'Transporte 1'
    $numPoliza = $_POST['Numero_Poliza'];
    $fechaVencimiento = $_POST['fecha_vencimiento'];
    $cedula = $_POST['Numero_Identidad'];
    $tipoVehiculo = $_POST['TipoVehiculo'];
    $placa = $_POST['placa'];

    // Obtener el Id_Aseguradora según el nombre seleccionado
    $sqlAseguradora = "SELECT Id_Aseguradora FROM aseguradoras WHERE Nombre_Aseguradora = '$nombreAseguradora'";
    $resultAseguradora = $conn->query($sqlAseguradora);
    $aseguradora = $resultAseguradora->fetch_assoc();
    $idAseguradora = $aseguradora['Id_Aseguradora'];

    // Insertar en la tabla TipoPoliza (si no existe ya)
    $sqlTipoPoliza = "SELECT Id_tipoPoliza FROM TipoPoliza WHERE NombrePoliza = '$tipoSeguro'";
    $resultTipoPoliza = $conn->query($sqlTipoPoliza);
    if ($resultTipoPoliza->num_rows == 0) {
        $sqlTipoPolizaInsert = "INSERT INTO TipoPoliza (NombrePoliza) VALUES ('$tipoSeguro')";
        $conn->query($sqlTipoPolizaInsert);
        $idTipoPoliza = $conn->insert_id;  // Obtener el ID recién insertado
    } else {
        $rowTipoPoliza = $resultTipoPoliza->fetch_assoc();
        $idTipoPoliza = $rowTipoPoliza['Id_tipoPoliza'];
    }

        // Verificar si la cedula ya existe
        $sqlusuario = "SELECT * FROM usuarios WHERE numero_identidad = ?";
        $stmt = $conn->prepare($sqlusuario);
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            //  echo '<script language="javascript">alert("El Documento ya está registrado, validar " );</script>';
            echo '
    <script>
        Swal.fire({
            icon: "error",
            title: "El Documento ya está registrado",
            text: "Por favor, inténtalo de nuevo",
            confirmButtonText: "Aceptar"
        }).then(() => {
            window.location.href = "/GM/registrarUserExt.html"; // Redirige a la página de bienvenida
        });
    </script>';
        }   // Insertar el nuevo usuario, incluyendo todos los datos nuevos
        $sqlusuario = "INSERT INTO usuarios (nombre, apellidos,  tipo_documento, numero_identidad) 
VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sqlusuario);
        $stmt->bind_param("siis", $nombre, $apellidos, $tipo_documento, $numero_identidad);


        if ($stmt->execute()) {

            //echo '<script language="javascript">alert("Usuario Registrado Exitosamente.");</script>';

            echo '
    <script>
        Swal.fire({
            icon: "success",
            title: "Usuario Registrado Exitosamente",
            text: "Bienvenido, ' . htmlspecialchars($row['nombre']) . '",
            confirmButtonText: "Aceptar"
        }).then(() => {
            window.location.href = "/GM/home.html"; // Redirige a la página de bienvenida
        });
    </script>';


        }


    // Insertar en la tabla Poliza
    $sqlPoliza = "INSERT INTO Poliza (Numero_Poliza, Id_tipoPoliza, Id_Aseguradora, Fecha_Inicio, Fecha_Final, Descripcion)
                  VALUES ('$numPoliza', '$idTipoPoliza', '$idAseguradora', CURDATE(), '$fechaVencimiento', 'Descripción del seguro')";
    if ($conn->query($sqlPoliza) === TRUE) {
        $idPoliza = $conn->insert_id;  // Obtener el ID de la póliza recién insertada

        // Si el tipo de seguro es 'Vida', insertar en SeguroVida
        if ($tipoSeguro == 'Vida') {
            // Se necesita un ID de usuario, que deberías obtener de alguna forma (por ejemplo, de una sesión o base de datos)
            $idUsuario = 1;  // Asegúrate de obtener el valor real del usuario
            $estado = 'Activo';  // El estado por defecto, puedes ajustarlo según corresponda

            $sqlSeguroVida = "INSERT INTO SeguroVida (Id_Aseguradora, Id_Usuario, Id_Poliza, Estado)
                              VALUES ('$idAseguradora', '$idUsuario', '$idPoliza', '$estado')";
            if ($conn->query($sqlSeguroVida) === TRUE) {
                echo "Seguro de Vida registrado exitosamente.";
            } else {
                echo "Error en la inserción del seguro de vida: " . $conn->error;
            }

            // Si el tipo de seguro es 'Transporte', insertar en SeguroVehiculo
        if ($tipoSeguro == 'Transporte') {
            // Insertar vehículo en la tabla Vehiculo
            $sqlVehiculo = "INSERT INTO Vehiculo (Placa, TipoVehiculo, Marca, Descripcion)
                            VALUES ('$placa', '$tipoVehiculo', 'Marca de Vehículo', 'Descripción del vehículo')";
            if ($conn->query($sqlVehiculo) === TRUE) {
                $idVehiculo = $conn->insert_id;  // Obtener el ID de vehículo recién insertado
                $estado = 'Activo';  // El estado por defecto, puedes ajustarlo según corresponda

                // Insertar en la tabla SeguroVehiculo
                $sqlSeguroVehiculo = "INSERT INTO SeguroVehiculo (Id_Aseguradora, Id_Vehiculo, Id_Poliza, Estado)
                                      VALUES ('$idAseguradora', '$idVehiculo', '$idPoliza', '$estado')";
                if ($conn->query($sqlSeguroVehiculo) === TRUE) {
                    echo "Seguro de Vehículo registrado exitosamente.";
                } else {
                    echo "Error en la inserción del seguro de vehículo: " . $conn->error;
                }
            } else {
                echo "Error en la inserción del vehículo: " . $conn->error;
            }
        }
    } else {
        echo "Error en la inserción de la póliza: " . $conn->error;
    }
}
}
$conn->close();
?>