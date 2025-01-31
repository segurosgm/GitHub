<?php
// Conexión a la base de datos
 include ('conexion.php');


$usuario = null;
$error = null;

// Buscar usuario por cédula
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];

    // Consulta SQL para buscar usuario
    $sql = "SELECT * FROM usuarios WHERE numero_identidad = $cedula";
    $stmt = $conn->prepare($sql);
    
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        $error = "No se encontraron resultados para la cédula ingresada.";
    }

    $stmt->close();
}





// Guardar cambios si el formulario de edición es enviado
if (isset($_POST['guardar_cambios'])) {
    $numero_identidad = $_POST['numero_identidad'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $id_user = $_POST['Id'] ?? '';
    

    // Consulta SQL para actualizar los datos
    $sql = "UPDATE usuarios SET nombre = ?, apellidos = ?, correo = ?, telefono = ? WHERE numero_identidad = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombre, $apellidos, $correo, $telefono, $id_user);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Datos actualizados correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar los datos: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Editar Usuario</title>
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

                <h2>Buscar y Editar Usuario</h2><br><br>
        <form method="POST">
            <div class="mb-3">
                <label for="cedula" class="form-label">Número de Identidad:</label>
                <input type="text" id="cedula" name="cedula" placeholder="Ingrese la cédula del usuario" required>
            </div>
            <button type="submit" class="boton" role="button">Buscar</button> <br><br>
        </form>
                    <br>
                    <section class=" flex justify-between border border-dark ">
                        <br><br>




    <div class="container mt-5">
       

        <?php if ($error): ?>
            <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ( $usuario): ?>
            <h3 >Información del Usuario</h3>
            <form method="POST">
                <br><br>
                <div>
                <?php    echo "<p><strong>Numero Identidad: </strong>" . $usuario['Numero_Identidad'] . "</p>";?>
                </div>
           <br>
           <div class="flex justify-between">
                    <label for="nombre" class="form-label">Nombres:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php  echo  $usuario['Nombre'];?>" required>
                    <br><br>
              
                
                    <label for="apellidos" class="form-label">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" value="<?php echo $usuario['Apellidos'] ?? ''; ?>" required>
                    <br><br>

                
                    <label for="correo" class="form-label">Correo Electrónico:</label>
                    <input type="email"  id="correo" name="correo" value="<?php echo $usuario['Correo'] ?? ''; ?>" required>
                    <br><br>

                
                    <label for="telefono" class="form-label">Teléfono:</label>
                    <input type="text"  id="telefono" name="telefono" value="<?php echo $usuario['Telefono'] ?? ''; ?>" required>
                    <br><br>
                </div>
                
            </form>
        <?php endif; ?>
    </div>
  
    <br><br>
                        <div><a href="registrarUser.html" class="boton" role="button">Modificar</a>
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
