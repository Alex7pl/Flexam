function validateForm() {
    let isValid = true;
    const errorContainers = {
        nombre: document.getElementById('error-nombre'),
        apellidos: document.getElementById('error-apellidos'),
        email: document.getElementById('error-email'),
        user: document.getElementById('error-user'),
        psw: document.getElementById('error-psw'),
        psw_confirm: document.getElementById('error-psw-confirm'),
        ID_universidad: document.getElementById('error-universidad'),
        ID_grado: document.getElementById('error-grado') 
    };

    Object.values(errorContainers).forEach(container => container.textContent = '');

    // Validaciones (ejemplo simple, puedes expandir según necesites)
    if (!document.getElementById('nombre').value.trim()) {
        errorContainers.nombre.textContent = 'El nombre es obligatorio.';
        isValid = false;
    }
    if (!document.getElementById('email').value.includes('@')) {
        errorContainers.email.textContent = 'El email no es válido.';
        isValid = false;
    }
    if (document.getElementById('psw').value !== document.getElementById('psw-confirm').value) {
        errorContainers.psw_confirm.textContent = 'Las contraseñas no coinciden.';
        isValid = false;
    }


    return isValid; 
}

function submitForm(event) {
    event.preventDefault(); // Evitar que el formulario se envíe automáticamente

    // Validación del formulario antes del envío
    if (!validateForm()) {
        return; // Si el formulario no es válido
    }

    var formData = new FormData(document.getElementById('signup-form'));

    fetch('logic/sign_up_logic.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect; // Redireccionar si es necesario
        } else {
            // Mostrar mensaje de error según el campo que tenga el error
            if (data.errors) {
                for (let field in data.errors) {
                    let errorContainer = document.getElementById('error-' + field);
                    if (errorContainer) {
                        errorContainer.textContent = data.errors[field];
                    }
                }
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
// Evento para manejar el cambio dinámico de universidades y cargar los grados
document.getElementById('universidad').addEventListener('change', function() {
    fetchGrados(this.value);
});

function fetchGrados(universidadId) {
    console.log(universidadId);
    if(universidadId) {
        fetch('logic/fetch_grados.php?universidad_id=' + universidadId)
        .then(response => response.json())
        .then(data => {
            var select = document.getElementById('grado');
            select.innerHTML = '<option value="">Seleccione un grado</option>';
            data.forEach(function(grado) {
                var option = new Option(grado.nombre, grado.ID_grado);
                select.add(option);
            });
        })
        .catch(error => console.error(error));
    }
}