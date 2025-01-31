document.addEventListener("DOMContentLoaded", function() {
    // Cargar aseguradoras dinámicamente
    const aseguradoraSelect = document.getElementById("Nombre_Aseguradora");
    
    fetch("modelo/obtenerAseguradoras.php")
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

    // Calendario
    $("#fecha_vencimiento").datepicker({
        showOn: "button",
        buttonImage: "img/calendario.jpg",
        buttonImageOnly: true,
        buttonText: "Select date",
        changeMonth: true,
        changeYear: true,
    });
});

// Función para mostrar u ocultar los campos según el tipo de seguro
function toggleVehiculoFields() {
    const tipoSeguro = document.getElementById("tipo_seguro").value;
    const tipoVehiculoDiv = document.getElementById("tipo_vehiculo_div");
    const placaDiv = document.getElementById("placa_div");
    const marcaDiv = document.getElementById("marca_div");

    if (tipoSeguro === "Transporte") {
        tipoVehiculoDiv.style.display = "block";
        placaDiv.style.display = "block";
        marcaDiv.style.display = "block";
    } else {
        tipoVehiculoDiv.style.display = "none";
        placaDiv.style.display = "none";
        marcaDiv.style.display = "none";
    }
}
