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
    <base href="/GM/">
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
                                <a class="nav-link " aria-current="page" href=""></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href=""></a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Consultar Seguros
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="">Transporte</a></li>
                                    <li><a class="dropdown-item" href="">Vida</a></li>

                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Conctacto
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="">Acerca de Nosotros</a></li>
                                    <li><a class="dropdown-item" href="">Servicios</a></li>
                                    <li><a class="dropdown-item" href="">Aliados</a></li>
                                    <li><a class="dropdown-item" href="correo.html">Contactanos</a></li>
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
                    <article class="container flex justify-between">
                        <h2>Formulario de Registro</h2>
                        <br>
                        <section class=" flex justify-between border border-dark ">
                            <br><br>
                            <form id="registroForm" method="POST" action="editar_usuario.php"
                                onsubmit="return validarFormulario()">
                                <label for="usuario">Usuario:</label>
                                <input type="text" id="usuario" name="usuario" required
                                    placeholder="usuario de ingreso"><br><br>
                                <label for="nombre">Nombre:</label>
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
                                <!-- Campo de Fecha de Nacimiento -->
                                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br><br>
                                <label for="correo">Correo electrónico:</label>
                                <input type="email" id="correo" name="correo" required><br><br>
                                <!-- Campo de Número de Teléfono -->
                                <label for="telefono">Número de Teléfono:</label>
                                <input type="text" id="telefono" name="telefono" required><br><br>
                                <!-- Campo de Departamento -->
                                <label for="departamento">Departamento:</label>
                                <select id="departamento" name="departamento" onchange="cargarCiudades(this.value)"
                                    required>
                                    <option selected disabled>Seleccione</option>
                                    <!-- Estos datos se deben cargar dinámicamente desde la base de datos -->
                                    <option value="1">Antioquia</option>
                                    <option value="2">Cundinamarca</option>
                                    <option value="3">Valle del Cauca</option>
                                    <option value="4">Atlántico</option>
                                    <option value="5">Risaralda</option>
                                </select><br><br>
                                <!-- Campo de Ciudad -->
                                <label for="Ciudad">Ciudad:</label>
                                <select class="" aria-label="Default select example" name="Ciudad" id="Ciudad" required>
                                    <option selected disabled>Seleccione</option>
                                </select><br><br>
                                <label for="contrasena">Contraseña:</label>
                                <input type="password" id="contrasena" name="contrasena" required><br><br>
                                <label for="confirmar_contrasena">Confirmar contraseña:</label>
                                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena"
                                    required><br><br>
                                <!-- Campo de Perfil de Usuario -->
                                <label for="tipo_perfil">Perfil de Usuario:</label>
                                <select class="" aria-label="Default select example" name="tipo_perfil" id="tipo_perfil"
                                    required>
                                    <option selected disabled>Seleccione</option>
                                    <option value="01">Cliente</option>
                                    <option value="02">Proveedor</option>
                                    <option value="03">Usuario</option>
                                    <option value="04">Administrador</option>
                                </select><br><br>
                                <input type="submit" value="Registrar" class="boton" role="button"><br><br>
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

    <?php
    // conexión a la base de datos
    include('conexion.php');


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       
        $id_user = $_POST ['Id'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos']; // Nuevo campo de apellidos
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $numero_identidad = $_POST['numero_identidad']; // Número de identificación
        $correo = $_POST['correo'];
        $numero_telefono = $_POST['telefono']; // Número de teléfono
        
        $contrasena = $_POST['contrasena'];
        $contrasena2 = $_POST['contrasena2'];
        
        // Hashear la contraseña antes de almacenarla
        $contrasena_hash = password_hash( $contrasena,  PASSWORD_DEFAULT);


        // Verificar si la cedula ya existe
        $sql = "SELECT * FROM usuarios WHERE numero_identidad = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $numero_identidad);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
          //  echo '<script language="javascript">alert("El Documento ya está registrado, validar " );</script>';
            echo '
            <script>
                Swal.fire({
                    icon: "error",
                    title: "El Documento ya está registrado",
                    text: "Por favor, inténtalo de nuevo",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    window.location.href = "/GM/registrarUserExt.html"; // Redirige a la página de bienvenida
                });
            </script>';
        } else {

            // Verificar si el correo ya existe
            $sql = "SELECT * FROM usuarios WHERE correo = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $correo);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
               // echo '<script language="javascript">alert("El correo electrónico ya está registrado, volver a validar");</script>';
                echo '
                <script>
                    Swal.fire({
                        icon: "error",
                        title: "El correo electrónico ya está registrado",
                        text: "Por favor, inténtalo de nuevo",
                        confirmButtonText: "Aceptar"
                    }).then(() => {
                        window.location.href = "/GM/registrarUserExt.html"; // Redirige a la página de bienvenida
                    });
                </script>';
            } else {

                // Insertar el nuevo usuario, incluyendo todos los datos nuevos
                $sql = "UPDATE usuarios SET ( Id, nombre, apellidos, correo, contrasena, contrasena2, fecha_nacimiento,  telefono) 
       VALUES (?, ?, ?, ?, ?, ?, ?,?) WHERE numero_identidad = numero_identidad";
                $stmt = $conn->prepare(query: $sql);
                $stmt->bind_param("issssssss", $id_user, $usuario, $nombre, $apellidos, $correo, $contrasena_hash, $contrasena2, $fecha_nacimiento, $numero_telefono, );


                if ($stmt->execute()) {

                    //echo '<script language="javascript">alert("Usuario Registrado Exitosamente.");</script>';
    
                    echo '
                    <script>
                        Swal.fire({
                            icon: "success",
                            title: "Usuario Actualizado Exitosamente",
                            text: "Bienvenido, ' . htmlspecialchars($row['nombre']) . '",
                            confirmButtonText: "Aceptar"
                        }).then(() => {
                            window.location.href = "/GM/home.html"; // Redirige a la página de bienvenida
                        });
                    </script>';


                } else {
                    //echo '<script language="Error al registrar usuario: " );</script>';
    
                    echo '
        <script>
            Swal.fire({
                icon: "error",
                title: "Error al registrar usuario",
                text: "Por favor, inténtalo de nuevo",
                confirmButtonText: "Aceptar"
            }).then(() => {
                window.location.href = "/GM/registrarUser.html"; // Redirige de vuelta al formulario de login
            });
        </script>';

                    $stmt->error;
                }
            }
            $stmt->close();
        }
    }
    $conn->close();
    ?>


    <br><br>
    <footer>
        <p>© 2024 GMK Seguros. Todos los derechos reservados.</p>
    </footer>
</body>

</html>>