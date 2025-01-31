<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Cuenta</title>
    <link rel="stylesheet" href="/GM/css/styles.css" type="text/css">
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
    <base href="/GM/">
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
                        Información del Usuario
                    </h2>
                    <br>
                    <section class=" flex justify-between border border-dark ">
                        <br><br>
                        <?php
                        // Configuración para la conexión a la base de datos
                        include("conexion.php");



                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            // Obtener el número de identidad desde el formulario
                            $numero_identidad = $conn->real_escape_string(string: $_POST['numero_identidad']);

                            // Consultar la base de datos para obtener la información del usuario
                            $sql = "SELECT * FROM usuarios WHERE numero_identidad = '$numero_identidad'";
                            $result = $conn->query(query: $sql);

                            if ($result->num_rows > 0) {
                                // Si se encuentra un usuario, mostrar la información
                                $row = $result->fetch_assoc();


                                echo "<p><strong>Nombre Completo: </strong>" . $row['Nombre'] . "</p>";
                                echo "<p><strong>Apellidos Completos:</strong> " . $row['Apellidos'] . "</p>";
                                echo "<p><strong>Tipo de Documento:</strong> " . $row['Tipo_Documento'] . "</p>";
                                echo "<p><strong>Número de Identidad:</strong> " . $row['Numero_Identidad'] . "</p>";
                                echo "<p><strong>Fecha de Nacimiento:</strong> " . $row['Fecha_Nacimiento'] . "</p>";
                                echo "<p><strong>Número de Teléfono:</strong> " . $row['Telefono'] . "</p>";
                                echo "<p><strong>Correo Electrónico:</strong> " . $row['Correo'] . "</p>";

                            } else {
                                // Si no se encuentra el usuario, mostrar un mensaje
                                echo "<h2><strong>No se encontró ningún usuario con ese número de identidad</h2>";



                            }

                            // Cerrar la conexión a la base de datos
                            $conn->close();
                        }
                        ?>


                        <br><br>
                        <div><a href="modelo/actualizarUsuario.php" class="boton" role="button">Modificar</a>
                        </div>
                        <br><br>
                        <div><a href="registrarSeg.html" type="submit" class="boton" role="button">Registro Seguros</a>
                        </div>

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