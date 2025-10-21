<?php
include("seguridad.php");
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

    <?php mostrar_carrito(); ?>

    <p>
        <a href="aplicacion.php">Seguir comprando</a> |
        <a href="realizarcompra.php">Finalizar compra</a> |
        <a href="salir.php">Cerrar sesión</a>
    </p>
</body>
</html>