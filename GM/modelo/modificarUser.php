<?php
// conexión a la base de datos
include('conexion.php');

$usuario = null;
$error = null;
// Buscar usuario por cédula
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Numero_Identidad'])) {
    $cedula = $_POST['Numero_Identidad'];

    // Consulta SQL para buscar usuario
    $query = "SELECT * FROM usuarios WHERE Numero_Identidad = $cedula";
    $stmt = $conn->prepare($query);

    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
    } else {
        $error = "No se encontraron resultados para la cédula ingresada.";
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
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Modificar Usuario</title>
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
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="/GM/js/validaciones.js"></script> <!-- Script para validación del formulario -->
    <script>
        // Función para cargar las ciudades dependiendo del departamento
        function cargarCiudades(departamentoId) {
            var ciudadSelect = document.getElementById("Ciudad");
            ciudadSelect.innerHTML = '<option selected disabled>Seleccione</option>'; // Limpiar opciones anteriores

            // Crear una nueva solicitud AJAX para obtener las ciudades basadas en el departamento
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'ciudades.php?departamento_id=' + departamentoId, true);
            xhr.onload = function () {
                if (xhr.status == 200) {
                    var ciudades = JSON.parse(xhr.responseText);
                    ciudades.forEach(function (ciudad) {
                        var option = document.createElement('option');
                        option.value = ciudad.Id_ciudad;
                        option.textContent = ciudad.Nombre;
                        ciudadSelect.appendChild(option);
                    });
                }
            };
            xhr.send();
        }
    </script>
</head>

<body>


    <header class="container-fluid">
        <div class="container flex justify-between">
            <center><img class="img-fluid" src="../img/logo2.jpg" alt="logo"></center>
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
                                <a class="nav-link" aria-current="page" href="../home.html">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="../cuenta.html">Cuenta</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Consultar Seguros
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../buscarTransporte.html">Transporte</a></li>
                                    <li><a class="dropdown-item" href="../vida.html">Vida</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Conctacto
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/nosotros.html">Acerca de Nosotros</a></li>
                                    <li><a class="dropdown-item" href="/servicios.html">Servicios</a></li>
                                    <li><a class="dropdown-item" href="../aliados.html">Aliados</a></li>
                                    <li><a class="dropdown-item" href="../correo.html">Contactanos</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../index.html">Salir</a>
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
                                        
                                        


                                        <br><br>
                                        <input type="submit" value="Guardar" id="guardar_cambios" name="guardar_cambios" class="boton" role="button"><br><br>
                                </form>
                            </section>
                        </article>
                        <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Responsive -->
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                            crossorigin="anonymous"></script>
                        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                        <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
                    </section>
                </center>

            </article>
        </main>
    <?php endif; ?>


    <br><br>
    <footer>
        <p>© 2024 GMK Seguros. Todos los derechos reservados.</p>
    </footer>
</body>

</html>