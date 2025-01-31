<?php
// Incluir el archivo de conexión
include('conexion.php');

// Verificar si se pasó el ID del usuario a través de la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar la base de datos para obtener los datos del usuario
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
        } else {
            echo "Usuario no encontrado.";
            exit();
        }
        
        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error en la consulta: " . $conn->error;
    }
} else {
    echo "ID de usuario no especificado.";
    exit();
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
</head>
<body>
    <h2>Editar Usuario</h2>

    <form action="actualizar_usuario.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required><br><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" value="<?php echo $usuario['apellidos']; ?>" required><br><br>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" value="<?php echo $usuario['fecha_nacimiento']; ?>" required><br><br>

        <label for="correo">Correo:</label>
        <input type="email" name="correo" value="<?php echo $usuario['correo']; ?>" required><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" value="<?php echo $usuario['telefono']; ?>" required><br><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena"><br><br>

        <label for="contrasena2">Confirmar Contraseña:</label>
        <input type="password" name="contrasena2"><br><br>

        <input type="submit" value="Actualizar Usuario">
    </form>
</body>
</html>
