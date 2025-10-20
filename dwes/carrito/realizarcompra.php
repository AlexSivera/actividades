<?php
/* ==========================
   realizarcompra.php
   Página que finaliza la compra y vacía el carrito del usuario.
   ==========================/*

/* Incluye el archivo de seguridad para asegurar que solo usuarios autenticados
   puedan finalizar la compra.*/
include("seguridad.php");

/*Borra la cookie 'carrito' estableciendo su tiempo de expiración en el pasado.
   Esto elimina todos los productos del carrito del usuario.*/
setcookie("carrito", "", time() - 3600);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra realizada</title>
</head>
<body>
    <h1>Gracias por su compra</h1>

    <!-- Mensaje informativo al usuario -->
    <p>Su carrito se ha vaciado correctamente.</p>

    <!-- Enlaces de navegación -->
    <a href="aplicacion.php">Volver a la tienda</a> |
    <a href="salir.php">Cerrar sesión</a>
</body>
</html>
