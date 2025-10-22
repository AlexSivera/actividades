<?php
// Incluir el archivo de funciones para conectar a la base de datos
require_once "funciones.php";

// Inicializar variables
$errores = []; // Array para almacenar mensajes de error
$nombre = $direccion = $localidad = $correo = $telefono = $dni = ""; // Variables para los campos del formulario

// Si el formulario se ha enviado (método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar los datos del formulario
    $dni = strtoupper(trim($_POST["dni"])); // Convertir DNI a mayúsculas y quitar espacios
    $nombre = trim($_POST["nombre"]);
    $direccion = trim($_POST["direccion"]);
    $localidad = trim($_POST["localidad"]);
    $correo = trim($_POST["correo"]);
    $telefono = trim($_POST["telefono"]);

    // VALIDACIONES DE CAMPOS

    // Validación del DNI
    if (empty($dni)) {
        $errores["dni"] = "El DNI es obligatorio.";
    } elseif (!preg_match("/^[0-9]{8}[A-Z]$/", $dni)) {
        // Verificar formato: 8 números + 1 letra mayúscula
        $errores["dni"] = "El DNI debe tener 8 números y 1 letra mayúscula.";
    }

    // Validación del nombre
    if (empty($nombre)) {
        $errores["nombre"] = "El nombre es obligatorio.";
    }

    // Validación del correo
    if (empty($correo)) {
        $errores["correo"] = "El correo es obligatorio.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        // Verificar formato de email válido
        $errores["correo"] = "El formato del correo no es válido.";
    }

    // Validación del teléfono (opcional pero con formato específico si se proporciona)
    if (!empty($telefono)) {
        if (!is_numeric($telefono)) {
            $errores["telefono"] = "El teléfono debe contener solo números";
        } elseif (strlen($telefono) != 9) {
            $errores["telefono"] = "El teléfono debe tener exactamente 9 dígitos";
        }
    }

    // Si no hay errores de validación, proceder a insertar en la base de datos
    if (empty($errores)) {
        try {
            $pdo = conectarBD(); // Conectar a la base de datos

            // Comprobar si el DNI ya existe en la base de datos
            $stmt = $pdo->prepare("SELECT dni FROM clientes WHERE dni = :dni");
            $stmt->execute([':dni' => $dni]);
            if ($stmt->fetch()) {
                $errores["dni"] = "El DNI ya existe en la base de datos.";
            } else {
                // Insertar nuevo cliente en la base de datos
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

                // Redirigir al listado principal después de guardar
                header("Location: index.php");
                exit;
            }
        } catch (PDOException $e) {
            // Manejar errores de base de datos
            echo "Error: " . $e->getMessage();
        } finally {
            // Cerrar la conexión a la base de datos
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
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Nuevo Cliente</h1>
    <!-- Formulario para crear nuevo cliente -->
    <form method="post">
        <!-- Campo DNI con valor predefinido y muestra de error si existe -->
        DNI: <input type="text" name="dni" value="<?= $dni ?>"> <?= $errores["dni"] ?? "" ?><br><br>

        <!-- Campo Nombre con valor predefinido y muestra de error si existe -->
        Nombre: <input type="text" name="nombre" value="<?= $nombre ?>"> <?= $errores["nombre"] ?? "" ?><br><br>

        <!-- Campo Dirección con valor predefinido -->
        Dirección: <input type="text" name="direccion" value="<?= $direccion ?>"><br><br>

        <!-- Campo Localidad con valor predefinido -->
        Localidad: <input type="text" name="localidad" value="<?= $localidad ?>"><br><br>

        <!-- Campo Correo con valor predefinido y muestra de error si existe -->
        Correo: <input type="text" name="correo" value="<?= $correo ?>"> <?= $errores["correo"] ?? "" ?><br><br>

        <!-- Campo Teléfono con valor predefinido y muestra de error si existe -->
        Teléfono: <input type="text" name="telefono" value="<?= $telefono ?>"> <?= $errores["telefono"] ?? "" ?><br><br>

        <!-- Botones de acción -->
        <input type="submit" value="Guardar">
        <a href="index.php">Cancelar</a>
    </form>
</body>

</html>