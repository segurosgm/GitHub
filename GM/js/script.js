/*document.addEventListener("DOMContentLoaded", function() {
    const aseguradoraSelect = document.getElementById("Nombre_Aseguradora");

    fetch("modelo/obtener_aseguradoras.php")
        .then(response => response.json())
        .then(data => {
            data.forEach(aseguradora => {
                const option = document.createElement("option");
                option.value = aseguradora.Id_Aseguradora;
                option.textContent = aseguradora.Nombre_Aseguradora;
                aseguradoraSelect.appendChild(option);
            });
        })
        .catch(error => console.error("Error al cargar aseguradoras:", error));
});


document.getElementById("searchForm").addEventListener("submit", function(event) {
    var numeroIdentidad = document.getElementById("numero_identidad").value;
    if (!numeroIdentidad) {
        alert("Por favor ingrese un número de identidad.");
        event.preventDefault(); // Evita que el formulario se envíe si el campo está vacío
    }
});




function toggleVehiculoFields() {
    var tipoSeguro = document.getElementById("tipo_seguro").value; // Obtener el tipo de seguro seleccionado
    var tipoVehiculoDiv = document.getElementById("tipo_vehiculo_div"); // Contenedor del tipo de vehículo
    var placaDiv = document.getElementById("placa_div"); // Contenedor de la matrícula vehículo
    var marca = document.getElementById("marca_div"); 

    // Si el tipo de seguro es "Transporte", habilitamos los campos de vehículo
    if (tipoSeguro === "Transporte") {
        tipoVehiculoDiv.style.display = "block"; // Muestra el contenedor del tipo de vehículo
        placaDiv.style.display = "block"; // Muestra el contenedor de matrícula vehículo
        marca.style.display = "block";

    } else {
        tipoVehiculoDiv.style.display = "none"; // Oculta el contenedor del tipo de vehículo
        placaDiv.style.display = "none"; // Oculta el contenedor de matrícula vehículo
        marca.style.display = "none";
        
    }
}



function validarFormulario() {
    var contrasena = document.getElementById("contrasena").value;
    var confirmarContrasena = document.getElementById("confirmar_contrasena").value;

    if (contrasena !== confirmarContrasena) {
        alert("Las contraseñas no coinciden.");
        return false; // Evita el envío del formulario
    }
    
    return true; 
}


document.addEventListener("DOMContentLoaded", function() {
    const aseguradoraSelect = document.getElementById("Nombre_Aseguradora");

    fetch("/GM/modelo/obtenerAseguradoras.php")
        .then(response => response.json())
        .then(data => {
            data.forEach(aseguradora => {
                const option = document.createElement("option");
                option.value = aseguradora.Id_Aseguradora;
                option.textContent = aseguradora.Nombre_Aseguradora;
                aseguradoraSelect.appendChild(option);
            });
        })
        .catch(error => console.error("Error al cargar aseguradoras:", error));
});

// Función para habilitar o deshabilitar los campos según el tipo de seguro
function toggleVehiculoFields() {
    var tipoSeguro = document.getElementById("Id_tipoPoliza").value; // Obtener el tipo de seguro seleccionado
    var tipoVehiculoDiv = document.getElementById("TipoVehiculo"); // Contenedor del tipo de vehículo
    var placaDiv = document.getElementById("Placa"); // Contenedor de la matrícula vehículo
    var marca = document.getElementById("Marca"); 

    // Si el tipo de seguro es "Transporte", habilitamos los campos de vehículo
    if (tipoSeguro === "Transporte") {
        tipoVehiculoDiv.style.display = "block"; // Muestra el contenedor del tipo de vehículo
        placaDiv.style.display = "block"; // Muestra el contenedor de matrícula vehículo
        marca.style.display = "block";

    } else {
        tipoVehiculoDiv.style.display = "none"; // Oculta el contenedor del tipo de vehículo
        placaDiv.style.display = "none"; // Oculta el contenedor de matrícula vehículo
        marca.style.display = "none;"
        
    }
}

// Aquí puedes agregar validaciones antes de enviar el formulario
document.querySelector('form').addEventListener('submit', function(event) {
    var usuario = document.getElementById('usuario').value;
    var contrasena = document.getElementById('contrasena').value;

    if (usuario === '' || contrasena === '') {
        alert('Por favor, completa todos los campos.');
        event.preventDefault();
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const aseguradoraSelect = document.getElementById("Nombre_Aseguradora");

    fetch("/GM/modelo/obtenerAseguradoras.php")
        .then(response => response.json())
        .then(data => {
            data.forEach(aseguradora => {
                const option = document.createElement("option");
                option.value = aseguradora.Id_Aseguradora;
                option.textContent = aseguradora.Nombre_Aseguradora;
                aseguradoraSelect.appendChild(option);
            });
        })
        .catch(error => console.error("Error al cargar aseguradoras:", error));
});
*/


function validarFormulario() {
    var contrasena = document.getElementById("contrasena").value;
    var confirmarContrasena = document.getElementById("confirmar_contrasena").value;

    if (contrasena !== confirmarContrasena) {
        alert("Las contraseñas no coinciden.");
        return false; // Evita el envío del formulario
    }
    
    return true; 
}




// Función para habilitar o deshabilitar los campos según el tipo de seguro
function toggleVehiculoFields() {
    var tipoSeguro = document.getElementById("Id_tipoPoliza").value; // Obtener el tipo de seguro seleccionado
    var tipoVehiculoDiv = document.getElementById("TipoVehiculo"); // Contenedor del tipo de vehículo
    var placaDiv = document.getElementById("Placa"); // Contenedor de la matrícula vehículo
    var marca = document.getElementById("Marca"); 

    // Si el tipo de seguro es "Transporte", habilitamos los campos de vehículo
    if (tipoSeguro === "Transporte") {
        tipoVehiculoDiv.style.display = "block"; // Muestra el contenedor del tipo de vehículo
        placaDiv.style.display = "block"; // Muestra el contenedor de matrícula vehículo
        marca.style.display = "block";

    } else {
        tipoVehiculoDiv.style.display = "none"; // Oculta el contenedor del tipo de vehículo
        placaDiv.style.display = "none"; // Oculta el contenedor de matrícula vehículo
        marca.style.display = "none;"
        
    }
}

// Aquí puedes agregar validaciones antes de enviar el formulario
document.querySelector('form').addEventListener('submit', function(event) {
    var usuario = document.getElementById('usuario').value;
    var contrasena = document.getElementById('contrasena').value;

    if (usuario === '' || contrasena === '') {
        alert('Por favor, completa todos los campos.');
        event.preventDefault();
    }
});



