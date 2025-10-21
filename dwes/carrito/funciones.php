<?php
/* ==========================
   Archivo: funciones.php
   Contiene funciones auxiliares para la tienda:
    - escaparate(): muestra los productos disponibles.
    - mostrar_carrito(): muestra el contenido del carrito.
   ==========================
*/

/* ------------------------------------------------------------
   FUNCIÓN: escaparate()
   Muestra en una tabla los productos disponibles en la tienda
   junto con su referencia, descripción, precio y un enlace
   para añadirlos al carrito.
   ------------------------------------------------------------*/
function escaparate() {
    /* Array asociativo con los productos disponibles. 
       a clave es la referencia del producto,
       y el valor es otro array con la descripción y el precio. */
    $productos = [
        "A001" => ["descripcion" => "Manzanas", "precio" => 1.50],
        "A002" => ["descripcion" => "Leche", "precio" => 0.95],
        "A003" => ["descripcion" => "Pan", "precio" => 1.20],
        "A004" => ["descripcion" => "Huevos", "precio" => 2.50],
    ];

    // Encabezado de la sección
    echo "<h2>Productos disponibles</h2>";

    // Comienza la tabla HTML para mostrar los productos
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Referencia</th><th>Descripción</th><th>Precio (€)</th><th></th></tr>";

    // Recorre cada producto y genera una fila con su información
    foreach ($productos as $ref => $prod) {
        echo "<tr>";
        echo "<td>$ref</td>"; // Muestra la referencia del producto
        echo "<td>{$prod['descripcion']}</td>"; // Muestra la descripción
        echo "<td>{$prod['precio']}</td>"; // Muestra el precio
        // Enlace que permite añadir el producto al carrito
        // enviando su referencia como parámetro por GET
        echo "<td><a href='añadiralcarro.php?ref=$ref'>Comprar</a></td>";
        echo "</tr>";
    }

    // Cierra la tabla
    echo "</table>";
}


/* ------------------------------------------------------------
   FUNCIÓN: mostrar_carrito()
   Muestra el contenido actual del carrito de compras del usuario.
   Los datos del carrito se guardan en una cookie llamada 'carrito'
   que contiene un array serializado con referencias y cantidades.
   ------------------------------------------------------------ */
function mostrar_carrito() {
    // Verifica si la cookie 'carrito' existe.
    // Si no existe, significa que el usuario aún no ha agregado nada.
    if (!isset($_COOKIE['carrito'])) {
        echo "<p>El carrito está vacío.</p>";
        return; // Termina la ejecución de la función.
    }

    // Convierte el contenido serializado de la cookie a un array PHP.
    $carrito = unserialize($_COOKIE['carrito']);

    // Comprueba si el array está vacío (aunque exista la cookie).
    if (empty($carrito)) {
        echo "<p>El carrito está vacío.</p>";
        return;
    }

    // Muestra el encabezado de la sección del carrito
    echo "<h2>Contenido del carrito</h2>";

    // Crea una tabla HTML con las referencias y cantidades
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Referencia</th><th>Cantidad</th></tr>";

    // Variable para contar el total de artículos
    $total = 0;

    // Recorre cada producto del carrito
    foreach ($carrito as $ref => $cantidad) {
        echo "<tr><td>$ref</td><td>$cantidad</td></tr>";
        // Suma las cantidades para obtener el total de artículos
        $total += $cantidad;
    }

    // Cierra la tabla
    echo "</table>";

    // Muestra el total de artículos añadidos
    echo "<p>Total de artículos: <strong>$total</strong></p>";
}
?>
