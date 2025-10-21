<?php
include("seguridad.php");
require_once "funciones.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda Segura</title>
</head>
<body>
    <h1>Mi Tienda (Área Protegida)</h1>
    <p>Usuario autenticado: <strong><?php echo $_POST["usuario"] ?? ''; ?></strong></p>

    <?php
    if (isset($_COOKIE['carrito'])) {
        $carrito = unserialize($_COOKIE['carrito']);
        $total = array_sum($carrito);
        echo "<p>Artículos en el carrito: <strong>$total</strong></p>";
    } else {
        echo "<p>El carrito está vacío.</p>";
    }

    escaparate();
    ?>

    <p>
        <a href="vercarrito.php">Ver carrito</a> |
        <a href="salir.php">Cerrar sesión</a>
    </p>
</body>
</html>