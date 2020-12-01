<?php
    $resultado = "";
    include_once dirname(__FILE__, 2) . '/repository/config.php';
    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
    //------------------------------------------------------------------
    if (mysqli_connect_errno()) {
        $resultado.= "Error en la conexión: " . mysqli_connect_error();
    } else{
        //------------------------------------------------------------------
        $sql = "INSERT INTO productos (producto) VALUES ('Cuenta de ahorros')";
        if(mysqli_query($con,$sql)){
            $resultado.= "Se ha insertado a Cuenta de ahorros en productos <br>";
        }
        else{
            $resultado.= "Error insertando a Cuenta de ahorros en productos <br>";
        }
        $sql = "INSERT INTO productos (producto) VALUES ('Crédito')";
        if(mysqli_query($con,$sql)){
            $resultado.= "Se ha insertado a Crédito en productos <br>";
        }
        else{
            $resultado.= "Error insertando a Crédito en productos <br>";
        }
        $sql = "INSERT INTO productos (producto) VALUES ('Tarjeta de crédito')";
        if(mysqli_query($con,$sql)){
            $resultado.= "Se ha insertado a Tarjeta de crédito en productos <br>";
        }
        else{
            $resultado.= "Error insertando a Tarjeta de crédito en productos <br>";
        }
        //------------------------------------------------------------------
        $sql = "INSERT INTO roles (rol) VALUES ('Administrador')";
        if(mysqli_query($con,$sql)){
            $resultado.= "Se ha insertado a Administrador en roles <br>";
        }
        else{
            $resultado.= "Error insertando a Administrador en roles <br>";
        }
        $sql = "INSERT INTO roles (rol) VALUES ('Clientes')";
        if(mysqli_query($con,$sql)){
            $resultado.= "Se ha insertado a Clientes en roles <br>";
        }
        else{
            $resultado.= "Error insertando a Clientes en roles <br>";
        }
        $sql = "INSERT INTO roles (rol) VALUES ('Visitantes')";
        if(mysqli_query($con,$sql)){
            $resultado.= "Se ha insertado a Visitantes en roles <br>";
        }
        else{
            $resultado.= "Error insertando a Visitantes en roles <br>";
        }
        //------------------------------------------------------------------------
        $contrasena=password_hash("admin", PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (usuario, contrasena, rol_id, token) VALUES ('admin', '$contrasena', '1', '0')";
        if(mysqli_query($con,$sql)){
            $resultado.= "Se ha insertado a Admin en usuarios <br>";
        }
        else{
            $resultado.= "Error insertando a Admin en usuarios <br>";
        }
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