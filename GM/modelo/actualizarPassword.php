


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
            echo '
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Datos Actualizado Exitosamente",
                    text: "Bienvenido",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    window.location.href = "/GM/home.html"; // Redirige a la página de bienvenida
                });
            </script>';
        
            
            
        } else {
           // echo "Error al actualizar el usuario: " . $stmt->error;

            echo '
            <script>
                Swal.fire({
                    icon: "danger",
                     title: "Error al actualizar el usuario:",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    window.location.href = "/GM/home.html"; // Redirige a la página de bienvenida
                });
            </script>';
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    


<main>
        <article>
            <center>
                <section class="container flex justify-between">
                    <article class="container flex justify-between">
                        <h2>Actualizacion de Registro</h2>
                        <br><br>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="cedula" class="form-label">Cédula:</label><br>
                                <input type="text" class="form-control" id="Numero_Identidad" name="Numero_Identidad"
                                    placeholder="Ingrese la cédula del usuario" required>
                            </div><br><br>
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </form><br><br>



                        <section class=" flex justify-between border border-dark ">
                          

                            <?php if ($error): ?>
                                <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                            <?php endif; ?>


                            <?php if ($usuario): ?>
                                
                                <form method="POST" action="actualizarUsuario.php">
                                    <br><br>
                                    <div>
                                        <?php echo "<p><strong>Numero Identidad: </strong>" . $usuario['Numero_Identidad'] . "</p>"; ?>
                                    </div>
                                    <br><br>
                                   


                                    <div>
                                    <label for="nombre">Numero Id:</label>
                                        <input type="text" id="id" name="id"
                                            value="<?php echo $usuario['Id']?? ''; ?>" readonly ><br><br>

                                        
                                        <label for="nombre">Nombre:</label>
                                        <input type="text" id="nombre" name="nombre"
                                            value="<?php echo $usuario['Nombre']; ?>" ><br><br>
                                        <label for="apellidos">Apellidos:</label>
                                        <input type="text" id="apellidos" name="apellidos"
                                            value="<?php echo $usuario['Apellidos'] ?? ''; ?>" ><br><br>

                                        <!-- Campo de Fecha de Nacimiento -->
                                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                                            value="<?php echo $usuario['Fecha_Nacimiento'] ?? ''; ?>" ><br><br>
                                        <label for="correo">Correo electrónico:</label>
                                        <input type="email" id="correo" name="correo"
                                            value="<?php echo $usuario['Correo'] ?? ''; ?>" ><br><br>
                                        <!-- Campo de Número de Teléfono -->
                                        <label for="telefono">Número de Teléfono:</label>
                                        <input type="text" id="telefono" name="telefono"
                                            value="<?php echo $usuario['Telefono'] ?? ''; ?>" ><br><br>
                                        
                                        <label for="contrasena">Contraseña:</label>
                                        <input type="password" id="contrasena" name="contrasena"
                                            value="<?php echo $usuario['Contrasena'] ?? ''; ?>" ><br><br>
                                        <label for="confirmar_contrasena">Confirmar contraseña:</label>
                                        <input type="password" id="contrasena2" name="contrasena2"
                                            value="<?php echo $usuario['Contrasena2'] ?? ''; ?>" ><br><br>


                                        <br><br>
                                        <input type="submit" value="Guardar" id="guardar_cambios" name="guardar_cambios" class="boton" role="button"><br><br>
                                </form>

                                </body>
</html>