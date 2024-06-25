<?php
    session_start();

    unset($_SESSION['loggedin']);
    unset($_SESSION['user']);
    unset($_SESSION["ID_usuario"]);

    session_destroy();
    header('Location: ../index.php');
?>