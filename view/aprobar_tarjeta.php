<link rel="stylesheet" href="../CSS/register.css" type="text/css">

<div class="contenedor">
<?php
    include_once(dirname(__FILE__, 2) . '/controller/admin_controller.php');

    if(isset($_POST['numero']))
        if(($fila = tarjeta($_POST['numero']))!= null){
            $html=
            "<form method=\"POST\">
                Numero tarjeta: <input type=\"text\" name=\"PID\" value=\"{$fila['PID']}\" readonly><br>
                Cupo: <input type=\"number\" name=\"cupo\" value=\"{$fila['cupo']}\"><br>
                Sobrecupo: <input type=\"number\" name=\"sobrecupo\" value=\"{$fila['sobrecupo']}\"><br>
                Cuota de manejo: <input type=\"number\" name=\"cuota\" value=\"{$fila['cuota']}\"><br>
                Tasa de interés % (0.0-100.0): <input type=\"number\" name=\"interes\" value=\"{$fila['interes']}\"><br>
                <input type=\"submit\" value=\"Aprobar\" name=\"aprobar\"/>
            </form>
            <ul>
                <li>
                    <form action=\"administrar_tarjetas.php\">
                        <input type=\"submit\" value=\"Volver\"/>
                    </form>
                </li>
            </ul>";
            echo $html;
        }
    if(isset($_POST['aprobar'])) echo aprobar();
    ?>
</div>
