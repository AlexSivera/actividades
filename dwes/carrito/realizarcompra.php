<?php
include("seguridad.php");
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
    <p>Su carrito se ha vaciado correctamente.</p>
    <a href="aplicacion.php">Volver a la tienda</a> |
    <a href="salir.php">Cerrar sesión</a>
</body>
</html>