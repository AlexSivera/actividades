<?php
// index.php
require_once 'funciones.php';

$clientes = [];
$msg = $_GET['msg'] ?? '';
$msgType = $_GET['type'] ?? 'info';

try {
    $clientes = getAllClients();
} catch (Exception $e) {
    $msg = "Error al conectar con la base de datos: " . htmlspecialchars($e->getMessage());
    $msgType = 'danger';
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Listado de Clientes</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <h1>Clientes</h1>

        <?php if ($msg): ?>
            <div class="alert alert-<?= htmlspecialchars($msgType) ?>"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <p>
            <a href="clientenuevo.php" class="btn btn-success">Nuevo Cliente</a>
        </p>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($clientes) === 0): ?>
                    <tr>
                        <td colspan="6" class="text-center">No hay clientes</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($clientes as $c): ?>
                        <tr>
                            <td><?= htmlspecialchars($c->getDni()) ?></td>
                            <td><?= htmlspecialchars($c->getNombre()) ?></td>
                            <td><?= htmlspecialchars($c->getApellidos()) ?></td>
                            <td><?= htmlspecialchars($c->getEmail()) ?></td>
                            <td><?= htmlspecialchars($c->getTelefono()) ?></td>
                            <td style="white-space:nowrap;">
                                <a href="editarcliente.php?dni=<?= urlencode($c->getDni()) ?>"
                                    class="btn btn-sm btn-primary">Editar</a>
                                <a href="borrarcliente.php?dni=<?= urlencode($c->getDni()) ?>"
                                    class="btn btn-sm btn-danger">Borrar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <hr>
        <h5>Mejoras/Modificaciones implementadas</h5>
        <ul>
            <li>Uso de clase Cliente y mapeo a objetos en getAllClients().</li>
            <li>Validación en servidor: nombre, email, formato DNI y unicidad del DNI en alta.</li>
            <li>Consultas preparadas para todo INSERT/UPDATE/DELETE y SELECT con parámetros.</li>
            <li>Mensajes de éxito/error mostrados en la página principal.</li>
            <li>Cierre explícito de la conexión PDO mediante asignación a null en un wrapper.</li>
        </ul>

    </div>
</body>

</html>