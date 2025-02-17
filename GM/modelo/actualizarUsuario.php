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
                                <a class="nav-link active" aria-current="page" href="../home.html">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../cuenta.html">Cuenta</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Consultar Seguros
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../transporte.html">Transporte</a></li>
                                    <li><a class="dropdown-item" href="../vida.html">Vida</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Conctacto
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../nosotros.html">Acerca de Nosotros</a></li>
                                    <li><a class="dropdown-item" href="../servicios.html">Servicios</a></li>
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
   


    <br><br>
    <footer>
        <p>© 2024 GMK Seguros. Todos los derechos reservados.</p>
    </footer>
</body>

</html>


<?php
// Incluir el archivo de conexión
include('conexion.php');


// Verificar si los datos fueron enviados por el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario

    
    if (isset($_POST['id']))
    $id = $_POST['id'];
   
 
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
  

   
    // Preparar la sentencia SQL para actualizar los datos
    $sql = "UPDATE usuarios SET nombre=?, apellidos=?, fecha_nacimiento=?, correo=?, telefono=? WHERE Id=?";
    if ($stmt = $conn->prepare($sql)) {
        // Vincular los parámetros
        $stmt->bind_param("sssssi", $nombre, $apellidos, $fecha_nacimiento, $correo, $telefono,  $id);

      

        // Ejecutar la consulta
    
        
            if ($stmt->execute()) {

                // <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>echo '<script language="javascript">alert("Usuario Registrado Exitosamente.");</script>';

                echo '
                <script>
                    Swal.fire({
                        icon: "success",
                        title: "Usuario Actualizado Exitosamente",
                        text: "Bienvenido, ' . htmlspecialchars($row['nombre']) . '",
                        confirmButtonText: "Aceptar"
                    }).then(() => {
                        window.location.href = "../home.html"; // Redirige a la página de bienvenida
                    });
                </script>';
        
            
        } else {
           // echo "Error al actualizar el usuario: " . $stmt->error;

            echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: "danger",
                     title: "Error al actualizar el usuario:",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    window.location.href = "../home.html"; // Redirige a la página de bienvenida
                });
            </script>';
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>


