<?php
    include_once(dirname(__FILE__, 2) . '/controller/admin_controller.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarjetas</title>
</head>
<body>
    <table style="width:100%">
        <tr>
            <th>Numero Tarjeta</th>
            <th>Usuario</th>
            <th>Acción</th>
        </tr>
        <?php
            $html="";
            foreach(tarjetas_desaprobadas() as $fila) {
                $html.=
                "<tr>
                    <td>{$fila['1']}</td> 
                    <td>{$fila['0']}</td> 
                    <td>
                        <form method=\"POST\" action=\"aprobar_tarjeta.php\">
                            <input type=\"hidden\" name=\"numero\" value=\"{$fila['1']}\"/>
                            <input type=\"submit\" value=\"Aprobar\"/>
                        </form>
                    </td>
                </tr>";
            }
            echo $html;
        ?>
    </table>
    <ul>
        <li>
            <form action="../index.php">
                <input type="submit" value="Volver"/>
            </form>
        </li>
    </ul>
</body>
</html>