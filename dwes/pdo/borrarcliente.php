<?php
// borrarcliente.php
require_once 'funciones.php';

$dni = $_GET['dni'] ?? '';
if (!$dni) {
    header('Location: index.php?msg=' . urlencode('DNI no especificado') . '&type=warning');
    exit;
}

$cliente = getClientByDni($dni);
if (!$cliente) {
    header('Location: index.php?msg=' . urlencode("Cliente con DNI $dni no encontrado") . '&type=warning');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $confirm = $_POST['confirm'] ?? 'no';
    if ($confirm === 'si') {
        try {
            $deleted = borrarCliente($dni);
            if ($deleted) {
                header('Location: index.php?msg=' . urlencode("Cliente " . $cliente->getNombre() . " eliminado correctamente") . '&type=success');
                exit;
            } else {
                header('Location: index.php?msg=' . urlencode("No se pudo eliminar el cliente") . '&type=danger');
                exit;
            }
        } catch (Exception $e) {
            header('Location: index.php?msg=' . urlencode("Error al eliminar: " . $e->getMessage()) . '&type=danger');
            exit;
        }
    } else {
        header('Location: index.php?msg=' . urlencode('Borrado cancelado') . '&type=info');
        exit;
    }
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Borrar Cliente <?= htmlspecialchars($dni) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <h1>Confirmar borrado</h1>
        <p>¿Deseas eliminar al cliente
            <strong><?= htmlspecialchars($cliente->getNombre() . ' ' . $cliente->getApellidos()) ?></strong> con DNI
            <strong><?= htmlspecialchars($dni) ?></strong>?</p>

        <form method="post">
            <button name="confirm" value="si" class="btn btn-danger">Sí, eliminar</button>
            <button name="confirm" value="no" class="btn btn-secondary">No, cancelar</button>
        </form>
    </div>
</body>

</html>