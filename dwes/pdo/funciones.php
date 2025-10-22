<?php
/**
 * Función para establecer una conexión con la base de datos
 * 
 * @return PDO Objeto de conexión a la base de datos
 */
function conectarBD()
{
    // Configuración de los parámetros de conexión
    $host = 'localhost';
    $dbname = 'basedatos_clientes';
    $usuario = 'alex';
    $password = 'Alex1234!';

    try {
        // Crear una nueva instancia de PDO para conectarse a MySQL
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $password);
        // Configurar PDO para que lance excepciones en caso de errores
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // En caso de error en la conexión, mostrar mensaje y terminar ejecución
        die("Error de conexión: " . $e->getMessage());
    }
}

/**
 * Función para cerrar la conexión a la base de datos
 * 
 * @param PDO &$pdo Referencia al objeto de conexión PDO
 */
function desconectarBD(&$pdo)
{
    $pdo = null; // Cierra la conexión asignando null
}
?>