<?php
include("seguridad.php");

if (!isset($_GET['ref'])) {
    header("Location: aplicacion.php");
    exit;
}

$ref = $_GET['ref'];

if (isset($_COOKIE['carrito'])) {
    $carrito = unserialize($_COOKIE['carrito']);
} else {
    $carrito = [];
}

if (isset($carrito[$ref])) {
    $carrito[$ref]++;
} else {
    $carrito[$ref] = 1;
}

setcookie("carrito", serialize($carrito), time() + 3600);

header("Location: aplicacion.php");
exit;
?>
