<?php
// funciones.php
require_once 'Cliente.php';

// Ajusta estos valores a tu entorno
define('DB_HOST', 'localhost');
define('DB_NAME', 'clientes_db');
define('DB_USER', 'cliente_user');
define('DB_PASS', 'tu_password_segura');
define('DB_CHARSET', 'utf8mb4');

/**
 * Devuelve una conexión PDO.
 * Lanza PDOException si falla.
 */
function getConnection()
{
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        // Manejar error (puedes loguearlo)
        throw $e;
    }
}

/**
 * Cierra la conexión PDO explícitamente.
 */
function closeConnection(&$pdo)
{
    $pdo = null;
}

/**
 * Devuelve un array de objetos Cliente con todos los registros.
 */
function getAllClients()
{
    $pdo = getConnection();
    try {
        $stmt = $pdo->query("SELECT dni, nombre, apellidos, email, telefono, direccion, fecha_registro FROM clientes ORDER BY nombre, apellidos");
        $rows = $stmt->fetchAll();
        $clientes = [];
        foreach ($rows as $r) {
            $c = new Cliente();
            $c->setDni($r['dni']);
            $c->setNombre($r['nombre']);
            $c->setApellidos($r['apellidos']);
            $c->setEmail($r['email']);
            $c->setTelefono($r['telefono']);
            $c->setDireccion($r['direccion']);
            $c->setFechaRegistro($r['fecha_registro']);
            $clientes[] = $c;
        }
        return $clientes;
    } finally {
        closeConnection($pdo);
    }
}

/**
 * Devuelve Cliente por DNI o null si no existe.
 */
function getClientByDni(string $dni)
{
    $pdo = getConnection();
    try {
        $stmt = $pdo->prepare("SELECT dni, nombre, apellidos, email, telefono, direccion, fecha_registro FROM clientes WHERE dni = ?");
        $stmt->execute([$dni]);
        $r = $stmt->fetch();
        if (!$r)
            return null;
        $c = new Cliente();
        $c->setDni($r['dni']);
        $c->setNombre($r['nombre']);
        $c->setApellidos($r['apellidos']);
        $c->setEmail($r['email']);
        $c->setTelefono($r['telefono']);
        $c->setDireccion($r['direccion']);
        $c->setFechaRegistro($r['fecha_registro']);
        return $c;
    } finally {
        closeConnection($pdo);
    }
}

/**
 * Comprueba si existe un cliente con ese DNI
 */
function clienteExists(string $dni)
{
    $pdo = getConnection();
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM clientes WHERE dni = ?");
        $stmt->execute([$dni]);
        return $stmt->fetchColumn() > 0;
    } finally {
        closeConnection($pdo);
    }
}

/**
 * Inserta un cliente. Devuelve true si se insertó.
 * $data: array asociativo con keys: dni,nombre,apellidos,email,telefono,direccion
 */
function insertarCliente(array $data)
{
    $pdo = getConnection();
    try {
        $sql = "INSERT INTO clientes (dni, nombre, apellidos, email, telefono, direccion) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $data['dni'],
            $data['nombre'],
            $data['apellidos'] ?? null,
            $data['email'],
            $data['telefono'] ?? null,
            $data['direccion'] ?? null
        ]);
    } finally {
        closeConnection($pdo);
    }
}

/**
 * Actualiza los datos (sin cambiar DNI). Devuelve true si se actualizó >0 filas.
 */
function actualizarCliente(string $dni, array $data)
{
    $pdo = getConnection();
    try {
        $sql = "UPDATE clientes SET nombre = ?, apellidos = ?, email = ?, telefono = ?, direccion = ? WHERE dni = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $data['nombre'],
            $data['apellidos'] ?? null,
            $data['email'],
            $data['telefono'] ?? null,
            $data['direccion'] ?? null,
            $dni
        ]);
        return $stmt->rowCount() > 0;
    } finally {
        closeConnection($pdo);
    }
}

/**
 * Borra un cliente por dni. Devuelve true si se borró alguna fila.
 */
function borrarCliente(string $dni)
{
    $pdo = getConnection();
    try {
        $stmt = $pdo->prepare("DELETE FROM clientes WHERE dni = ?");
        $stmt->execute([$dni]);
        return $stmt->rowCount() > 0;
    } finally {
        closeConnection($pdo);
    }
}
