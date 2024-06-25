$(document).ready(function(){

    var originalContent = $(".search").html();

    $(".searchBar").on("input", function(){
        var input = $(this).val();
        if(input !== ""){
            $.ajax({
                url: "includes/ClasificarTests.php",
                method: "POST",
                data: $.extend({input: input}, {user_menu: user_menu}, {asignatura: asignatura}),
                success: function(data){
                    $(".search").html(data);
                }
            });
        } else {
            // Si el valor del input está vacío, restablecer el div a su estado original
            $(".search").html(originalContent); // Esto limpia el contenido del div
            // Aquí puedes agregar cualquier otra acción necesaria para restablecer el estado original
        }
    });

    $(".options").change(function() {
        var selectedOption = $(this).val();
        
        if (selectedOption !== "") {

            if(user_menu) {
                var baseUrl = 'user_menu.php?asignatura=';
            }
            else{
                var baseUrl = 'menu_tests.php?asignatura=';
            }
            var redirectUrl = baseUrl + selectedOption;
            window.location.href = redirectUrl;
        }
      });
});