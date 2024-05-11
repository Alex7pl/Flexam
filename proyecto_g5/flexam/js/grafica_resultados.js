$(document).ready(function(){

    // Obtener el contexto del lienzo de la gráfica
    var ctx = document.getElementById('intentosChart').getContext('2d');

    // Realizar una solicitud AJAX para obtener los datos de los intentos del usuario en este test
    $.get("includes/Grafica.php?test_id=" + testId + "&user_id=" + userId, function(data, status){

        // Extraer los datos de la respuesta JSON

        var fechas = data.fechas;
        var notas = data.notas;

        // Crear la gráfica
        var intentosChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: fechas,
                datasets: [{
                    label: 'Notas',
                    data: notas,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Evolución de las notas en los intentos del test'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    })
})
