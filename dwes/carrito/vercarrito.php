<?php
/* ==========================
   vercarrito.php
   Página que muestra el contenido del carrito de compras del usuario.
   ========================== */

/* Incluye el archivo de seguridad para asegurar que solo usuarios autenticados
   puedan acceder a esta página.*/
include("seguridad.php");

/* Incluye el archivo de funciones que contiene 'mostrar_carrito()',
   la cual genera la tabla con los productos añadidos al carrito. */
require_once "funciones.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver carrito</title>
</head>
<body>
    <h1>Carrito de la compra</h1>

    <?php 
    /* ==========================
       MOSTRAR EL CARRITO
       ==========================
       Llama a la función 'mostrar_carrito()', que:
       - Verifica si la cookie 'carrito' existe.
       - Si existe, muestra los productos, cantidades y total de artículos.
       - Si no existe o está vacío, muestra un mensaje indicando que el carrito está vacío. */
    mostrar_carrito(); 
    ?>

    <!-- ==========================
         ENLACES DE NAVEGACIÓN
         ========================== -->
    <p>
        <!-- Regresa a la página principal de productos -->
        <a href="aplicacion.php">Seguir comprando</a> |
        
        <!-- Avanza al proceso de pago o confirmación de compra -->
        <a href="realizarcompra.php">Finalizar compra</a> |
        
        <!-- Permite al usuario cerrar sesión de forma segura -->
        <a href="salir.php">Cerrar sesión</a>
    </p>
</body>
</html>
