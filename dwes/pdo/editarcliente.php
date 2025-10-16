<?php
// editarcliente.php
require_once 'funciones.php';

$dni = $_GET['dni'] ?? '';
if (!$dni) {
    header('Location: index.php?msg=' . urlencode('DNI no especificado') . '&type=warning');
    exit;
}

$errors = [];
$client = getClientByDni($dni);
if (!$client) {
    header('Location: index.php?msg=' . urlencode("Cliente con DNI $dni no encontrado") . '&type=warning');
    exit;
}

$values = [
    'nombre' => $client->getNombre(),
    'apellidos' => $client->getApellidos(),
    'email' => $client->getEmail(),
    'telefono' => $client->getTelefono(),
    'direccion' => $client->getDireccion()
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values['nombre'] = trim($_POST['nombre'] ?? '');
    $values['apellidos'] = trim($_POST['apellidos'] ?? '');
    $values['email'] = trim($_POST['email'] ?? '');
    $values['telefono'] = trim($_POST['telefono'] ?? '');
    $values['direccion'] = trim($_POST['direccion'] ?? '');

    // Validaciones (dni no se modifica)
    if ($values['nombre'] === '') {
        $errors['nombre'] = 'El nombre es obligatorio.';
    }
    if ($values['email'] === '' || !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email obligatorio y con formato válido.';
    }

    if (empty($errors)) {
        try {
            $ok = actualizarCliente($dni, $values);
            if ($ok) {
                header('Location: index.php?msg=' . urlencode('Cliente actualizado correctamente') . '&type=success');
                exit;
            } else {
                // Si rowCount()==0 puede ser que no haya cambios; mostrar mensaje informativo
                header('Location: index.php?msg=' . urlencode('No hubo cambios o no se modificó el registro') . '&type=info');
                exit;
            }
        } catch (Exception $e) {
            $errors['general'] = 'Error al actualizar: ' . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Editar Cliente <?= htmlspecialchars($dni) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <h1>Editar Cliente</h1>

        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errors['general']) ?></div>
        <?php endif; ?>

        <form method="post" novalidate>
            <div class="mb-3">
                <label class="form-label">DNI</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($dni) ?>" disabled>
                <div class="form-text">El DNI no se puede modificar.</div>
            </div>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre *</label>
                <input type="text" name="nombre" id="nombre"
                    class="form-control <?= isset($errors['nombre']) ? 'is-invalid' : '' ?>"
                    value="<?= htmlspecialchars($values['nombre']) ?>">
                <div class="invalid-feedback"><?= $errors['nombre'] ?? '' ?></div>
            </div>

            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" name="apellidos" id="apellidos" class="form-control"
                    value="<?= htmlspecialchars($values['apellidos']) ?>">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email *</label>
                <input type="email" name="email" id="email"
                    class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                    value="<?= htmlspecialchars($values['email']) ?>">
                <div class="invalid-feedback"><?= $errors['email'] ?? '' ?></div>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" id="telefono" class="form-control"
                    value="<?= htmlspecialchars($values['telefono']) ?>">
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <textarea name="direccion" id="direccion"
                    class="form-control"><?= htmlspecialchars($values['direccion']) ?></textarea>
            </div>

            <button class="btn btn-primary" type="submit">Actualizar</button>
            <a href="index.php" class="btn btn-secondary">Volver</a>
        </form>
    </div>
</body>

</html>