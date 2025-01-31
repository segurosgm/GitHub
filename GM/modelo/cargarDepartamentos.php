<?php
// Conexión a la base de datos
include('conexion.php');

$query = "SELECT id, nombre FROM departamentos ORDER BY nombre";
$resultado = $conexion->query($query);

if ($resultado->num_rows > 0) {
    echo '<option selected disabled>Seleccione</option>';
    while ($row = $resultado->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
    }
} else {
    echo '<option disabled>No hay departamentos disponibles</option>';
}

$conexion->close();
?>
