document.addEventListener("DOMContentLoaded", function() {
    // Esto asegura que todas las preguntas se manejen correctamente al cargar la página.
});

function agregarOpcion(preguntaDiv) {
    const opcionesDiv = preguntaDiv.querySelector(".opciones");
    const numeroOpciones = opcionesDiv.querySelectorAll(".opcion-container").length;
    const idPregunta = preguntaDiv.dataset.idPregunta;

    const opcionContainer = document.createElement("div");
    opcionContainer.className = "opcion-container";

    const nuevaOpcion = document.createElement("textarea");
    nuevaOpcion.setAttribute("name", `opciones[${numeroOpciones}][texto]`);
    nuevaOpcion.setAttribute("placeholder", "Opción " + (numeroOpciones + 1));
    nuevaOpcion.classList.add("textarea", "opcion-textarea");

    // Crear y configurar el botón de radio y su etiqueta
    const radioLabel = document.createElement("label");
    radioLabel.textContent = "Correcta";
    radioLabel.style.marginRight = "10px"; // Agrega algo de margen entre la etiqueta y el botón

    const radioBtn = document.createElement("input");
    radioBtn.type = "radio";
    radioBtn.name = `correcta[${idPregunta}]`; // Mismo name para todos los radio buttons de una pregunta
    radioBtn.value = numeroOpciones;

    // Añadir el botón de radio y la etiqueta al contenedor de la opción
    opcionContainer.appendChild(nuevaOpcion);
    opcionContainer.appendChild(radioLabel);
    opcionContainer.appendChild(radioBtn);
    opcionesDiv.appendChild(opcionContainer);
}

function guardarCambios(preguntaDiv, testId) {
    const preguntaId = preguntaDiv.dataset.idPregunta;
    const preguntaText = preguntaDiv.querySelector('.pregunta-textarea').value;
    const opcionesElements = preguntaDiv.querySelectorAll('.opcion-textarea');
    const opciones = Array.from(opcionesElements).map(op => ({ texto: op.value }));
    const correctaIndex = Array.from(preguntaDiv.querySelectorAll('input[type="radio"]')).findIndex(radio => radio.checked);

    // Añade el índice de la opción correcta al objeto de la opción
    if(correctaIndex >= 0) {
        opciones[correctaIndex].correcta = true;  // Marca solo la opción correcta
    }

    const formData = new FormData();
    formData.append('guardar', true);
    formData.append('id_pregunta', preguntaId);
    formData.append('pregunta_text', preguntaText);
    formData.append('opciones', JSON.stringify(opciones));

    fetch(`edit_questions.php?test_id=${testId}`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    then(data => {
        if(data.success) {
            preguntaDiv.remove();
            alert('Pregunta actualizada con éxito');
        } else {
            alert('Error al actualizar la pregunta');
        }
    })
    .catch(error => console.error('Error:', error)); 
}

function eliminarPregunta(preguntaDiv) {
    const idPregunta = preguntaDiv.dataset.idPregunta;
    if (confirm('¿Está seguro de que desea eliminar esta pregunta?')) {
        fetch(`edit_questions.php?action=delete&id_pregunta=${idPregunta}&test_id=${document.getElementById('testId').value}`, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                preguntaDiv.remove();
                alert('Pregunta eliminada con éxito');
            } else {
                alert('Error al eliminar la pregunta');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function confirmarEliminacion(idPregunta, testId) {
    if (confirm('¿Está seguro de que desea eliminar esta pregunta?')) {
        window.location.href = `edit_questions.php?action=delete&id_pregunta=${idPregunta}&test_id=${testId}`;
    }
}

function closePopup() {
    document.getElementById('deleteConfirmationPopup').style.display = 'none';
}
