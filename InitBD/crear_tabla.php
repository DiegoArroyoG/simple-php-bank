<?php
    $resultado = "";
    include_once dirname(__FILE__, 2) . '/repository/config.php';
    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
    //------------------------------------------------------------------
    $sql = "CREATE TABLE roles 
    (
    PID INT NOT NULL AUTO_INCREMENT, 
    PRIMARY KEY(PID),
    rol CHAR(15) NOT NULL,
    UNIQUE KEY rol(rol)
    )";
    if (mysqli_query($con, $sql)) {
        $resultado.= "Tabla roles creada correctamente<br>";
    } else {
        $resultado.= "Error en la creacion de la tabla roles " . mysqli_error($con) . "<br>";
    }
    //------------------------------------------------------------------
    $sql = "CREATE TABLE usuarios 
    (
    PID INT NOT NULL AUTO_INCREMENT, 
    PRIMARY KEY(PID),
    usuario CHAR(50) NOT NULL,
    contrasena VARCHAR(255),
    rol_id INT NOT NULL,
    token CHAR(100),
    UNIQUE KEY usuario(usuario),
    UNIQUE KEY token(token),
    FOREIGN KEY (rol_id) REFERENCES roles(PID)
    )";
    if (mysqli_query($con, $sql)) {
        $resultado.= "Tabla usuarios creada correctamente<br>";
    } else {
        $resultado.= "Error en la creacion de la tabla usuarios " . mysqli_error($con)."<br>";
    }
    //------------------------------------------------------------------
    $sql = "CREATE TABLE productos 
    (
    PID INT NOT NULL AUTO_INCREMENT, 
    PRIMARY KEY(PID),
    producto CHAR(50) NOT NULL,
    UNIQUE KEY producto(producto)
    )";
    if (mysqli_query($con, $sql)) {
        $resultado.= "Tabla productos creada correctamente<br>";
    } else {
        $resultado.= "Error en la creacion de la tabla productos " . mysqli_error($con)."<br>";
    }
    //------------------------------------------------------------------
    $sql = "CREATE TABLE tarjeta_usuario 
    (
    PID INT NOT NULL AUTO_INCREMENT, 
    PRIMARY KEY(PID),
    producto_id INT NOT NULL,
    usuario_id INT NOT NULL,
    numero INT NOT NULL, 
    cupo INT NOT NULL,
    sobrecupo INT NOT NULL,
    cuota INT NOT NULL,
    interes DECIMAL(9, 8) NOT NULL,
    UNIQUE KEY numero(numero),
    FOREIGN KEY (producto_id) REFERENCES usuarios(PID),
    FOREIGN KEY (usuario_id) REFERENCES productos(PID)
    )";
    if (mysqli_query($con, $sql)) {
        $resultado.= "Tabla tarjeta_usuario creada correctamente <br>";
    } else {
        $resultado.= "Error en la creacion de la tabla tarjeta_usuario " . mysqli_error($con)."<br>";
    }
    //------------------------------------------------------------------
    $sql = "CREATE TABLE ahorros_usuario 
    (
    PID INT NOT NULL AUTO_INCREMENT, 
    PRIMARY KEY(PID),
    producto_id INT NOT NULL,
    usuario_id INT NOT NULL,
    fondos INT NOT NULL,
    FOREIGN KEY (producto_id) REFERENCES usuarios(PID),
    FOREIGN KEY (usuario_id) REFERENCES productos(PID)
    )";
    if (mysqli_query($con, $sql)) {
        $resultado.= "Tabla ahorros_usuario creada correctamente <br>";
    } else {
        $resultado.= "Error en la creacion de la tabla ahorros_usuario " . mysqli_error($con)."<br>";
    }
    //------------------------------------------------------------------
    $sql = "CREATE TABLE credito_usuario 
    (
    PID INT NOT NULL AUTO_INCREMENT, 
    PRIMARY KEY(PID),
    producto_id INT NOT NULL,
    usuario_id INT NOT NULL,
    credito INT NOT NULL, 
    abono INT NOT NULL,
    interes DECIMAL(9, 8) NOT NULL,
    fecha_pago DATE NOT NULL,
    FOREIGN KEY (producto_id) REFERENCES usuarios(PID),
    FOREIGN KEY (usuario_id) REFERENCES productos(PID)
    )";
    if (mysqli_query($con, $sql)) {
        $resultado.= "Tabla credito_usuario creada correctamente <br>";
    } else {
        $resultado.= "Error en la creacion de la tabla credito_usuario " . mysqli_error($con)."<br>";
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