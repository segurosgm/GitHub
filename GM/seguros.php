<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "GMK"; // Aquí deberías colocar el nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombreAseguradora = $_POST['nombreAseguradora'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $numeroIdentidad = $_POST['numeroIdentidad'];
    $poliza = $_POST['Numero_Poliza'];
   
    $fechaVencimiento = $_POST['fechaVencimiento'];
    $tipoPoliza = $_POST['tipoPoliza'];
    $tipoVehiculo = $_POST['tipoVehiculo'];
    $placa = $_POST['placa'];
    $marca = $_POST['marca'];

    // Verificar la aseguradora 

$asgsql = "SELECT Id_Aseguradora FROM aseguradoras WHERE Nombre_Aseguradora = '$nombreAseguradora'";
$resulasgsql =$conn->query($asgsql);


if ($resulasgsql->num_rows > 0) {
    $rowAseguradora = $resulasgsql->fetch_assoc();
    $idAseguradora = $rowAseguradora['Id_Aseguradora'];

}
   // Verificar la tiposeguro
   $tpsql = "SELECT Id_tipoPoliza  FROM tipopoliza WHERE NombrePoliza = '$tipoPoliza'";
   $resultpsql =$conn->query($tpsql);
   
   
   if ($resultpsql->num_rows > 0) {
       $rowtpz = $resultpsql->fetch_assoc();
       $idtipoPoliza = $rowtpz['Id_tipoPoliza'];
   
   }


    // Verificar si el usuario ya existe en la tabla usuario
    $sql = "SELECT * FROM usuarios WHERE Numero_Identidad = '$numeroIdentidad'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Si el usuario ya existe, solo agregar la información a las otras tablas
        
        // Insertar en la tabla vehiculo
        $sqlVehiculo = "INSERT INTO vehiculo (Placa, TipoVehiculo, Marca) 
                        VALUES ('$placa', '$tipoVehiculo', '$marca')";
        $conn->query($sqlVehiculo);
        
        // Obtener el Id del Vehículo insertado
        $idVehiculo = $conn->insert_id;

        // Insertar en la tabla poliza
        $sqlPoliza = "INSERT INTO poliza (Numero_Poliza,  Id_Aseguradora, Id_tipoPoliza, Fecha_Inicio, Fecha_Final) 
                      VALUES ('$poliza',  '$idAseguradora', '$idtipoPoliza', NOW(), '$fechaVencimiento')";
        $conn->query($sqlPoliza);
        
        // Obtener el Id de la Póliza insertada
        $idPoliza = $conn->insert_id;

        // Insertar en la tabla segurovehiculo
        $sqlSeguroVehiculo = "INSERT INTO segurovehiculo (Id_Aseguradora, Id_Vehiculo, Id_Poliza, Estado) 
                              VALUES ('$idAseguradora', '$idVehiculo', '$idPoliza', 'Activo')";
        $conn->query($sqlSeguroVehiculo);
        
    } else {
        // Si el usuario no existe, insertar en la tabla usuario y las demás tablas

        // Insertar en la tabla usuario
        $sqlUsuario = "INSERT INTO usuario (Numero_Identidad, Nombre, Apellidos, Tipo_Documento) 
                       VALUES ('$numeroIdentidad', '$nombre', '$apellidos', '$tipoDocumento')";
        $conn->query($sqlUsuario);

        // Obtener el Id del Usuario insertado
        $idUsuario = $conn->insert_id;

        // Insertar en la tabla vehiculo
        $sqlVehiculo = "INSERT INTO vehiculo (Placa, TipoVehiculo, Marca) 
                        VALUES ('$placa', '$tipoVehiculo', '$marca')";
        $conn->query($sqlVehiculo);

        // Obtener el Id del Vehículo insertado
        $idVehiculo = $conn->insert_id;

        // Insertar en la tabla poliza
        $sqlPoliza = "INSERT INTO poliza (Numero_Poliza, Id_tipoPoliza, Id_Aseguradora, Fecha_Inicio, Fecha_Final) 
                      VALUES ('$poliza', '$tipoPoliza', '$idAseguradora', NOW(), '$fechaVencimiento')";
        $conn->query($sqlPoliza);

        // Obtener el Id de la Póliza insertada
        $idPoliza = $conn->insert_id;

        // Insertar en la tabla segurovida
        $sqlSeguroVida = "INSERT INTO segurovida (Id_Aseguradora, Id_Usuario, Id_Poliza, Estado) 
                          VALUES ('$idAseguradora', '$idUsuario', '$idPoliza', 'Activo')";
        $conn->query($sqlSeguroVida);

        // Insertar en la tabla segurovehiculo
        $sqlSeguroVehiculo = "INSERT INTO segurovehiculo (Id_Aseguradora, Id_Vehiculo, Id_Poliza, Estado) 
                              VALUES ('$idAseguradora', '$idVehiculo', '$idPoliza', 'Activo')";
        $conn->query($sqlSeguroVehiculo);
    }

    // Mensaje de éxito
    echo "Datos ingresados correctamente.";
}

$conn->close();
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
                        <form id="registroSeguro" method="POST" action="agregar.php" onsubmit="">


                            <?php


                            // Conectar a la base de datos
                            $conn = new mysqli("localhost", "root", "", "gmk");

                            // Comprobar la conexión
                            if ($conn->connect_error) {
                                die("Conexión fallida: " . $conn->connect_error);
                            }
                            ?>
                            <div>
                                <label for="Nombre_Aseguradora">Nombre Aseguradora:</label>
                                <select name="Nombre_Aseguradora" id="Nombre_Aseguradora" required>
                                    <!--<option value="">Seleccionar Aseguradora</option>  -->
                                    <option value="" disabled selected>Seleccionar Aseguradora</option>
                                    <!-- Aseguradoras serán cargadas por java -->

                                    <?php
                                    // Mostrar las aseguradoras obtenidas de la base de datos
                                    //include("/modelo/conexion.php");
                                    

                                    // Consultar las aseguradoras
                                    $sql = "SELECT * FROM aseguradoras";
                                    $result = $conn->query($sql);

                                    // Llenar la lista desplegable con las aseguradoras
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['Id_Aseguradora'] . "'>" . $row['Nombre_Aseguradora'] . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No hay aseguradoras disponibles</option>";
                                    }

                                    // Cerrar la conexión
                                    $conn->close();

                                    ?>


                                </select>
                            </div>
                            <br><br>
                            <label for="nombre">Nombres:</label>
                            <input type="text" id="nombre" name="nombre" required><br><br>
                            <label for="apellidos">Apellidos:</label>
                            <input type="text" id="apellidos" name="apellidos" required><br><br>
                            <!-- Campo de Tipo de Documento -->
                            <label for="tipo_documento">Tipo de Documento:</label>
                            <select class="" aria-label="Default select example" name="tipo_documento"
                                id="tipo_documento" required>
                                <option selected disabled>Seleccione</option>
                                <option value="cedula">CC</option>
                                <option value="cedula_Extranjeria">CE</option>
                                <option value="tarjet_identidad">TI</option>
                                <option value="registro_civil">RC</option>
                                <option value="documento_nacional_identidad">DNI</option>
                            </select><br><br>
                           <!-- Campo de Número de Identidad -->
                            <label for="numero_identidad">Número de Identidad:</label>
                            <input type="text" id="numero_identidad" name="numero_identidad" required><br><br>
                            
                            <div class="form-group">
                            <div class="flex justify-between">
                                <label for="poliza">
                                    Numero Poliza:
                                </label>
                                <input type="text" id="num_poliza" name="num_poliza">
                            </div>
                            <br>
                            <div class="flex justify-between">
                                <label>
                                    Fecha Vencimiento:
                                </label>
                                <input class="datepicker  col-auto" id="fecha_vencimiento" name="fecha_vencimiento" readonly
                                    placeholder="Mes/Dia/Año">
                            </div>
                            <br>



  <!-- Formulario con el campo de selección -->
  <form>
        <label for="Id_tipoPoliza">Tipo de seguro:</label>
        <select id="Id_tipoPoliza" name="tipoPoliza" onchange="toggleVehiculoFields()">
            <option value="">Seleccionar</option>
            <option value="Transporte">Transporte</option>
            <option value="Otro">Vida</option>
        </select><br>

        <!-- Contenedores que se mostrarán u ocultarán -->
        <br><div id="TipoVehiculo" style="display: none;">
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