<link rel="stylesheet" href="../CSS/login.css" type="text/css">

<?php
    include_once(dirname(__FILE__, 2) . '/controller/usuarios_controller.php');
?>
<!DOCTYPE html>
<html lang="en">
<div class = "contenedor">

    <head>
        <title>Inicio de sesion</title>
    </head>
    <body>
        <h1>Iniciar sesion</h1>
        <form method="POST">
            Usuario: <input type="text" name="usuario"/><br/>
            Contraseña: <input type="text" name="contrasena"/><br/>
            <input type="submit" value="Iniciar Sesion" name="submit"/>
        </form>
        <?php
            if(isset($_POST['submit'])) echo autenticar();
        ?>
        <ul>
            <li>
                <form action="../index.php">
                    <input type="submit" value="Volver"/>
                </form>
            </li>
        </ul>
    </body>
</div>
</html>