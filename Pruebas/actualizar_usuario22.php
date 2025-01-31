<?php
// Configuración de la conexión
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$nombre_base_datos = "GMK";

$conn = new mysqli($servidor, $usuario, $contraseña, $nombre_base_datos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica los datos que están llegando al servidor
    var_dump($_POST); // Verifica los datos que están llegando al servidor
    exit(); // Detiene el script para que puedas ver los datos enviados

    // Recibir y procesar los datos del formulario
    $numero_identidad = $_POST['Numero_Identidad'] ?? '';
    $nombre = $_POST['Nombre'] ?? '';
    $apellidos = $_POST['Apellidos'] ?? '';
    $correo = $_POST['Correo'] ?? '';
    $telefono = $_POST['Telefono'] ?? '';
    $fecha_nacimiento = $_POST['Fecha_Nacimiento'] ?? '';
    $contrasena = $_POST['Contrasena'] ?? '';
    $contrasena2 = $_POST['Contrasena2'] ?? '';

    // Verificar si las contraseñas coinciden
    if ($contrasena !== $contrasena2) {
        echo "Las contraseñas no coinciden.";
        exit();
    }

    // Encriptar la contraseña
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Verificar si el número de identidad existe en la base de datos
    $sql_check = "SELECT * FROM usuarios WHERE Numero_Identidad = ?";
    if ($stmt_check = $conn->prepare($sql_check)) {
        $stmt_check->bind_param("s", $numero_identidad);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows == 0) {
            echo "El número de identidad no existe en la base de datos.";
            exit();
        }
        $stmt_check->close();
    } else {
        echo "Error al preparar la consulta de verificación: " . $conn->error;
        exit();
    }

    // Asegurándonos de que todos los campos no estén vacíos o asignar un valor por defecto
    $nombre = $nombre ?: 'Nombre vacío'; // Valor predeterminado
    $apellidos = $apellidos ?: 'Apellidos vacíos'; // Valor predeterminado
    $correo = $correo ?: 'Correo vacío'; // Valor predeterminado
    $telefono = $telefono ?: 'Teléfono vacío'; // Valor predeterminado
    $fecha_nacimiento = $fecha_nacimiento ?: '0000-00-00'; // Valor predeterminado
    $contrasena_hash = $contrasena_hash ?: ''; // Si no hay contraseña, deja el campo vacío

    // Consulta SQL para actualizar los datos
    $sql = "UPDATE usuarios SET
            nombre = ?, 
            apellidos = ?, 
            correo = ?, 
            telefono = ?, 
            fecha_nacimiento = ?, 
            contrasena = ?
            WHERE Numero_Identidad = ?";

    // Preparar la declaración SQL
    if ($stmt = $conn->prepare($sql)) {
        // Enlazamos los parámetros
        $stmt->bind_param("sssssss", $nombre, $apellidos, $correo, $telefono, $fecha_nacimiento, $contrasena_hash, $numero_identidad);

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            // Verificamos cuántas filas fueron afectadas
            if ($stmt->affected_rows > 0) {
                echo "Datos actualizados exitosamente.";
            } else {
                echo "No se actualizó ninguna fila. Verifica que los datos no hayan cambiado o que el número de identidad sea correcto.";
            }
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta de actualización: " . $conn->error;
    }
}

$conn->close();
?>
