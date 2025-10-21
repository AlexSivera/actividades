<?php
/* Inicia o reanuda una sesión.
   Es necesario para poder guardar variables de sesión
   que indiquen si el usuario está autenticado.*/
session_start();


/* ------------------------------------------------------------
   VALIDACIÓN DE CREDENCIALES DEL USUARIO
   ------------------------------------------------------------
   Se comprueba si los datos enviados desde el formulario de login
   (usuario y contraseña) coinciden con los valores válidos definidos aquí.
   En este caso, el usuario válido es "Alex" y la contraseña "1234". */
if ($_POST["usuario"] == "Alex" && $_POST["contrasena"] == "1234") {
    
    /* --------------------------------------------------------
       SI LAS CREDENCIALES SON CORRECTAS:
       --------------------------------------------------------
       Se guarda una variable de sesión que indica que el usuario
       ha sido autenticado correctamente. */
    $_SESSION["autentificado"] = "SI";

    /* Redirige al usuario a la página principal de la aplicación,
       donde podrá acceder a las funciones de la tienda.*/
    header("Location: aplicacion.php");
    
} else {
    /* --------------------------------------------------------
       SI LAS CREDENCIALES SON INCORRECTAS:
       --------------------------------------------------------
       Redirige de nuevo a la página de inicio de sesión (index.php)
       pasando el parámetro 'errorusuario=si' para mostrar un mensaje de error. */
    header("Location: index.php?errorusuario=si");
}

// Finaliza la ejecución del script después de la redirección
exit();
?>
