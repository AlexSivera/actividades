<?php
session_start();

// COMPRUEBA QUE EL USUARIO ESTÉ AUTENTIFICADO
if ($_SESSION["autentificado"] != "SI") {
    // Si no existe, envía a la página de autentificación
    header("Location: index.php");
    // Además sale del script
    exit();
}
?>