<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Cuenta</title>
    <link rel="stylesheet" href="/Github/GM/css/styles.css" type="text/css">
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
    <base href="/Github/GM/">
</head>

<body>
    <header class="container-fluid">
        <div class="container flex justify-between">
            <center><img class="img-fluid" src="img/logo2.jpg" alt="logo GMK Seguros Especialistas en Riesgos y 
                Seguros"></center>
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
                                <a class="nav-link " href="cuenta.html">Cuenta</a>
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
                        Información Seguro del Vehiculo 
                    </h2>
                    <br>
                    <section class=" flex justify-between border border-dark ">
                        <br><br>
                        <?php
                        // Configuración para la conexión a la base de datos
                        include("conexion.php");

                       
                 
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            // Obtener la placa desde el formulario
                            $placa = $conn->real_escape_string($_POST['Placa']);
                        
                            // Consultar la base de datos para obtener la información del vehículo
                            $sql = "SELECT Id_Vehiculo FROM vehiculo WHERE Placa = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("s", $placa); // "s" indica string
                            $stmt->execute();
                            $result = $stmt->get_result();
                        
                            if ($result->num_rows > 0) {
                                // Obtener el ID del vehículo
                                $row = $result->fetch_assoc();
                                $idplaca = $row['Id_Vehiculo'];
                        
                                // Obtener la aseguradora del vehículo
                                $sql = "SELECT Id_Aseguradora, Id_Poliza FROM segurovehiculo WHERE Id_Vehiculo = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $idplaca);
                                $stmt->execute();
                                $result = $stmt->get_result();
                        
                                if ($result->num_rows > 0) {
                                    $rowSeguro = $result->fetch_assoc();
                                    $idAseg = $rowSeguro['Id_Aseguradora'];
                                    $idpol = $rowSeguro['Id_Poliza'];
                        
                                    // Obtener datos de la aseguradora
                                    $sql = "SELECT Nombre_Aseguradora, TelefonoEmergencia FROM aseguradoras WHERE Id_Aseguradora = ?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("i", $idAseg);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $nomAseg = $telefonoEmergencia = "";
                        
                                    if ($result->num_rows > 0) {
                                        $rowAseg = $result->fetch_assoc();
                                        $nomAseg = $rowAseg['Nombre_Aseguradora'];
                                        $telefonoEmergencia = $rowAseg['TelefonoEmergencia'];
                                    }
                        
                                    // Obtener datos de la póliza
                                    $sql = "SELECT Numero_Poliza, Fecha_Final FROM Poliza WHERE Id_Poliza = ?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("i", $idpol);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $numpol = $FechaFinal = "";
                        
                                    if ($result->num_rows > 0) {
                                        $rowPoliza = $result->fetch_assoc();
                                        $numpol = $rowPoliza['Numero_Poliza'];
                                        $FechaFinal = $rowPoliza['Fecha_Final'];
                                    }
                        
                                    // Mostrar los resultados
                                    echo "<p><strong>Placa:</strong> " . htmlspecialchars($placa) . "</p>";
                                    echo "<p><strong>Aseguradora:</strong> " . htmlspecialchars($nomAseg) . "</p>";
                                    echo "<p><strong>Teléfono Emergencia:</strong> " . htmlspecialchars($telefonoEmergencia) . "</p>";
                                    echo "<p><strong>Número de Póliza:</strong> " . htmlspecialchars($numpol) . "</p>";
                                    echo "<p><strong>Fecha de Vencimiento:</strong> " . htmlspecialchars($FechaFinal) . "</p>";
                                } else {
                                    echo "<h2><strong>No se encontró información de seguro para esta placa</strong></h2>";
                                }
                            } else {
                                echo "<h2><strong>No se encontró PLACA</strong></h2>";

                                
                            }
                        
                            // Cerrar la conexión a la base de datos
                            $stmt->close();
                            $conn->close();
                        }
                        
                        
                        ?>    <br><br>
 <!-- Formulario de búsqueda  -->
 <form action="buscarTransporte.html" method="POST">
       
        <button type="submit" class="boton" role="button">Nueva Conosulta</button> <br><br>
    </form>

                    
                       
                    

                        <br><br>
                        <br><br>
                    </section>
            </center>
            </section>
        </article>
    </main>
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Responsive -->
    <footer>
        <p>© 2024 GMK Seguros. Todos los derechos reservados.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>

</body>

</html>