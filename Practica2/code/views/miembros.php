<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <title>Miembros Flexam</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        .cards-wrapper {
            display: flex;
            flex-wrap: wrap; 
            justify-content: space-evenly; 
            align-items: flex-start; 
            gap: 20px; 
        }

        #cont{
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .card-container {
            flex: 1 1 300px; 
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: stretch;
            max-width: calc(50% - 20px);
            box-sizing: border-box;
            width:  100%;
            height: 100%;
            border: 4px solid;
            border-color: #7305D5;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 0px 10px 1px rgba(0,0,0,0.2);
            margin-top: 20px;
            margin-bottom:20px;
            flex-basis: calc(50% - 20px);
            margin: 10px;
        }

        .mytitle, .email, .description {
            margin: 5px 0;
            text-align: center;
        }

        .email{
            font-style: italic;
            margin-bottom: -5px;
        }

        .highlight {
            color:  #7305D5;
        }

        .card-container.reverse {
            flex-direction: row-reverse;
        }

        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 15px;
        }

        .card-button {
            padding: 8px 16px;
            border: 2px solid;
            border-color: #7305D5;
            background-color: transparent;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .card-button:hover {
            background-color: #7305D5;
            color: white;
        }

        .text {
            flex: 0 0 60%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 20px;
            background-color: #151515;
        }

        .text, .text p, .text strong {
            color: white;
        }

        .image {
            flex: 0 0 40%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #151515;
        }

        .image img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
      
        .members-list {
            display: flex;
            flex-direction: row;
            justify-content: center;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
            width: 100%;
            gap: 10px;
            margin-bottom: 20px;
        }

        .list-item {
            margin: 5px;    
        }

        .list-link {
            padding: 8px 16px;
            border: 2px solid #7305D5;
            background-color: #151515;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            display: block;
        }

        .list-link:hover {
            background-color: #7305D5;
            color: white;
        }
    </style>
</head>
<body>
    <?php include '../comun/header.php'; ?>
    <div id="cont">
        <!-- Listado de nombres -->
        <ul class="members-list">
            <li><a href="#AlejandroPaniagua" class="list-link">Alejandro Paniagua</a></li>
            <li><a href="#DanielGarcia" class="list-link">Daniel García</a></li>
            <li><a href="#MartinVeselinov" class="list-link">Martin Veselinov</a></li>
            <li><a href="#AlejandroDeMateo" class="list-link">Alejandro de Mateo</a></li>
        </ul>

        </div>

        <div class="cards-wrapper">
            <!-- Pani -->
            <div class="card-container reverse" id="AlejandroPaniagua">
                <div class="image">
                    <img src="../../resources/imagenes/pani_cut.png" alt="Profesor Pani">
                </div>
                <div class="text">
                    <strong class="mytitle">Alejandro Paniagua</strong>
                    <p class="email">Email: alejpani@ucm.es</p>
                    <p class="description">Fanático del ajedrez, la programación en Python y la astronomía. Siempre curioso por aprender más sobre el universo y la inteligencia artificial.</p>
                    <a href="mailto: alejpani@ucm.es" class="card-button">Enviar Correo</a>
                </div>
            </div>

            <!-- Dani -->
            <div class="card-container" id="DanielGarcia">
                <div class="image">
                    <img src="../../resources/imagenes/dani.png" alt="Profesor Dani">
                </div>
                <div class="text">
                    <strong class="mytitle">Daniel García</strong>
                    <p class="email">Email:dgarci27@ucm.es</p>
                    <p class="description">Apasionado por los deportes de todo tipo, la programación y las series. Siempre en busca de aventuras y desafíos.</p>
                    <a href="mailto: dgarci27@ucm.es" target="_blank" class="card-button">Enviar Correo</a>
                </div>
            </div>

            <!-- Martin -->
            <div class="card-container reverse" id="MartinVeselinov">
                <div class="image">
                    <img src="../../resources/imagenes/martin.png" alt="Profesor Martin">
                </div>
                <div class="text">
                    <strong class="mytitle">Martin Veselinov</strong>
                    <p class="email">Email: amrtives@ucm.es</p>
                    <p class="description">Entusiasta de la moda, la música y los buenos planes. Tiene además una lista infinita de restaurantes en los que disfrutar.</p>
                    <a href="mailto: martives@ucm.es" class="card-button">Enviar Correo</a>
                </div>
            </div>

            <!-- Alex -->
            <div class="card-container" id="AlejandroDeMateo">
                <div class="image">
                    <img src="../../resources/imagenes/alex.png" alt="Profesor Alex">
                </div>
                <div class="text">
                    <strong class="mytitle">Alejandro de Mateo</strong>
                    <p class="email">Email: ademateo@ucm.es</p>
                    <p class="description">Aficionado al fútbol, los videojuegos de estrategia y la cocina italiana. Nunca deja de buscar nuevos sabores y experiencias.</p>
                    <a href="mailto: ademateo@ucm.es" class="card-button">Enviar Correo</a>
                </div>
            </div>
        </div>
    </div>

    <?php include '../comun/footer.php'; ?>
</body>
</html>
