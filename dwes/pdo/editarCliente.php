<?php
// Incluir el archivo de funciones para conectar a la base de datos
require_once "funciones.php";

// Obtener el DNI del cliente a editar desde la URL
$dni = $_GET["dni"] ?? null;

// Si no se proporcionó DNI, redirigir al listado principal
if (!$dni) {
    header("Location: index.php");
    exit;
}

// Conectar a la base de datos y obtener los datos del cliente
$pdo = conectarBD();
$stmt = $pdo->prepare("SELECT * FROM clientes WHERE dni = :dni");
$stmt->execute([':dni' => $dni]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

// Si no se encuentra el cliente, mostrar mensaje y terminar
if (!$cliente) {
    echo "Cliente no encontrado.";
    exit;
}

// Inicializar variables con los datos actuales del cliente
$errores = [];
$nombre = $cliente["nombre"];
$direccion = $cliente["direccion"];
$localidad = $cliente["localidad"];
$correo = $cliente["correo"];
$telefono = $cliente["telefono"];

// Si el formulario se ha enviado (método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar los datos del formulario
    $nombre = trim($_POST["nombre"]);
    $direccion = trim($_POST["direccion"]);
    $localidad = trim($_POST["localidad"]);
    $correo = trim($_POST["correo"]);
    $telefono = trim($_POST["telefono"]);

    // VALIDACIONES DE CAMPOS

    // Validación del nombre (obligatorio)
    if (empty($nombre)) {
        $errores["nombre"] = "El nombre es obligatorio.";
    }

    // Validación del correo (obligatorio y formato válido)
    if (empty($correo)) {
        $errores["correo"] = "El correo es obligatorio.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
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

    // Si no hay errores de validación, proceder a actualizar en la base de datos
    if (empty($errores)) {
        try {
            // Preparar y ejecutar la consulta de actualización
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

            // Redirigir al listado principal después de actualizar
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            // Manejar errores de base de datos
            echo "Error: " . $e->getMessage();
        }
    }
}

// Cerrar la conexión a la base de datos
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
    <!-- Formulario para editar cliente existente -->
    <form method="post">
        <!-- Campo DNI (solo lectura ya que es la clave primaria) -->
        DNI: <input type="text" value="<?= $dni ?>" disabled><br><br>
        
        <!-- Campo Nombre con valor actual y muestra de error si existe -->
        Nombre: <input type="text" name="nombre" value="<?= $nombre ?>"> <?= $errores["nombre"] ?? "" ?><br><br>
        
        <!-- Campo Dirección con valor actual -->
        Dirección: <input type="text" name="direccion" value="<?= $direccion ?>"><br><br>
        
        <!-- Campo Localidad con valor actual -->
        Localidad: <input type="text" name="localidad" value="<?= $localidad ?>"><br><br>
        
        <!-- Campo Correo con valor actual y muestra de error si existe -->
        Correo: <input type="text" name="correo" value="<?= $correo ?>"> <?= $errores["correo"] ?? "" ?><br><br>
        
        <!-- Campo Teléfono con valor actual y muestra de error si existe -->
        Teléfono: <input type="text" name="telefono" value="<?= $telefono ?>"> <?= $errores["telefono"] ?? "" ?><br><br>
        
        <!-- Botones de acción -->
        <input type="submit" value="Actualizar">
        <a href="index.php">Cancelar</a>
    </form>
</body>

</html>