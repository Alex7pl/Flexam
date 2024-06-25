// Formateo de las preguntas con LaTeX y código
document.addEventListener('DOMContentLoaded', (event) => {
    hljs.highlightAll();
});

// Agrega un evento para detectar clics en enlaces
document.addEventListener("click", function(event) {
    // Añade una comprobación para excluir el botón de subir al principio de la página
    if (event.target.tagName === "A" && event.target.id !== "scrollToTopButton") {
        // Pregunta al usuario si desea realizar la acción
        var reiniciar = confirm("¿Deseas reiniciar el test desde cero?");
        if (reiniciar) {
            // Redirige al usuario al destino del enlace si es necesario
            var href = event.target.getAttribute("href");
            if (href) {
                window.location.href = href;
            }
        } else {
            // Cancela la navegación predeterminada si el usuario no desea reiniciar el test
            event.preventDefault();
        }
    }
});


function mostrarConfirmacion() {
    document.getElementById("sendTestPopUp").style.display = "flex";
}

function closePopup() {
    document.getElementById("sendTestPopUp").style.display = "none";
}

function enviarTest() {
    document.querySelector("form").submit();
}

// Permite desseleccionar las opciones una vez marcadas
document.addEventListener('DOMContentLoaded', function() {
    // Selecciona todos los input de tipo radio en el formulario
    const radios = document.querySelectorAll('input[type="radio"]');

    radios.forEach(radio => {
        radio.addEventListener('click', function() {
            // Verifica si el radio ya estaba marcado
            if (this.getAttribute('waschecked') === 'true') {
                this.checked = false;
                this.setAttribute('waschecked', 'false');
            } else {
                // Deselecciona cualquier otro radio marcado en el mismo grupo
                radios.forEach(el => {
                    if (el !== this && el.name === this.name) {
                        el.setAttribute('waschecked', 'false');
                    }
                });
                
                this.setAttribute('waschecked', 'true');
            }
        });
    });
});