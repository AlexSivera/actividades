<?php
// Incluir los archivos necesarios con las funciones y la clase Cliente
require_once "funciones.php";
require_once "cliente.php";

// Conectar a la base de datos
$pdo = conectarBD();
// Ejecutar consulta para obtener todos los clientes
$query = $pdo->query("SELECT * FROM clientes");
// Configurar el modo de fetch para que devuelva objetos de la clase Cliente
$query->setFetchMode(PDO::FETCH_CLASS, 'cliente');
// Obtener todos los registros como objetos Cliente
$clientes = $query->fetchAll();
// Cerrar la conexión a la base de datos
desconectarBD($pdo);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Clientes</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>Clientes</h1>
        <!-- Enlace para crear un nuevo cliente -->
        <a href="clienteNuevo.php">Nuevo Cliente</a>
        <table border="1" cellpadding="5">
            <tr>
                <!-- Encabezados de la tabla -->
                <th>DNI</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Localidad</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <!-- Mostrar los datos del cliente utilizando los métodos getter -->
                    <td><?= $cliente->getDni() ?></td>
                    <td><?= $cliente->getNombre() ?></td>
                    <td><?= $cliente->getDireccion() ?></td>
                    <td><?= $cliente->getLocalidad() ?></td>
                    <td><?= $cliente->getCorreo() ?></td>
                    <td><?= $cliente->getTelefono() ?></td>
                    <td>
                        <!-- Enlaces para editar y borrar el cliente, pasando el DNI como parámetro -->
                        <a href="editarCliente.php?dni=<?= $cliente->getDni() ?>">Editar</a> |
                        <a href="borrarCliente.php?dni=<?= $cliente->getDni() ?>">Borrar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>