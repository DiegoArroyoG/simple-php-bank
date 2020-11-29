<?php
    include_once dirname(__FILE__, 2) . '/repository/config.php';
    if(!isset($_SESSION)) session_start(); 

    function crear_cuenta(){
        $html = "";
        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
        if (mysqli_connect_errno()) return $html.= "Error en la conexión: " . mysqli_connect_error();
        if (!isset($_SESSION['token'])) return $html.= "Debe iniciar sesión como cliente";
        if (!isset($_POST['fondos']) || $_POST['fondos']<0) return $html.= "Debe tener fondos suficientes";
        $token=mysqli_real_escape_string($con, $_SESSION['token']);
        $fondos=mysqli_real_escape_string($con, $_POST['fondos']);
        $sql = "SELECT PID FROM usuarios WHERE token='$token'";
        if(!$resultado_usuario = mysqli_query($con,$sql)) return $html.="Error de autenticación";
        if(!$usuario = mysqli_fetch_array($resultado_usuario)) return $html.="Error de autenticación";
        $sql = "INSERT INTO ahorros_usuario (producto_id, usuario_id, fondos) VALUES ('1', '{$usuario["PID"]}', '$fondos')";
        if(!mysqli_query($con,$sql)) return $html.= "Error en la creación de la cuenta de ahorros";
        $sql = "SELECT PID FROM ahorros_usuario WHERE usuario_id='{$usuario["PID"]}' ORDER BY PID DESC";
        $cuenta_usuario = mysqli_query($con,$sql);
        $cuenta = mysqli_fetch_array($cuenta_usuario);
        $html.="Creación de la cuenta de ahorros exitosa, su numero de cuenta es {$cuenta["PID"]}";
        mysqli_close($con);
        return $html;
    }

    function retirar(){
        $html = "";
        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
        if (mysqli_connect_errno()) return $html.= "Error en la conexión: " . mysqli_connect_error();
        if (!isset($_SESSION['token'])) return $html.= "Debe iniciar sesión como cliente";
        if (!isset($_POST['numero_cuenta']) || $_POST['numero_cuenta']<0) return $html.= "Numero de cuenta invalido";
        if (!isset($_POST['retiro']) || $_POST['retiro']<0) return $html.= "Cantidad a retirar invalida";
        $token=mysqli_real_escape_string($con, $_SESSION['token']);
        $numero_cuenta=mysqli_real_escape_string($con, $_POST['numero_cuenta']);
        $retiro=mysqli_real_escape_string($con, $_POST['retiro']);
        $sql = "SELECT PID FROM usuarios WHERE token='$token'";
        if(!$resultado_usuario = mysqli_query($con,$sql)) return $html.="Error de autenticación";
        if(!$usuario = mysqli_fetch_array($resultado_usuario)) return $html.="Error de autenticación";
        $sql = "SELECT PID, fondos FROM ahorros_usuario WHERE usuario_id='{$usuario['PID']}' AND PID='$numero_cuenta'";
        if(!$resultado_ahorros = mysqli_query($con,$sql)) return $html.="Numero de cuenta incorrecto";
        if(!$ahorros = mysqli_fetch_array($resultado_ahorros)) return $html.="Numero de cuenta incorrecto";
        if(($resultado = $ahorros['fondos']-$retiro)<0) return $html.="Fondos insuficientes";
        $sql = "UPDATE ahorros_usuario SET fondos='$resultado' WHERE PID='{$ahorros['PID']}'";
        if(mysqli_query($con,$sql)){
            $html.="Transaccion exitosa";
        }
        else{
            $html.= "Error en la transacción";
        }
        mysqli_close($con);
        return $html;
    }