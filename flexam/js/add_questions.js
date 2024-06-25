document.addEventListener("DOMContentLoaded", function() {
    agregarPregunta(); // Agregar la primera pregunta al cargar la página
});

function agregarPregunta() {
    const container = document.getElementById("preguntas-container");
    const index = container.children.length;

    const preguntaDiv = document.createElement("div");
    preguntaDiv.className = "question-card";
    preguntaDiv.dataset.index = index;

    const eliminarBtnHTML = index > 0 ? `<button onclick="eliminarPregunta(this.parentNode);" class="btn btn-default eliminar-pregunta">-</button>` : '';

    preguntaDiv.innerHTML = `
        <div class="question-header">
            ${eliminarBtnHTML}
            <div class="question-number">${index + 1}</div>
            <textarea name="preguntas[${index}][texto]" placeholder="Escriba la pregunta" class="textarea pregunta-textarea"></textarea>
        </div>
        <div class="opciones"></div>
        <div class="button-container">
            <button onclick="agregarOpcion(this.parentNode.parentNode);" class="btn btn-primary">Añadir Opción</button>
            <button onclick="eliminarOpcion(this.parentNode.parentNode);" class="btn btn-default">Eliminar Opción</button>
        </div>
    `;
    container.appendChild(preguntaDiv);
    reindexarPreguntas();

    // Agrega las primeras dos opciones predeterminadas
    agregarOpcion(preguntaDiv);
    agregarOpcion(preguntaDiv);

    // Remueve el focus del botón plus
    document.querySelector('.plus-button').blur();
}

function agregarOpcion(preguntaDiv) {
    const opcionesDiv = preguntaDiv.querySelector(".opciones");
    const numeroOpciones = opcionesDiv.querySelectorAll(".opcion-container").length;
    const opcionContainer = document.createElement("div");
    opcionContainer.className = "opcion-container";

    const nuevaOpcion = document.createElement("textarea");
    nuevaOpcion.setAttribute("name", `opciones[${preguntaDiv.dataset.index}][${numeroOpciones}][texto]`);
    nuevaOpcion.setAttribute("placeholder", "Opción " + (numeroOpciones + 1));
    nuevaOpcion.classList.add("textarea", "opcion-textarea");

    const labelRadio = document.createElement("label");
    labelRadio.textContent = "Correcta ";
    labelRadio.classList.add("radio-label");

    const radioBtn = document.createElement("input");
    radioBtn.type = "radio";
    radioBtn.name = `correcta[${preguntaDiv.dataset.index}]`;
    radioBtn.value = numeroOpciones;
    labelRadio.appendChild(radioBtn);

    opcionContainer.appendChild(nuevaOpcion);
    opcionContainer.appendChild(labelRadio);
    opcionesDiv.appendChild(opcionContainer);
}

function eliminarPregunta(preguntaDiv) {
    const container = preguntaDiv.parentNode;
    container.remove(preguntaDiv);
    reindexarPreguntas(); // Reindexa las preguntas después de eliminar una
    if (container.children.length === 1) { // Asegura que siempre hay al menos una pregunta
        container.querySelector('.eliminar-pregunta').style.visibility = 'hidden';
    }
}

function reindexarPreguntas() {
    const preguntas = document.querySelectorAll('.question-card');
    preguntas.forEach((pregunta, index) => {
        pregunta.dataset.index = index;
        pregunta.querySelector('.question-number').textContent = index + 1;
        pregunta.querySelectorAll('textarea').forEach(textarea => {
            const name = textarea.name.split('[')[0];
            const optIndex = textarea.name.match(/\[(\d+)\]/)[1];
            textarea.name = `${name}[${index}][${optIndex}]`;
        });
        const eliminarBtn = pregunta.querySelector('.eliminar-pregunta');
        if (eliminarBtn) {
            eliminarBtn.style.visibility = index === 0 ? 'hidden' : 'visible';
        }
    });
}

function eliminarOpcion(preguntaDiv) {
    const opcionesDiv = preguntaDiv.querySelector(".opciones");
    if (opcionesDiv.children.length > 2) {
        opcionesDiv.removeChild(opcionesDiv.lastChild);
    } else {
        alert("Debe haber al menos dos opciones.");
    }
}

function enviarPreguntas() {
    const preguntasDivs = document.querySelectorAll('.question-card');
    const preguntas = [];

    preguntasDivs.forEach((div, index) => {
        const preguntaText = div.querySelector('textarea[name^="preguntas"]').value.trim();
        if (!preguntaText) {
            alert('Por favor, complete todas las preguntas antes de enviar.');
            return;
        }
        const opciones = Array.from(div.querySelectorAll('.opcion-container'))
                              .map(container => ({
                                  texto: container.querySelector('textarea').value.trim(),
                                  correcta: container.querySelector('input[type="radio"]').checked
                              }))
                              .filter(opcion => opcion.texto !== '');
        preguntas.push({ pregunta: preguntaText, opciones: opciones });
    });

    if (preguntas.length === 0) {
        alert('Debe agregar al menos una pregunta.');
        return;
    }

    fetch('includes/AddQuestions.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ preguntas: preguntas })
    })
    .then(response => response.text())
    .then(data => {
        window.location.href = 'test_created.php';
    })
    .catch(error => console.error('Error al guardar preguntas:', error));
}

