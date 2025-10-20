<?php
/* ==========================
   aplicacion.php
   Página principal de la tienda después de iniciar sesión.
   Muestra productos y el estado del carrito.
   ========================== */

/* Incluye el archivo de seguridad para asegurar que el usuario
   ha iniciado sesión antes de mostrar la página.*/
include("seguridad.php");

/* Incluye funciones auxiliares, como 'escaparate()',
   que muestra los productos disponibles.*/
require_once "funciones.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda Segura</title>
</head>
<body>
    <h1>Mi Tienda</h1>
    <?php
    /* ==========================
       MOSTRAR CANTIDAD DE ARTÍCULOS EN EL CARRITO
       ========================== */
    if (isset($_COOKIE['carrito'])) {
        // Convierte el contenido serializado de la cookie a un array
        $carrito = unserialize($_COOKIE['carrito']);

        // Suma todas las cantidades de artículos para obtener el total
        $total = array_sum($carrito);

        // Muestra el total de artículos
        echo "<p>Artículos en el carrito: <strong>$total</strong></p>";
    } else {
        // Si no existe la cookie, significa que el carrito está vacío
        echo "<p>El carrito está vacío.</p>";
    }

    /* ==========================
       MOSTRAR ESCAPARATE DE PRODUCTOS
       ==========================
       Llama a la función 'escaparate()', definida en funciones.php,
       que genera una tabla con los productos disponibles y un enlace para comprarlos.*/
    escaparate();
    ?>

    <!-- Enlaces de navegación -->
    <p>
        <a href="vercarrito.php">Ver carrito</a> |
        <a href="salir.php">Cerrar sesión</a>
    </p>
</body>
</html>
