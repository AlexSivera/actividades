<?php
function conectarBD()
{
    $host = 'localhost';
    $dbname = 'basedatos_clientes';
    $usuario = 'alex';
    //$password = '1234';
    $password = 'Alex1234!';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

function desconectarBD(&$pdo)
{
    $pdo = null; // Cierra la conexión
}
?>