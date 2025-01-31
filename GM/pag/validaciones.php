<?php
// Función para validar los datos del formulario de registro de evento
function validarFormularioEvento($nombreEvento, $descripcionEvento, $fechaEvento, $horaEvento, $ubicacionEvento) {
    // Validamos que todos los campos estén completos
    if (empty($nombreEvento) || empty($descripcionEvento) || empty($fechaEvento) || empty($horaEvento) || empty($ubicacionEvento)) {
        return false; // Si algún campo está vacío
    }
    return true; // Si todos los campos están completos
}

// Función para enviar el correo con los datos del evento
function enviarCorreoEvento($nombreEvento, $descripcionEvento, $fechaEvento, $horaEvento, $ubicacionEvento) {
    $message = "Detalles del Evento:\r\n";
    $message .= "Nombre del Evento: " . $nombreEvento . "\r\n";
    $message .= "Descripción: " . $descripcionEvento . "\r\n";
    $message .= "Fecha: " . $fechaEvento . "\r\n";
    $message .= "Hora: " . $horaEvento . "\r\n";
    $message .= "Ubicación: " . $ubicacionEvento . "\r\n";
    $message .= "Enviado el: " . date('d/m/Y', time());

    $para = 'codeworkgreengreen@gmail.com';
    $asunto = 'Nuevo Registro de Evento';

    // Enviar el correo
    if (mail($para, $asunto, utf8_decode($message))) {
        header(header: "Location:contactanos.html");
        exit;
    } else {
        return false;  // Si ocurrió un error
    }
}

// Función para validar el formulario de contacto (comentario)
function validarFormularioComentario($comentario) {
    if (empty($comentario)) {
        return false; // Si el campo del comentario está vacío
    }
    return true; // Si el comentario no está vacío
}

// Función para enviar el comentario al correo
function enviarComentario($comentario) {
    $message = "Comentario recibido:\r\n";
    $message .= "Comentario: " . $comentario . "\r\n";
    $message .= "Enviado el: " . date('d/m/Y', time());

    $para = 'codeworkgreengreen@gmail.com';
    $asunto = 'Nuevo Comentario';

    // Enviar el correo
    if (mail($para, $asunto, utf8_decode($message))) {
        return true;  // Si el correo fue enviado con éxito
    } else {
        return false;  // Si ocurrió un error
    }
}

// Función para procesar el formulario de registro de evento
function procesarFormularioEvento() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recoger los datos del formulario de registro de evento
        $nombreEvento = $_POST['nombreEvento'];
        $descripcionEvento = $_POST['descripcionEvento'];
        $fechaEvento = $_POST['fechaEvento'];
        $horaEvento = $_POST['horaEvento'];
        $ubicacionEvento = $_POST['ubicacionEvento'];

        // Validar el formulario
        if (validarFormularioEvento($nombreEvento, $descripcionEvento, $fechaEvento, $horaEvento, $ubicacionEvento)) {
            // Enviar los detalles del evento al correo
            if (enviarCorreoEvento($nombreEvento, $descripcionEvento, $fechaEvento, $horaEvento, $ubicacionEvento)) {
                echo "¡Evento registrado con éxito!";
                // Redirigir o hacer algo después de enviar el correo
                header("Location: eventos.html");
                exit();
            } else {
                echo "Hubo un error al enviar el correo del evento. Inténtalo nuevamente.";
            }
        } else {
            echo "Por favor, completa todos los campos del evento.";
        }
    }
}

// Función para procesar el formulario de comentario
function procesarComentario() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recoger el comentario del formulario
        $comentario = $_POST['comment'];

        // Validar el formulario de comentario
        if (validarFormularioComentario($comentario)) {
            // Enviar el comentario al correo
            if (enviarComentario($comentario)) {
                echo "¡Comentario enviado con éxito!";
                // Redirigir o hacer algo después de enviar el comentario
                header("Location: comentarios.html");
                exit();
            } else {
                echo "Hubo un error al enviar el comentario. Inténtalo nuevamente.";
            }
        } else {
            echo "Por favor, escribe un comentario.";
        }
    }
}

// Llamar a las funciones de procesamiento según el formulario que se haya enviado
if (isset($_POST['nombreEvento'])) {
    procesarFormularioEvento(); // Si es el formulario de registro de evento
}

if (isset($_POST['comment'])) {
    procesarComentario(); // Si es el formulario de comentario
}
?>
