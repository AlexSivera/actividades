<?php
/* Inicia o reanuda una sesión.
  Esto permite guardar y acceder a variables de sesión*/
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Autentificación Tienda</title>
</head>
<body>
    <h1>Autentificación Tienda</h1>

    <!-- 
        Formulario de inicio de sesión.
        Envía los datos al archivo "control.php" mediante el método POST,
        donde se validarán las credenciales del usuario.
    -->
    <form action="control.php" method="POST">
        <table align="center" width="225" cellspacing="2" cellpadding="2" border="0">
            <tr>
                <td colspan="2" align="center"
                    <?php 
                    /* Si el script recibe el parámetro GET 'errorusuario=si',
                       significa que el usuario o la contraseña eran incorrectos.
                       En ese caso, muestra el mensaje de error en rojo.*/
                    if (isset($_GET['errorusuario']) && $_GET['errorusuario'] == "si") { ?>
                        bgcolor="red">
                        <span style="color:#ffffff"><b>Datos incorrectos</b></span>
                    <?php 
                    // Si no hay error, muestra el mensaje normal en gris.
                    } else { ?>
                        bgcolor="#cccccc">Introduce tu clave de acceso
                    <?php } ?>
                </td>
            </tr>

            <!-- Campo para ingresar el nombre de usuario -->
            <tr>
                <td align="right">Usuario:</td>
                <td><input type="text" name="usuario" size="8" maxlength="50"></td>
            </tr>

            <!-- Campo para ingresar la contraseña -->
            <tr>
                <td align="right">Contraseña:</td>
                <td><input type="password" name="contrasena" size="8" maxlength="50"></td>
            </tr>

            <!-- Botón para enviar el formulario -->
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="ENTRAR">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
