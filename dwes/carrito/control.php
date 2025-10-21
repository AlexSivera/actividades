<?php
session_start();

// Verificar credenciales (usuario: miguel, contraseña: qwerty)
if ($_POST["usuario"] == "miguel" && $_POST["contrasena"] == "qwerty") {
    // Credenciales válidas
    $_SESSION["autentificado"] = "SI";
    header("Location: aplicacion.php");
} else {
    // Credenciales inválidas
    header("Location: index.php?errorusuario=si");
}
exit();
?>