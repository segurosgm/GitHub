
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Seguros</title>
  
   <!-- CSS -->
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
   <!-- Alertas -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>

    <script src="js/validaciones.js"></script>
 
 



</head>
<body>
    <header class="container-fluid">
        <div class="container flex justify-between">
            <center><img class="img-fluid" src="img/logo2.jpg" alt="logo"></center>
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
                                    <li><a class="dropdown-item" href="buscarTransporte.html">Transporte</a></li>
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
                                    <li><a class="dropdown-item" href="correo.html">Contáctanos</a></li>
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
                    <h2>Ingresar los Datos del Seguro</h2>
                    <br><br>
                    <section action="" class="flex justify-between border border-dark">
                        <br><br>
                        <form id="registroSeguro" method="POST" action="">
                            <div>
                                <label for="Nombre_Aseguradora">Nombre Aseguradora:</label>
                                <select name="Nombre_Aseguradora" id="Nombre_Aseguradora" required>
                                    <option value="" disabled selected>Seleccionar Aseguradora</option>
                                    <?php
                                    $conn = new mysqli("localhost", "root", "", "gmk");
                                    if ($conn->connect_error) {
                                        die("Conexión fallida: " . $conn->connect_error);
                                    }
                                    $sql = "SELECT * FROM aseguradoras";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['Nombre_Aseguradora'] . "'>" . $row['Nombre_Aseguradora'] . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No hay aseguradoras disponibles</option>";
                                    }
                                    $conn->close();
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
                            <div class="form-group">
                                <div class="flex justify-between">
                                    <label for="poliza">Número Poliza:</label>
                                    <input type="text" id="num_poliza" name="num_poliza">
                                </div>
                                <br>
                                <div class="flex justify-between">
                                    <label>Fecha Vencimiento:</label>
                                    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" >
                                </div>
                                <br>
                                <label for="Id_tipoPoliza">Tipo de seguro:</label>
                                <select id="Id_tipoPoliza" name="tipoPoliza" onchange="toggleVehiculoFields()" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="Transporte">Transporte</option>
                                    <option value="Vida">Vida</option>
                                </select><br><br>
                                <div id="TipoVehiculo" style="display: none;">
                                    <label for="tipoVehiculo">Tipo de vehículo:</label>
                                    <input type="text" id="tipoVehiculo" name="tipoVehiculo">
                                </div><br>
                                <div id="Placa" style="display: none;">
                                    <label for="placa">Matrícula del vehículo:</label>
                                    <input type="text" id="placa" name="placa">
                                </div><br>
                                <div id="Marca" style="display: none;">
                                    <label for="marca">Marca del vehículo:</label>
                                    <input type="text" id="marca" name="marca">
                                </div>
                                <div class="flex justify-between space-x-2 mt-4">
                                    <input type="submit" class="boton" value="Registrar" role="button" style="margin: 20px">
                                    <a href="seguros.html" class="boton" role="button" style="margin-left: 20px">Modificar</a>
                                </div>
                                <br><br><br>
                            </div>
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
    <script>
           function toggleVehiculoFields() {
            var tipoSeguro = document.getElementById("Id_tipoPoliza").value;
            if (tipoSeguro === "Transporte") {
                document.getElementById("TipoVehiculo").style.display = "block";
                document.getElementById("Placa").style.display = "block";
                document.getElementById("Marca").style.display = "block";
                document.getElementById("tipoVehiculo").required = true;
                document.getElementById("placa").required = true;
                document.getElementById("marca").required = true;
            } else {
                document.getElementById("TipoVehiculo").style.display = "none";
                document.getElementById("Placa").style.display = "none";
                document.getElementById("Marca").style.display = "none";
                document.getElementById("tipoVehiculo").required = false;
                document.getElementById("placa").required = false;
                document.getElementById("marca").required = false;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
</body>
</html>

<?php
// conexión a la base de datos
include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombreAseguradora = $_POST['Nombre_Aseguradora'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $tipoDocumento = $_POST['tipo_documento'];
    $numeroIdentidad = $_POST['numero_identidad'];
    $poliza = $_POST['num_poliza'];
    $fechaVencimiento = $_POST['fecha_vencimiento'];  
    $tipoPoliza = $_POST['tipoPoliza'];
    $tipoVehiculo = isset($_POST['tipoVehiculo']) ? $_POST['tipoVehiculo'] : null;
    $placa = isset($_POST['placa']) ? $_POST['placa'] : null;
    $marca = isset($_POST['marca']) ? $_POST['marca'] : null;

    // Verificar la aseguradora 
    $stmt = $conn->prepare("SELECT Id_Aseguradora FROM aseguradoras WHERE Nombre_Aseguradora = ?");
    $stmt->bind_param("s", $nombreAseguradora);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $rowAseguradora = $result->fetch_assoc();
        $idAseguradora = $rowAseguradora['Id_Aseguradora'];
    }

    // Verificar la tiposeguro
    $stmt = $conn->prepare("SELECT Id_tipoPoliza FROM tipopoliza WHERE NombrePoliza = ?");
    $stmt->bind_param("s", $tipoPoliza);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $rowTipoPoliza = $result->fetch_assoc();
        $idtipoPoliza = $rowTipoPoliza['Id_tipoPoliza'];
    }


    // Verificar si el usuario ya existe en la tabla usuario
$stmt = $conn->prepare("SELECT Id FROM usuarios WHERE Numero_Identidad = ?");
$stmt->bind_param("s", $numeroIdentidad);
$stmt->execute();
$result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si el usuario ya existe, obtener su ID
        $rowUsuario = $result->fetch_assoc();
        $idUsuario = $rowUsuario['Id'];
    } else {
        // Si el usuario no existe, insertar en la tabla usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (Numero_Identidad, Nombre, Apellidos, Tipo_Documento) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $numeroIdentidad, $nombre, $apellidos, $tipoDocumento);
        $stmt->execute();
        $idUsuario = $stmt->insert_id;
    }


    // Insertar en la tabla poliza
    $stmt = $conn->prepare("INSERT INTO poliza (Numero_Poliza, Id_tipoPoliza, Id_Aseguradora, Fecha_Inicio, Fecha_Final, Id_Usuario) VALUES (?, ?, ?, NOW(), ?, ?)");
    $stmt->bind_param("siisi", $poliza, $idtipoPoliza, $idAseguradora, $fechaVencimiento, $idUsuario );
    
    $stmt->execute();
    $idPoliza = $stmt->insert_id;

    // Lógica para seguro de transporte
    if ($tipoPoliza == "Transporte") {
        // Insertar en la tabla vehiculo
        $stmt = $conn->prepare("INSERT INTO vehiculo (Placa, TipoVehiculo, Marca) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $placa, $tipoVehiculo, $marca);
        $stmt->execute();
        $idVehiculo = $stmt->insert_id;

        // Insertar en la tabla segurovehiculo
        $stmt = $conn->prepare("INSERT INTO segurovehiculo (Id_Aseguradora, Id_Vehiculo, Id_Poliza, Estado) VALUES (?, ?, ?, 'Activo')");
        $stmt->bind_param("iii", $idAseguradora, $idVehiculo, $idPoliza);
        $stmt->execute();
    }

    // Lógica para seguro de vida
    if ($tipoPoliza == "Vida") {
        // Insertar en la tabla segurovida
        $stmt = $conn->prepare("INSERT INTO segurovida (Id_Aseguradora, Id_Usuario, Id_Poliza, Estado) VALUES (?, ?, ?, 'Activo')");
        $stmt->bind_param("iii", $idAseguradora, $idUsuario, $idPoliza);
        $stmt->execute();
    }

    // Mensaje de éxito
    echo '
    <script>
        Swal.fire({
            icon: "success",
            title: "Seguro Registrado Exitosamente",
            text: "",
            confirmButtonText: "Aceptar"
        }).then(() => {
            window.location.href = "//nosotros.html"; // Redirige a la página de bienvenida
        });
    </script>';
   
}




$conn->close();
?>

