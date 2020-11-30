<?php
    include_once dirname(__FILE__, 2) . '/repository/config.php';
    if(!isset($_SESSION)) session_start(); 

    function consignar_ahorros_cliente(){
        $html = "";
        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
        if (mysqli_connect_errno()) return $html.= "Error en la conexión: " . mysqli_connect_error();
        if (!isset($_SESSION['token'])) return $html.= "Debe iniciar sesión como cliente";
        if (!isset($_POST['numero_cuenta']) || $_POST['numero_cuenta']<0) return $html.= "Numero de cuenta invalido";
        if (!isset($_POST['consignado']) || $_POST['consignado']<0) return $html.= "Cantidad a consignar invalida";
        $token=mysqli_real_escape_string($con, $_SESSION['token']);
        $numero_cuenta=mysqli_real_escape_string($con, $_POST['numero_cuenta']);
        $consignado=mysqli_real_escape_string($con, $_POST['consignado']);
        $sql = "SELECT PID FROM usuarios WHERE token='$token'";
        if(!$resultado_usuario = mysqli_query($con,$sql)) return $html.="Error de autenticación";
        if(!$usuario = mysqli_fetch_array($resultado_usuario)) return $html.="Error de autenticación";
        $sql = "SELECT PID, fondos FROM ahorros_usuario WHERE usuario_id='{$usuario['PID']}' AND PID='$numero_cuenta'";
        if(!$resultado_ahorros = mysqli_query($con,$sql)) return $html.="Numero de cuenta incorrecto";
        if(!$ahorros = mysqli_fetch_array($resultado_ahorros)) return $html.="Numero de cuenta incorrecto";
        $resultado = $ahorros['fondos']+$consignado;
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
    function pagar_credito_cliente(){
        $html = "";
        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
        if (mysqli_connect_errno()) return $html.= "Error en la conexión: " . mysqli_connect_error();
        if (!isset($_SESSION['token'])) return $html.= "Debe iniciar sesión como cliente";
        if (!isset($_POST['consignado']) || $_POST['consignado']<0) return $html.= "Cantidad a consignar invalida";
        if($_POST["moneda"] == "pesos" && $_POST['consignado']<1000) return $html.= 'La consignacion en pesos minima es $1000';
        $token=mysqli_real_escape_string($con, $_SESSION['token']);
        if($_POST["moneda"] == "javecoins") $consignado=mysqli_real_escape_string($con, $_POST['consignado']);
        else $consignado=mysqli_real_escape_string($con, $_POST['consignado'])/1000;
        $sql = "SELECT PID FROM usuarios WHERE token='$token'";
        if(!$resultado_usuario = mysqli_query($con,$sql)) return $html.="Error de autenticación";
        if(!$usuario = mysqli_fetch_array($resultado_usuario)) return $html.="Error de autenticación";
        $sql = "SELECT PID, credito, abono FROM credito_usuario WHERE usuario_id='{$usuario['PID']}'";
        if(!$resultado_credito = mysqli_query($con,$sql)) return $html.="No tiene ningún credito vigente";
        if(!$credito = mysqli_fetch_array($resultado_credito)) return $html.="No tiene ningún credito vigente";
        $deuda=$credito['credito']-$credito['abono'];
        if(($resultado = $deuda-$consignado)<0) return $html.="Su pago es mayor a lo que adeuda, su deuda es de $deuda";
        $abono=$credito['abono']+$consignado;
        $sql = "UPDATE credito_usuario SET abono='$abono' WHERE PID='{$credito['PID']}'";
        if(mysqli_query($con,$sql)){
            $html.="Transaccion exitosa";
        }
        else{
            $html.= "Error en la transacción";
        }
        mysqli_close($con);
        return $html;
    }
    function pagar_credito_visitante(){
        $html = "";
        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
        if (mysqli_connect_errno()) return $html.= "Error en la conexión: " . mysqli_connect_error();
        if (!isset($_POST['email'])) return $html.= "Debe ingresar un email valido";
        if (!isset($_POST['consignado']) || $_POST['consignado']<0) return $html.= "Cantidad a consignar invalida";
        if($_POST["moneda"] == "pesos" && $_POST['consignado']<1000) return $html.= 'La consignacion en pesos minima es $1000';
        $email=mysqli_real_escape_string($con, $_POST['email']);
        if($_POST["moneda"] == "javecoins") $consignado=mysqli_real_escape_string($con, $_POST['consignado']);
        else $consignado=mysqli_real_escape_string($con, $_POST['consignado'])/1000;
        $sql = "SELECT PID, credito, abono FROM credito_usuario WHERE usuario_id='$email'";
        if(!$resultado_credito = mysqli_query($con,$sql)) return $html.="No tiene ningún credito vigente";
        if(!$credito = mysqli_fetch_array($resultado_credito)) return $html.="No tiene ningún credito vigente";
        $deuda=$credito['credito']-$credito['abono'];
        if(($resultado = $deuda-$consignado)<0) return $html.="Su pago es mayor a lo que adeuda, su deuda es de $deuda";
        $abono=$credito['abono']+$consignado;
        $sql = "UPDATE credito_usuario SET abono='$abono' WHERE PID='{$credito['PID']}'";
        if(mysqli_query($con,$sql)){
            $html.="Transaccion exitosa";
        }
        else{
            $html.= "Error en la transacción";
        }
        mysqli_close($con);
        return $html;
    }