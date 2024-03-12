<?php

$servername = "localhost";
$username = "root";
$database = "flexam";

$conn = new mysqli($servername, $username, '', $database);

$nombre = $_POST['user'];
$contraseña = $_POST['password'];
$recuerdame = $_POST['recuerdame'];

$sql = "SELECT Usuario, Contraseña FROM usuarios WHERE Usuario LIKE '". $nombre. "'";
$consulta = $conn->query($sql);
$resultado = $consulta->fetch_assoc();

if(isset($resultado)){

    if($resultado['Contraseña'] == $contraseña){
        session_start();

        $_SESSION['user'] = $nombre;

        if($recuerdame == "si"){
            $_SESSION['rec'] = $recuerdame;
        }

        if($nombre == "admin"){
            header("Location: bandejaDeAdmin.php");
        }
        else{
            header("Location: bandejaDeEntrada.php?modo=recibidos");
        }
    }
    else{
        header("Location: login.php?error=errorContraseña");
    }
}
else{
    header("Location: login.php?error=errorUsuario");
}

// Cerrar conexión a la base de datos
$conn->close();

?>