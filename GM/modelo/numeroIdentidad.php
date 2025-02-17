<?php
// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "gmk");

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $tipo_documento = $_POST['tipo_documento'];
    $numero_identidad = $_POST['numero_identidad'];
    $nombre_aseguradora = $_POST['Nombre_Aseguradora'];
    $num_poliza = $_POST['num_poliza'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $tipo_poliza = $_POST['tipoPoliza'];
    $tipo_vehiculo = isset($_POST['tipoVehiculo']) ? $_POST['tipoVehiculo'] : null;
    $placa = isset($_POST['placa']) ? $_POST['placa'] : null;
    $marca = isset($_POST['marca']) ? $_POST['marca'] : null;

    // Verificar si la persona ya está registrada
    $sql_check_user = "SELECT * FROM usuarios WHERE numero_identidad = ?";
    $stmt = $conn->prepare($sql_check_user);
    $stmt->bind_param("s", $numero_identidad);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Persona ya registrada, solo agregar el seguro
        $user = $result->fetch_assoc();
        $id_usuario = $user['id_usuario']; // Asumiendo que 'id_usuario' es la clave primaria en la tabla de usuarios

        // Insertar el seguro
        $sql_insert_seguro = "INSERT INTO seguros (id_usuario, nombre_aseguradora, num_poliza, fecha_vencimiento, tipo_poliza, tipo_vehiculo, placa, marca) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert_seguro);
        $stmt->bind_param("isssssss", $id_usuario, $nombre_aseguradora, $num_poliza, $fecha_vencimiento, $tipo_poliza, $tipo_vehiculo, $placa, $marca);
        if ($stmt->execute()) {
            echo "Seguro agregado correctamente.";
        } else {
            echo "Error al agregar el seguro.";
        }
    } else {
        // Persona no registrada, agregar a la tabla de usuarios primero
        $sql_insert_user = "INSERT INTO usuarios (nombre, apellidos, tipo_documento, numero_identidad) 
                            VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert_user);
        $stmt->bind_param("ssss", $nombre, $apellidos, $tipo_documento, $numero_identidad);
        if ($stmt->execute()) {
            $id_usuario = $stmt->insert_id; // Obtener el ID del nuevo usuario

            // Insertar el seguro
            $sql_insert_seguro = "INSERT INTO seguros (id_usuario, nombre_aseguradora, num_poliza, fecha_vencimiento, tipo_poliza, tipo_vehiculo, placa, marca) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql_insert_seguro);
            $stmt->bind_param("isssssss", $id_usuario, $nombre_aseguradora, $num_poliza, $fecha_vencimiento, $tipo_poliza, $tipo_vehiculo, $placa, $marca);
            if ($stmt->execute()) {
                echo "Usuario registrado y seguro agregado correctamente.";
            } else {
                echo "Error al agregar el seguro.";
            }
        } else {
            echo "Error al registrar el usuario.";
        }
    }
    // Cerrar la conexión
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Seguros</title>
    <link rel="stylesheet" href="css/styles.css" type="text/css">

    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- JQuery -->
    <script src="jquery-ui-1.14.0.custom/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JQuary  calendario -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
    <script src="js/script.js"></script>
    

</head>

<body>
    <header class="container-fluid">
        <div class="container flex justify-between">
            <center><img class="img-fluid" src="img/logo2.jpg" alt="logo"></center>
            <!-- class="img-fluid" es el responsive desde boostrap -->
        </div>
        <nav class="container">
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="home.html">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="cuenta.html">Cuenta</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Consultar Seguros
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="transporte.html">Transporte</a></li>
                                    <li><a class="dropdown-item" href="vida.html">Vida</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Conctacto
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="nosotros.html">Acerca de Nosotros</a></li>
                                    <li><a class="dropdown-item" href="servicios.html">Servicios</a></li>
                                    <li><a class="dropdown-item" href="aliados.html">Aliados</a></li>
                                    <li><a class="dropdown-item" href="correo.html">Contactanos</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.html">Salir</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </nav>
    </header>
    <main>
        <article>
            <center>
                <section class="container flex justify-between">
                    <h2>
                        Ingresar los Datos del Seguros
                    </h2>
                    <br><br>
                    <section action="" class="flex justify-between border border-dark ">
                        <br><br>
                        
<!-- Aquí va el formulario HTML -->
<form id="registroSeguro" method="POST" action="agregar.php">
    <div>
        <label for="Nombre_Aseguradora">Nombre Aseguradora:</label>
        <select name="Nombre_Aseguradora" id="Nombre_Aseguradora" required>
            <option value="" disabled selected>Seleccionar Aseguradora</option>
            <?php
            // Consultar las aseguradoras
            $sql = "SELECT * FROM aseguradoras";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['Id_Aseguradora'] . "'>" . $row['Nombre_Aseguradora'] . "</option>";
                }
            } else {
                echo "<option value=''>No hay aseguradoras disponibles</option>";
            }
            ?>
        </select>
    </div>
    <br><br>
    <label for="nombre">Nombres:</label>
    <input type="text" id="nombre" name="nombre" required><br><br>
    <label for="apellidos">Apellidos:</label>
    <input type="text" id="apellidos" name="apellidos" required><br><br>
    <label for="tipo_documento">Tipo de Documento:</label>
    <select name="tipo_documento" id="tipo_documento" required>
        <option selected disabled>Seleccione</option>
        <option value="cedula">CC</option>
        <option value="cedula_Extranjeria">CE</option>
        <option value="tarjet_identidad">TI</option>
        <option value="registro_civil">RC</option>
        <option value="documento_nacional_identidad">DNI</option>
    </select><br><br>
    <label for="numero_identidad">Número de Identidad:</label>
    <input type="text" id="numero_identidad" name="numero_identidad" required><br><br>
    
    <label for="num_poliza">Número Poliza:</label>
    <input type="text" id="num_poliza" name="num_poliza" required><br><br>
    
    <label for="fecha_vencimiento">Fecha Vencimiento:</label>
    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" required><br><br>

    <label for="tipoPoliza">Tipo de seguro:</label>
    <select id="Id_tipoPoliza" name="tipoPoliza" required>
        <option value="Transporte">Transporte</option>
        <option value="Vida">Vida</option>
    </select><br><br>

    <div id="TipoVehiculo" style="display: none;">
        <label for="tipoVehiculo">Tipo de vehículo:</label>
        <input type="text" id="tipoVehiculo" name="tipoVehiculo"><br><br>
    </div>

    <div id="Placa" style="display: none;">
        <label for="placa">Matrícula del vehículo:</label>
        <input type="text" id="placa" name="placa"><br><br>
    </div>

    <div id="Marca" style="display: none;">
        <label for="marca">Marca del vehículo:</label>
        <input type="text" id="marca" name="marca"><br><br>
    </div>
    
    <button type="submit">Registrar Seguro</button>
</form>

     

<div class="flex justify-between  space-x-2 mt-4">

<input type="submit" class="boton" value="Registrar" role="button" style="margin: 20px">

<a href="seguros.html" class="boton" role="button"
    style="margin-left: 20px">Modificar</a>
</div>
<br><br><br>
</form>
</section>
</section>
</center>
</article>
</main>

<br><br>
<footer>
<p>© 2024 GMK Seguros. Todos los derechos reservados.</p>
</footer>

<meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Responsive -->
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- y se cierra con -->

<!-- script para el calendariop, con Jquery UI -->
<script type="text/javascript">
$(function () {
$("#fecha_vencimiento").datepicker({

showOn: "button",
buttonImage: "img/calendario.jpg",
buttonImageOnly: true,
buttonText: "Select date",
changeMonth: true,
changeYear: true,

});
});
</script>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>



</body>

</html>