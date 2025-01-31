<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "gmk");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['numero_identidad'];

    // Consulta para obtener los datos del usuario
    $query = "SELECT * FROM usuarios WHERE numero_identidad = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        // Generar formulario con los datos del usuario
        echo '<form id="editarForm" method="POST" action="modificarUsuario.php">';
        echo '<label for="nombre">Nombre:</label>';
        echo '<input type="text" id="nombre" name="nombre" value="' . $usuario['nombre'] . '" required><br><br>';
        echo '<label for="apellidos">Apellidos:</label>';
        echo '<input type="text" id="apellidos" name="apellidos" value="' . $usuario['apellidos'] . '" required><br><br>';
        echo '<label for="correo">Correo Electrónico:</label>';
        echo '<input type="email" id="correo" name="correo" value="' . $usuario['correo'] . '" required><br><br>';
        echo '<label for="telefono">Teléfono:</label>';
        echo '<input type="text" id="telefono" name="telefono" value="' . $usuario['telefono'] . '" required><br><br>';
        echo '<label for="departamento">Departamento:</label>';
        echo '<select id="departamento" name="departamento" required>';
        // Aquí puedes generar las opciones del select dinámicamente
        echo '<option value="' . $usuario['departamento_id'] . '" selected>' . $usuario['departamento_id'] . '</option>';
        echo '</select><br><br>';
        echo '<label for="ciudad">Ciudad:</label>';
        echo '<select id="ciudad" name="ciudad" required>';
        echo '<option value="' . $usuario['ciudad_id'] . '" selected>' . $usuario['ciudad_id'] . '</option>';
        echo '</select><br><br>';
        echo '<input type="hidden" name="numero_identidad" value="' . $usuario['numero_identidad'] . '">';
        echo '<input type="submit" value="Guardar Cambios" class="boton">';
        echo '</form>';
    } else {
        echo "No se encontraron resultados para la cédula ingresada.";
    }

    $stmt->close();
}
$conexion->close();
?>
