<?php
// Conexión a la base de datos
include('conexion.php');

$departamento_id = intval($_POST['departamento_id']);

$query = "SELECT id, nombre FROM ciudades WHERE departamento_id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $departamento_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    echo '<option selected disabled>Seleccione</option>';
    while ($row = $resultado->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
    }
} else {
    echo '<option disabled>No hay ciudades disponibles</option>';
}

$stmt->close();
$conexion->close();
?>
