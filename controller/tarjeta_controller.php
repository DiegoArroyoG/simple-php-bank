<?php
    include_once dirname(__FILE__, 2) . '/repository/config.php';
    if(!isset($_SESSION)) session_start(); 

    function crear_tarjeta(){
        $html = "";
        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
        if (mysqli_connect_errno()) return $html.= "Error en la conexión: " . mysqli_connect_error();
        if (!isset($_SESSION['token'])) return $html.= "Debe iniciar sesión como cliente";
        $token=mysqli_real_escape_string($con, $_SESSION['token']);
        $sql = "SELECT PID FROM usuarios WHERE token='$token'";
        if(!$resultado_usuario = mysqli_query($con,$sql)) return $html.="Error de autenticación";
        if(!$usuario = mysqli_fetch_array($resultado_usuario)) return $html.="Error de autenticación";
        $sql = "INSERT INTO tarjeta_usuario (producto_id, usuario_id, cupo, sobrecupo, deuda, cuota, interes, aprobado) VALUES ('3', '{$usuario["PID"]}', '0', '0', '0', '0', '0', FALSE)";
        if(!mysqli_query($con,$sql)) return $html.= "Error en la creación de la tarjeta de credito";
        $sql = "SELECT PID FROM tarjeta_usuario WHERE usuario_id='{$usuario["PID"]}' ORDER BY PID DESC";
        $tarjeta_usuario = mysqli_query($con,$sql);
        $tarjeta = mysqli_fetch_array($tarjeta_usuario);
        $html.="Creación de la tarjeta de credito exitosa, su numero de tarjeta es {$tarjeta["PID"]}, queda pendiente de aprovación";
        mysqli_close($con);
        return $html;
    }
    function comprar(){
        $html = "";
        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
        if (mysqli_connect_errno()) return $html.= "Error en la conexión: " . mysqli_connect_error();
        if (!isset($_SESSION['token'])) return $html.= "Debe iniciar sesión como cliente";
        if (!isset($_POST['numero_cuenta']) || $_POST['numero_cuenta']<0) return $html.= "Numero de tarjeta invalido";
        if (!isset($_POST['consignado']) || $_POST['consignado']<0) return $html.= "Cantidad a pagar invalida";
        if (!isset($_POST['cuotas']) || $_POST['cuotas']<1 || $_POST['cuotas']>6) return $html.= "Las cuotas deben ser un valor entre 1 y 6";
        $token=mysqli_real_escape_string($con, $_SESSION['token']);
        $numero_cuenta=mysqli_real_escape_string($con, $_POST['numero_cuenta']);
        if($_POST["moneda"] == "javecoins") $consignado=mysqli_real_escape_string($con, $_POST['consignado']);
        else $consignado=mysqli_real_escape_string($con, $_POST['consignado'])/1000;
        $sql = "SELECT PID FROM usuarios WHERE token='$token'";
        if(!$resultado_usuario = mysqli_query($con,$sql)) return $html.="Error de autenticación";
        if(!$usuario = mysqli_fetch_array($resultado_usuario)) return $html.="Error de autenticación";
        $sql = "SELECT PID, cupo, deuda, aprobado FROM tarjeta_usuario WHERE PID='$numero_cuenta'";
        if(!$resultado_tarjeta = mysqli_query($con,$sql)) return $html.="Numero de tarjeta incorrecto";
        if(!$tarjeta = mysqli_fetch_array($resultado_tarjeta)) return $html.="Numero de tarjeta incorrecto";
        if($tarjeta['aprobado']==0) return $html.="Tarjeta de credito en proceso de aprovación";
        if(($resultado = $tarjeta['deuda']+$consignado)>$tarjeta['cupo']) return $html.="Cupo insuficiente";
        $sql = "UPDATE tarjeta_usuario SET deuda='$resultado' WHERE PID='{$tarjeta['PID']}'";
        if(mysqli_query($con,$sql)){
            $html.="Transaccion exitosa";
        }
        else{
            $html.= "Error en la transacción";
        }
        mysqli_close($con);
        return $html;
    }