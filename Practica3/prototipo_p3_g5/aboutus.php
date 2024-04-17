<?php include 'includes/comun/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sobre Nosotros | Flexam</title>
</head>
<body>
    <?php include 'includes/comun/header.php'; ?>
    <div class="container">

        <h2>Sobre Nosotros</h2>

        <div class="cards-wrapper">
            <!-- Pani -->
            <div class="card-container reverse" id="AlejandroPaniagua">
                <div class="image">
                    <img src="<?php echo BASE_URL; ?>resources/imagenes/pani_cut.png" alt="Profesor Pani">
                </div>
                <div class="text">
                    <strong class="mytitle">Alejandro Paniagua</strong>
                    <p class="email">Email: alejpani@ucm.es</p>
                    <p class="description">Fanático del ajedrez, la programación en Python y la astronomía. Siempre curioso por aprender más sobre el universo y la inteligencia artificial.</p>
                    <a href="mailto:alejpani@ucm.es" class="buttonT">Enviar Correo</a>
                </div>
            </div>

            <!-- Dani -->
            <div class="card-container" id="DanielGarcia">
                <div class="image">
                    <img src="resources/imagenes/dani.png" alt="Profesor Dani">
                </div>
                <div class="text">
                    <strong class="mytitle">Daniel García</strong>
                    <p class="email">Email:dgarci27@ucm.es</p>
                    <p class="description">Apasionado por los deportes de todo tipo, la programación y las series. Siempre en busca de aventuras y desafíos.</p>
                    <a href="mailto:dgarci27@ucm.es" target="_blank" class="buttonT">Enviar Correo</a>
                </div>
            </div>

            <!-- Martin -->
            <div class="card-container reverse" id="MartinVeselinov">
                <div class="image">
                    <img src="<?php echo BASE_URL; ?>resources/imagenes/martin.png" alt="Profesor Martin">
                </div>
                <div class="text">
                    <strong class="mytitle">Martin Veselinov</strong>
                    <p class="email">Email: amrtives@ucm.es</p>
                    <p class="description">Entusiasta de la moda, la música y los buenos planes. Tiene además una lista infinita de restaurantes en los que disfrutar.</p>
                    <a href="mailto:amrtives@ucm.es" class="buttonT">Enviar Correo</a>
                </div>
            </div>

            <!-- Alex -->
            <div class="card-container" id="AlejandroDeMateo">
                <div class="image">
                    <img src="resources/imagenes/alex.png" alt="Profesor Alex">
                </div>
                <div class="text">
                    <strong class="mytitle">Alejandro de Mateo</strong>
                    <p class="email">Email: ademateo@ucm.es</p>
                    <p class="description">Aficionado al fútbol, los videojuegos de estrategia y la cocina italiana. Nunca deja de buscar nuevos sabores y experiencias.</p>
                    <a href="mailto:ademateo@ucm.es" class="buttonT">Enviar Correo</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/comun/footer.php'; ?>
</body>
</html>