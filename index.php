<link rel="stylesheet" href="CSS/principal.css" type="text/css">

<?php
    include_once(dirname(__FILE__) . '/controller/ahorros_controller.php');
    include_once(dirname(__FILE__) . '/controller/tarjeta_controller.php');
    
    if(!isset($_SESSION)) session_start(); 
?>



<!DOCTYPE html>
<html lang="en">

<div class="todo">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto</title>
</head>
<body>
    
    <div class="contenedor-notas">
        <h3>Nota:</h3>
        <p>En el primer inicio del programa no olvidar ejecutar las siguientes funcionalidades:<p>
        <ul>
            <li>
                <form action="InitBD/crear_db.php">
                    <input type="submit" value="Crear Base de datos" />
                </form>
            </li>
            <li>
                <form action="InitBD/crear_tabla.php">
                    <input type="submit" value="Crear Tabla" />
                </form>
            </li>
            <li>
                <form action="InitBD/insertar_datos.php">
                    <input type="submit" value="Insertar datos" />
                </form>
            </li>
        </ul>
    </div>

    <div class="proyecto">

        <div class="auten">
            <?php
            if(isset($_SESSION['token'])){
                echo "<form method=\"POST\">
                        <input type=\"submit\" value=\"Cerrar sesion\" name=\"cerrar_sesion\"/>
                    </form>";
            } else echo "<ul style=\"margin: 0; padding: 0; display:inline-block;\">
                    <li style=\"display:inline-block;\"><a href=\"view/login.php\"><button>Iniciar sesion</button></a></li>
                    <li style=\"display:inline-block;\"><a href=\"view/register.php\"><button>Registrarse</button></a></li>
                </ul>";
            if(isset($_POST['cerrar_sesion']))
            {
                unset($_SESSION['token']);
                header("Refresh:0");
            }
            ?>
        </div>
        <div class="funcionalidad">
            <h1>Banco</h1>
            <form method="POST">
                Fondos: <input type="number" name="fondos"/>
                <input type="submit" value="Crear cuenta de ahorros" name="crear_cuenta"/>
                <br>
                Numero de cuenta: <input type="number" name="numero_cuenta"/>
                Retiro: <input type="number" name="retiro"/>
                <input type="submit" value="Retirar" name="retirar"/>
                <br><br>
                <input type="submit" value="Pedir credito" formaction="view/credito.php"/>
                <br><br>
                <input type="submit" value="Consignar" formaction="view/consignar.php"/>
                <br><br>
                <input type="submit" value="Solicitar tarjeta de credito" name="tarjeta"/>
                <br>
                Numero de tarjeta: <input type="number" name="numero_cuenta"/>
                Cuotas: <input type="number" name="cuotas"/>
                Precio de la compra: <input type="number" name="consignado"/>
                <select name="moneda">
                    <option value="javecoins">JaveCoins</option>
                    <option value="pesos">Pesos</option>
                </select>
                <input type="submit" value="Comprar" name="comprar"/>
                <br><br>
                <input type="submit" value="Administrar tarjetas" formaction="view/administrar_tarjetas.php"/>
            </form>
        </div>

        <aside class ="lado">
        <?php
            if(isset($_POST['crear_cuenta'])) echo crear_cuenta();
            if(isset($_POST['retirar'])) echo retirar();
            if(isset($_POST['tarjeta'])) echo crear_tarjeta();
            if(isset($_POST['comprar'])) echo comprar();
        ?>
        </aside>

    </div>
    
</body>
</div>

</html>
