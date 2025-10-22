<?php
// Incluir el archivo de funciones para conectar a la base de datos
require_once "funciones.php";

// Obtener el DNI del cliente a borrar desde la URL
$dni = $_GET["dni"] ?? null;

// Si no se proporcionó DNI, redirigir al listado principal
if (!$dni) {
    header("Location: index.php");
    exit;
}

// Conectar a la base de datos y verificar que el cliente existe
$pdo = conectarBD();
$stmt = $pdo->prepare("SELECT nombre FROM clientes WHERE dni = :dni");
$stmt->execute([':dni' => $dni]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

// Si no se encuentra el cliente, mostrar mensaje y terminar
if (!$cliente) {
    echo "Cliente no encontrado.";
    exit;
}

// Si el formulario de confirmación se ha enviado (método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Si se confirmó la eliminación
    if (isset($_POST["confirmar"])) {
        // Preparar y ejecutar la consulta de eliminación
        $stmt = $pdo->prepare("DELETE FROM clientes WHERE dni = :dni");
        $stmt->execute([':dni' => $dni]);
        
        // Mostrar alerta de éxito y redirigir al listado principal
        echo "<script>alert('Cliente {$cliente["nombre"]} eliminado correctamente'); window.location='index.php';</script>";
    } else {
        // Si se canceló, redirigir al listado principal
        header("Location: index.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Borrar Cliente</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Eliminar Cliente</h1>
    <!-- Mensaje de confirmación con los datos del cliente -->
    <p>¿Seguro que deseas eliminar al cliente <strong><?= $cliente["nombre"] ?></strong> (DNI: <?= $dni ?>)?</p>
    
    <!-- Formulario de confirmación con dos botones -->
    <form method="post">
        <!-- Botón para confirmar eliminación -->
        <button type="submit" name="confirmar">Sí, eliminar</button>
        <!-- Botón para cancelar la operación -->
        <button type="submit" name="cancelar">Cancelar</button>
    </form>
</body>

</html>