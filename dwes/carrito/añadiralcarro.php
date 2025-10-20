<?php
/* Incluye el archivo de seguridad, que asegura que el usuario esté autenticado
   antes de permitirle modificar el carrito de compras.*/
include("seguridad.php");

/* Verifica si el parámetro 'ref' (referencia del producto) fue pasado por la URL.
   Si no existe, redirige de nuevo a la página principal 'aplicacion.php'. */
if (!isset($_GET['ref'])) {
    header("Location: aplicacion.php");
    exit; 
}

// Guarda el valor del parámetro 'ref' en una variable (identificador del producto).
$ref = $_GET['ref'];

// Comprueba si ya existe una cookie llamada 'carrito'.
if (isset($_COOKIE['carrito'])) {
    // Si existe, convierte el contenido serializado de la cookie en un array PHP.
    $carrito = unserialize($_COOKIE['carrito']);
} else {
    // Si no existe, inicializa un array vacío para comenzar un nuevo carrito.
    $carrito = [];
}

// Verifica si el producto con la referencia $ref ya está en el carrito.
if (isset($carrito[$ref])) {
    // Si ya existe, incrementa la cantidad en 1.
    $carrito[$ref]++;
} else {
    // Si no existe, lo agrega al carrito con cantidad inicial 1.
    $carrito[$ref] = 1;
}

/* Guarda el carrito actualizado en una cookie, serializando el array.
   La cookie tendrá una duración de 1 hora (3600 segundos).*/
setcookie("carrito", serialize($carrito), time() + 3600);

// Redirige de nuevo a la página principal 'aplicacion.php' después de agregar el producto.
header("Location: aplicacion.php");
exit;
?>
