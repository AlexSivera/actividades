<?php
/* ==========================
   salir.php
   Página que permite al usuario cerrar sesión de forma segura.
   ========================== */

// Inicia o reanuda la sesión para poder eliminarla correctamente.
session_start();

/* Destruye toda la información de la sesión actual,
   eliminando la variable 'autentificado' y cualquier otra variable de sesión.
   Esto asegura que el usuario ya no podrá acceder a páginas protegidas. */
session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Has salido</title>
</head>
<body>
    <h1>Gracias por tu visita</h1>

    <!-- Mensaje informativo al usuario -->
    <p>Has cerrado sesión correctamente.</p>

    <!-- Enlace para regresar al formulario de login -->
    <a href="index.php">Volver al formulario de autentificación</a>
</body>
</html>
