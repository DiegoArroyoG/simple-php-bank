<link rel="stylesheet" href="../CSS/register.css" type="text/css">

<div class = "contenedor">
<?php
    include_once(dirname(__FILE__, 2) . '/controller/credito_controller.php');
    if(!isset($_SESSION)) session_start(); 

    $html;
    if (isset($_SESSION['token'])){
        $html="<!DOCTYPE html>
                <html lang=\"en\">
                <head>
                    <meta charset=\"UTF-8\">
                    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                    <title>Credito</title>
                </head>
                <body>
                    <form method=\"POST\">
                        <input type=\"submit\" value=\"Cerrar sesion\" name=\"cerrar_sesion\"/>
                    </form>
                    <h3>Crédito</h3>
                    <form method=\"POST\">
                        Total crédito: <input type=\"number\" name=\"credito\"/><br/>
                        Tasa de interés % (0.0-100.0): <input type=\"number\" name=\"tasa\"/><br/>
                        <input type=\"submit\" value=\"Pedir credito\" name=\"cliente\"/>
                    </form>
                </body>
                </html>";
    } else{
        $html="<!DOCTYPE html>
                <html lang=\"en\">
                <head>
                    <meta charset=\"UTF-8\">
                    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                    <title>Credito</title>
                </head>
                <body>
                    <ul style=\"margin: 0; padding: 0; display:inline-block;\">
                        <li style=\"display:inline-block;\"><a href=\"login.php\"><button>Iniciar sesion</button></a></li>
                        <li style=\"display:inline-block;\"><a href=\"register.php\"><button>Registrarse</button></a></li>
                    </ul>
                    <h3>Crédito</h3>
                    <form method=\"POST\">
                        Email: <input type=\"email\" name=\"email\"/><br/>
                        Total crédito: <input type=\"number\" name=\"credito\"/><br/>
                        **Si usted es cliente, por favor inicie sesión<br/>
                        <input type=\"submit\" value=\"Pedir credito\" name=\"visitante\"/>
                    </form>
                </body>
                </html>";
    }
    $html.="<ul>
                <li>
                    <form action=\"../index.php\">
                        <input type=\"submit\" value=\"Volver\"/>
                    </form>
                </li>
            </ul>";
    echo $html;
    if(isset($_POST['cliente'])) echo crear_credito_cliente();
    if(isset($_POST['visitante'])) echo crear_credito_visitante();
    if(isset($_POST['cerrar_sesion']))
    {
        unset($_SESSION['token']);
        header("Refresh:0");
    }
    ?>
</div>