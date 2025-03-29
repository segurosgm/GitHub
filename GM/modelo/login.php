<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Sesion</title>
    <!-- CSS -->
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

    <base href="/Github/GM/">

</head>

<body>
    <br>
    <header class="container justify-between">
        <center>
            <div class="container flex justify-between">
                <img class="img-fluid" src="/Github/GM/img/logo2.jpg" alt="logo GMK Seguros Especialistas en Riesgos y 
                Seguros">
                <!-- class="img-fluid" es el responsive desde boostrap -->
            </div>
            <br>
            <h2>INICIO DE SESION</h2>
            </div>
        </center>
    </header>
    <main>
        <article>
            <center>
                <section class="container flex justify-between">
                    <form action="modelo/login.php" method="POST">
                        <br>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>
                        <label for="usuario">Usuario:</label>
                        <input type="text" placeholder="Usuario" id="usuario" name="usuario" required>
                        <br>
                        <br>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-key" viewBox="0 0 16 16">
                            <path
                                d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8m4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5" />
                            <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                        </svg>
                        <label for="contrasena">Contraseña:</label>
                        <input type="password" id="contrasena" name="contrasena" required placeholder="Contraseña">
                        <br><br>

                        <div class="flex justify-center space-x-2 mt-4">
                            <input type="submit" class="boton" value="Ingresar" role="button" style="margin: 20px">
                            <a href="index.html" class="boton" role="button" style="margin-left: 20px">
                                Volver
                            </a>
                        </div>

                        <br><br>
                    </form>
            </center>
        </article>

        <?php
        // conexión a la base de datos
        include('conexion.php');

        // Verifica si se ha enviado el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = $_POST['usuario'];
            $contrasena = $_POST['Contrasena'];

            // Prepara la consulta para evitar inyecciones SQL
            $sql = "SELECT * FROM usuarios WHERE usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verifica si el usuario existe
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Verifica la contraseña
                if (password_verify($contrasena, $row['Contrasena'])) {

                    // Muestra un mensaje de éxito usando SweetAlert
                    echo '
    <script>
        Swal.fire({
            icon: "success",
            title: "Inicio de sesión exitoso",
            text: "Bienvenido",
            confirmButtonText: "Aceptar"
        }).then(() => {
            window.location.href = "Home.html"; 
        });
    </script>';    
                } else {
 // Mensaje en caso de que la contraseña sea incorrecta 
                    echo '
        <script>
            Swal.fire({
                icon: "error",
                title: "Contraseña incorrecta",
                text: "Por favor, inténtalo de nuevo",
                confirmButtonText: "Aceptar"
            }).then(() => {
                window.location.href = "/GM/sesion.html"; // Redirige de vuelta al formulario de login
            });
        </script>';
                }
            } else {

                // Mensaje en caso de que el usuario no exista
                echo '
    <script>
        Swal.fire({
            icon: "error",
            title: "Usuario no encontrado",
            text: "Por favor, verifica tus credenciales",
            confirmButtonText: "Aceptar"
        }).then(() => {
            window.location.href = "/GM/sesion.html"; // Redirige de vuelta al formulario de login
        });
    </script>';


            }

            // Cierra la conexión
            $stmt->close();
            $conn->close();
        }
        ?>

    </main>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


</body>
<script src="js/validaciones.js"></script>

</html>