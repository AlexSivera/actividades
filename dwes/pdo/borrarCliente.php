<?php
require_once "funciones.php";

$dni = $_GET["dni"] ?? null;
if (!$dni) {
    header("Location: index.php");
    exit;
}

$pdo = conectarBD();
$stmt = $pdo->prepare("SELECT nombre FROM clientes WHERE dni = :dni");
$stmt->execute([':dni' => $dni]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    echo "Cliente no encontrado.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["confirmar"])) {
        $stmt = $pdo->prepare("DELETE FROM clientes WHERE dni = :dni");
        $stmt->execute([':dni' => $dni]);
        echo "<script>alert('Cliente {$cliente["nombre"]} eliminado correctamente'); window.location='index.php';</script>";
    } else {
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
</head>

<body>
    <h1>Eliminar Cliente</h1>
    <p>¿Seguro que deseas eliminar al cliente <strong><?= $cliente["nombre"] ?></strong> (DNI: <?= $dni ?>)?</p>
    <form method="post">
        <button type="submit" name="confirmar">Sí, eliminar</button>
        <button type="submit" name="cancelar">Cancelar</button>
    </form>
</body>

</html>