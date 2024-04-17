<!DOCTYPE html>
<html>
<head>
    <title>Flexam - Plataforma de Tests Universitarios</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet"> 
</head>
<body>
    <header>
        <div class="header-container">
            <a href="index.php">
                <img src="resources/imagenes/logo_sombra.png" alt="FLEXAM logo" class="logo">
            </a>
            <div class="separator"></div>
            <nav>
                <ul>
                    <li><a href="aboutus.php">Sobre Nosotros</a></li>
                    <li><a href="info.php">Info</a></li>
                    <li><a href="menu_tests.php">Tests</a></li>
                    <?php
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }                        
                        if(isset($_SESSION['loggedin'])) {
                            // El usuario está registrado, mostramos su nombre
                            echo '<li><a href="user_menu.php">'. $_SESSION['user'] .'</a></li>';

                            // Mostramos un enlace para cerrar sesión
                            echo '<li><a href="logic/logout.php">Salir</a></li>';
                        } else {
                            // El usuario no está registrado, mostramos un enlace al login
                            echo '<li><a href="login.php">Login</a></li>';
                        }
                    ?>
                </ul>
            </nav>
        </div>
    </header>
</body>
</html>
