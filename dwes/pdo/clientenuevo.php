<?php
require_once "funciones.php";

$errores = [];
$nombre = $direccion = $localidad = $correo = $telefono = $dni = "";

// Si el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = strtoupper(trim($_POST["dni"]));
    $nombre = trim($_POST["nombre"]);
    $direccion = trim($_POST["direccion"]);
    $localidad = trim($_POST["localidad"]);
    $correo = trim($_POST["correo"]);
    $telefono = trim($_POST["telefono"]);

    // Validaciones básicas
    if (empty($dni) || !preg_match("/^[0-9]{8}[A-Z]$/", $dni))
        $errores["dni"] = "El DNI debe tener 8 cifras y una letra mayúscula.";
    if (empty($nombre))
        $errores["nombre"] = "El nombre es obligatorio.";
    if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL))
        $errores["correo"] = "Correo inválido.";

    if (empty($errores)) {
        try {
            $pdo = conectarBD();

            // Comprobar si el DNI ya existe
            $stmt = $pdo->prepare("SELECT dni FROM clientes WHERE dni = :dni");
            $stmt->execute([':dni' => $dni]);
            if ($stmt->fetch()) {
                $errores["dni"] = "El DNI ya existe en la base de datos.";
            } else {
                // Insertar nuevo cliente
                $stmt = $pdo->prepare("INSERT INTO clientes (dni, nombre, direccion, localidad, correo, telefono)
                                       VALUES (:dni, :nombre, :direccion, :localidad, :correo, :telefono)");
                $stmt->execute([
                    ':dni' => $dni,
                    ':nombre' => $nombre,
                    ':direccion' => $direccion,
                    ':localidad' => $localidad,
                    ':correo' => $correo,
                    ':telefono' => $telefono
                ]);

                header("Location: index.php");
                exit;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            desconectarBD($pdo);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nuevo Cliente</title>
</head>

<body>
    <h1>Nuevo Cliente</h1>
    <form method="post">
        DNI: <input type="text" name="dni" value="<?= $dni ?>"> <?= $errores["dni"] ?? "" ?><br><br>
        Nombre: <input type="text" name="nombre" value="<?= $nombre ?>"> <?= $errores["nombre"] ?? "" ?><br><br>
        Dirección: <input type="text" name="direccion" value="<?= $direccion ?>"><br><br>
        Localidad: <input type="text" name="localidad" value="<?= $localidad ?>"><br><br>
        Correo: <input type="text" name="correo" value="<?= $correo ?>"> <?= $errores["correo"] ?? "" ?><br><br>
        Teléfono: <input type="text" name="telefono" value="<?= $telefono ?>"><br><br>
        <input type="submit" value="Guardar">
        <a href="index.php">Cancelar</a>
    </form>
</body>

</html>