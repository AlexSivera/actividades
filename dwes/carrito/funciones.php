<?php
// funciones.php

function escaparate() {
    $productos = [
        "A001" => ["descripcion" => "Manzanas", "precio" => 1.50],
        "A002" => ["descripcion" => "Leche", "precio" => 0.95],
        "A003" => ["descripcion" => "Pan", "precio" => 1.20],
        "A004" => ["descripcion" => "Huevos", "precio" => 2.50],
    ];

    echo "<h2>Productos disponibles</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Referencia</th><th>Descripción</th><th>Precio (€)</th><th></th></tr>";
    foreach ($productos as $ref => $prod) {
        echo "<tr>";
        echo "<td>$ref</td>";
        echo "<td>{$prod['descripcion']}</td>";
        echo "<td>{$prod['precio']}</td>";
        echo "<td><a href='añadiralcarro.php?ref=$ref'>Comprar</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

function mostrar_carrito() {
    if (!isset($_COOKIE['carrito'])) {
        echo "<p>El carrito está vacío.</p>";
        return;
    }

    $carrito = unserialize($_COOKIE['carrito']);

    if (empty($carrito)) {
        echo "<p>El carrito está vacío.</p>";
        return;
    }

    echo "<h2>Contenido del carrito</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Referencia</th><th>Cantidad</th></tr>";

    $total = 0;
    foreach ($carrito as $ref => $cantidad) {
        echo "<tr><td>$ref</td><td>$cantidad</td></tr>";
        $total += $cantidad;
    }

    echo "</table>";
    echo "<p>Total de artículos: <strong>$total</strong></p>";
}
?>
