<?php
    $resultado;
    include_once dirname(__FILE__, 2) . '/repository/config.php';
    $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS);
    $sql="CREATE DATABASE proyecto";
    if (mysqli_query($con,$sql)) {
		    $resultado = "Base de datos 'proyecto' creada";
    } else {
		    $resultado = "Error en la creacion " . mysqli_error($con);
    }
    $resultado.=
    "<ul>
        <li>
            <form action=\"../index.php\">
                <input type=\"submit\" value=\"Volver\"/>
            </form>
        </li>
    </ul>";
    echo $resultado;
    mysqli_close($con);
?>