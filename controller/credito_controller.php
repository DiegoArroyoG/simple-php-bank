<?php
    include_once dirname(__FILE__, 2) . '/repository/config.php';
    if(!isset($_SESSION)) session_start(); 

    function crear_credito_visitante(){
        $html = "";
        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
        if (mysqli_connect_errno()) return $html.= "Error en la conexión: " . mysqli_connect_error();
        if (!isset($_POST['email'])) return $html.= "Debe ingresar un email valido";
        if (!isset($_POST['credito']) || $_POST['credito']<=0) return $html.= "Debe pedir un credito valido";
        $email=mysqli_real_escape_string($con, $_POST['email']);
        $credito=mysqli_real_escape_string($con, $_POST['credito']);
        $dia=date("d");
        $sql = "INSERT INTO credito_usuario (producto_id, usuario_id, credito, abono, interes, aprobado, fecha_pago) VALUES ('2', '$email', '$credito', '0', '0.128', FALSE, '$dia')";
        if(!mysqli_query($con,$sql)) return $html.= "Error en la creación de su crédito";
        $html.="Creación de su créditos exitosa, queda en espera de aprobación";
        mysqli_close($con);
        return $html;
    }
    function crear_credito_cliente(){
        $html = "";
        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
        if (mysqli_connect_errno()) return $html.= "Error en la conexión: " . mysqli_connect_error();
        if (!isset($_SESSION['token'])) return $html.= "Debe iniciar sesión como cliente";
        if (!isset($_POST['credito']) || $_POST['credito']<=0) return $html.= "Debe pedir un credito valido";
        if (!isset($_POST['tasa']) || $_POST['tasa']<=0) return $html.= "Debe proponer una tasa valida";
        $token=mysqli_real_escape_string($con, $_SESSION['token']);
        $credito=mysqli_real_escape_string($con, $_POST['credito']);
        $tasa=mysqli_real_escape_string($con, $_POST['tasa'])/100;
        $sql = "SELECT PID FROM usuarios WHERE token='$token'";
        if(!$resultado_usuario = mysqli_query($con,$sql)) return $html.="Error de autenticación";
        if(!$usuario = mysqli_fetch_array($resultado_usuario)) return $html.="Error de autenticación";
        $dia=date("d");
        $sql = "INSERT INTO credito_usuario (producto_id, usuario_id, credito, abono, interes, aprobado, fecha_pago) VALUES ('2', '{$usuario["PID"]}', '$credito', '0', '$tasa', FALSE, '$dia')";
        if(!mysqli_query($con,$sql)) return $html.= "Error en la creación de su crédito";;
        $html.="Creación de su créditos exitosa, queda en espera de aprobación";
        mysqli_close($con);
        return $html;
    }