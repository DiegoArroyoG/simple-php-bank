<?php
    include_once(dirname(__FILE__, 2) . '/controller/consignar_controller.php');
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
                        <input type=\"radio\" name=\"destino\" value=\"ahorros\" checked> Ahorros
                        <input type=\"radio\" name=\"destino\" value=\"credito\"> Crédito<br/>
                        Numero cuenta de ahorros: <input type=\"number\" name=\"numero_cuenta\"/><br/>
                        **Si la consignacion es a un credito ignore este campo<br/>
                        Total consignación: <input type=\"number\" name=\"consignado\"/>
                        <select name=\"moneda\">
                            <option value=\"javecoins\">JaveCoins</option>
                            <option value=\"pesos\">Pesos</option>
                        </select>
                        <br/>
                        <input type=\"submit\" value=\"Consignar\" name=\"cliente\"/>
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
                        Total consignación: <input type=\"number\" name=\"consignado\"/>
                        <select name=\"moneda\">
                            <option value=\"javecoins\">JaveCoins</option>
                            <option value=\"pesos\">Pesos</option>
                        </select>
                        <br/>
                        **Si usted es cliente, por favor inicie sesión<br/>
                        <input type=\"submit\" value=\"Pagar credito\" name=\"visitante\"/>
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
    if(isset($_POST['cliente'])){
        if($_POST['destino']=="ahorros") echo consignar_ahorros_cliente();
        if($_POST['destino']=="credito") echo pagar_credito_cliente();
    }
    if(isset($_POST['visitante'])) echo pagar_credito_visitante();
    if(isset($_POST['cerrar_sesion']))
    {
        unset($_SESSION['token']);
        header("Refresh:0");
    }