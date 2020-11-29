<?php
    include_once(dirname(__FILE__, 2) . '/controller/usuarios_controller.php');
    $html = "<html lang=\"en\">
            <head>
            <title>Registro</title>
            </head>
            <body>
            <h1>Registro</h1>
            <form method=\"POST\">
            Usuario: <input type=\"text\" name=\"usuario\"/><br/>
            Contraseña: <input type=\"text\" name=\"contrasena\"/><br/>
            <input type=\"submit\" value=\"Registrarse\" name=\"submit\"/>
            </form>
            <ul>
                <li>
                    <form action=\"../index.php\">
                        <input type=\"submit\" value=\"Volver\"/>
                    </form>
                </li>
            </ul>
            </body>
            </html>";
    echo $html;
    if(isset($_POST['submit'])) echo registrar();