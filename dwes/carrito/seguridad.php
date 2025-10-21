<?php
session_start();

/* ------------------------------------------------------------
 COMPROBACIÓN DE AUTENTICACIÓN
 ------------------------------------------------------------
 Se verifica si la variable de sesión 'autentificado' está definida
 y si su valor es "SI", lo que indica que el usuario ha iniciado sesión correctamente.*/
if ($_SESSION["autentificado"] != "SI") {
    /* Si la condición anterior no se cumple, significa que:
     - El usuario no ha iniciado sesión aún, o
     - Intentó acceder directamente a una página sin pasar por el login./*

     En ese caso, se redirige al archivo 'index.php',
     que contiene el formulario de autenticación.
     header("Location: index.php");

     Se detiene la ejecución del script para evitar que el usuario
     pueda ver el contenido de la página protegida.*/
    exit();
}
?>