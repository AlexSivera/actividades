<?php
// clientenuevo.php
require_once 'funciones.php';

$errors = [];
$values = [
    'dni' => '',
    'nombre' => '',
    'apellidos' => '',
    'email' => '',
    'telefono' => '',
    'direccion' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y sanitizar
    $values['dni'] = strtoupper(trim($_POST['dni'] ?? ''));
    $values['nombre'] = trim($_POST['nombre'] ?? '');
    $values['apellidos'] = trim($_POST['apellidos'] ?? '');
    $values['email'] = trim($_POST['email'] ?? '');
    $values['telefono'] = trim($_POST['telefono'] ?? '');
    $values['direccion'] = trim($_POST['direccion'] ?? '');

    // Validaciones
    if ($values['nombre'] === '') {
        $errors['nombre'] = 'El nombre es obligatorio.';
    }
    if ($values['email'] === '' || !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email obligatorio y con formato válido.';
    }
    if (!preg_match('/^[0-9]{8}[A-Z]$/i', $values['dni'])) {
        $errors['dni'] = 'DNI con formato incorrecto (8 dígitos y letra).';
    } else {
        // comprobar dni repetido
        try {
            if (clienteExists($values['dni'])) {
                $errors['dni'] = 'Ya existe un cliente con ese DNI.';
            }
        } catch (Exception $e) {
            $errors['general'] = 'Error al comprobar el DNI: ' . $e->getMessage();
        }
    }

    if (empty($errors)) {
        try {
            $ok = insertarCliente($values);
            if ($ok) {
                header('Location: index.php?msg=' . urlencode('Cliente añadido correctamente') . '&type=success');
                exit;
            } else {
                $errors['general'] = 'No se pudo insertar el cliente.';
            }
        } catch (Exception $e) {
            $errors['general'] = 'Error al insertar: ' . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Nuevo Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <h1>Nuevo Cliente</h1>

        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errors['general']) ?></div>
        <?php endif; ?>

        <form method="post" novalidate>
            <div class="mb-3">
                <label for="dni" class="form-label">DNI</label>
                <input type="text" name="dni" id="dni"
                    class="form-control <?= isset($errors['dni']) ? 'is-invalid' : '' ?>"
                    value="<?= htmlspecialchars($values['dni']) ?>">
                <div class="invalid-feedback"><?= $errors['dni'] ?? '' ?></div>
                <div class="form-text">Formato: 8 dígitos y una letra (ej. 12345678A)</div>
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

            <button class="btn btn-primary" type="submit">Guardar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>