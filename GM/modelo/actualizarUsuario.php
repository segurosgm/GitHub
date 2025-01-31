<?php
// Incluir el archivo de conexión
include('conexion.php');


// Verificar si los datos fueron enviados por el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario

    
    if (isset($_POST['id']))
    $id = $_POST['id'];
   
 
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $contrasena = $_POST['contrasena'];
    $contrasena2 = $_POST['contrasena2'];

    // Verificar si las contraseñas coinciden
    if ($contrasena !== $contrasena2) {
        echo "Las contraseñas no coinciden.";
        exit();
    }

    // Si se proporciona una nueva contraseña, encriptarla
    if (!empty($contrasena)) {
        $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        
    } else {
        // Si no se cambia la contraseña, mantener la anterior
        // Consultar la contraseña actual
        $sql = "SELECT contrasena FROM usuarios WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $usuario = $result->fetch_assoc();
                $contrasena = $usuario['contrasena'];  // Mantener la contraseña anterior
               
            }
            $stmt->close();

        }
    
       
    }
    $contrasena2 = $contrasena;
    // Preparar la sentencia SQL para actualizar los datos
    $sql = "UPDATE usuarios SET nombre=?, apellidos=?, fecha_nacimiento=?, correo=?, telefono=?, contrasena=?, contrasena2=? WHERE Id=?";
    if ($stmt = $conn->prepare($sql)) {
        // Vincular los parámetros
        $stmt->bind_param("sssssssi", $nombre, $apellidos, $fecha_nacimiento, $correo, $telefono, $contrasena, $contrasena2, $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Usuario actualizado exitosamente." ;
        } else {
            echo "Error al actualizar el usuario: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>
