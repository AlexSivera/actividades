<?php
require_once "funciones.php";

$dni = $_GET["dni"] ?? null;

if (!$dni) {
    header("Location: index.php");
    exit;
}

$pdo = conectarBD();
$stmt = $pdo->prepare("SELECT * FROM clientes WHERE dni = :dni");
$stmt->execute([':dni' => $dni]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    echo "Cliente no encontrado.";
    exit;
}

$errores = [];
$nombre = $cliente["nombre"];
$direccion = $cliente["direccion"];
$localidad = $cliente["localidad"];
$correo = $cliente["correo"];
$telefono = $cliente["telefono"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $direccion = trim($_POST["direccion"]);
    $localidad = trim($_POST["localidad"]);
    $correo = trim($_POST["correo"]);
    $telefono = trim($_POST["telefono"]);

    // Validaciones básicas
    if (empty($nombre)) {
        $errores["nombre"] = "El nombre es obligatorio.";
    }

    if (empty($correo)) {
        $errores["correo"] = "El correo es obligatorio.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores["correo"] = "El formato del correo no es válido.";
    }

    // Validación básica de teléfono
    if (!empty($telefono) && !is_numeric($telefono)) {
        $errores["telefono"] = "El teléfono debe contener solo números";
    }

    if (!empty($telefono)) {
        if (!is_numeric($telefono)) {
            $errores["telefono"] = "El teléfono debe contener solo números";
        } elseif (strlen($telefono) != 9) {
            $errores["telefono"] = "El teléfono debe tener exactamente 9 dígitos";
        }
    }

    if (empty($errores)) {
        try {
            $stmt = $pdo->prepare("UPDATE clientes 
                                   SET nombre=:nombre, direccion=:direccion, localidad=:localidad, correo=:correo, telefono=:telefono 
                                   WHERE dni=:dni");
            $stmt->execute([
                ':nombre' => $nombre,
                ':direccion' => $direccion,
                ':localidad' => $localidad,
                ':correo' => $correo,
                ':telefono' => $telefono,
                ':dni' => $dni
            ]);

            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

desconectarBD($pdo);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Editar Cliente</h1>
    <form method="post">
        DNI: <input type="text" value="<?= $dni ?>" disabled><br><br>
        Nombre: <input type="text" name="nombre" value="<?= $nombre ?>"> <?= $errores["nombre"] ?? "" ?><br><br>
        Dirección: <input type="text" name="direccion" value="<?= $direccion ?>"><br><br>
        Localidad: <input type="text" name="localidad" value="<?= $localidad ?>"><br><br>
        Correo: <input type="text" name="correo" value="<?= $correo ?>"> <?= $errores["correo"] ?? "" ?><br><br>
        Teléfono: <input type="text" name="telefono" value="<?= $telefono ?>"> <?= $errores["telefono"] ?? "" ?><br><br>
        <input type="submit" value="Actualizar">
        <a href="index.php">Cancelar</a>
    </form>
</body>

</html>