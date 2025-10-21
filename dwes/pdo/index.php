<?php
require_once "funciones.php";
require_once "cliente.php";

$pdo = conectarBD();
$query = $pdo->query("SELECT * FROM clientes");
$query->setFetchMode(PDO::FETCH_CLASS, 'cliente');
$clientes = $query->fetchAll();
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
        <a href="clienteNuevo.php">Nuevo Cliente</a>
        <table border="1" cellpadding="5">
            <tr>
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
                    <td><?= $cliente->getDni() ?></td>
                    <td><?= $cliente->getNombre() ?></td>
                    <td><?= $cliente->getDireccion() ?></td>
                    <td><?= $cliente->getLocalidad() ?></td>
                    <td><?= $cliente->getCorreo() ?></td>
                    <td><?= $cliente->getTelefono() ?></td>
                    <td>
                        <a href="editarCliente.php?dni=<?= $cliente->getDni() ?>">Editar</a> |
                        <a href="borrarCliente.php?dni=<?= $cliente->getDni() ?>">Borrar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>


</html>