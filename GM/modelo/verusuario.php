<?php
// Conexión a la base de datos
 include ('conexion.php');


$usuario = null;
$error = null;

// Buscar usuario por cédula
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];

    // Consulta SQL para buscar usuario
    $sql = "SELECT * FROM usuarios WHERE numero_identidad = $cedula";
    $stmt = $conn->prepare($sql);
    
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        $error = "No se encontraron resultados para la cédula ingresada.";
    }

    $stmt->close();
}





// Guardar cambios si el formulario de edición es enviado
if (isset($_POST['guardar_cambios'])) {
    $numero_identidad = $_POST['numero_identidad'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $id_user = $_POST['Id'] ?? '';
    

    // Consulta SQL para actualizar los datos
    $sql = "UPDATE usuarios SET nombre = ?, apellidos = ?, correo = ?, telefono = ? WHERE numero_identidad = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombre, $apellidos, $correo, $telefono, $id_user);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Datos actualizados correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar los datos: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Buscar y Editar Usuario</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="cedula" class="form-label">Cédula:</label>
                <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Ingrese la cédula del usuario" required>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <?php if ($error): ?>
            <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ( $usuario): ?>
            <h3 class="mt-5">Editar Información del Usuario</h3>
            <form method="POST">
                <br><br>
                <div>
                <?php    echo "<p><strong>Numero Identidad: </strong>" . $usuario['Numero_Identidad'] . "</p>";?>
                </div>
           <br>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php  echo  $usuario['Nombre'];?>" required>
                </div>
              
                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos:</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $usuario['Apellidos'] ?? ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $usuario['Correo'] ?? ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono:</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $usuario['Telefono'] ?? ''; ?>" required>
                </div>

                

                <button type="submit" name="guardar_cambios" class="btn btn-success">Guardar Cambios</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
