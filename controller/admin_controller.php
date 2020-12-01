<?php
    include_once dirname(__FILE__, 2) . '/repository/config.php';
    if(!isset($_SESSION)) session_start(); 

    function tarjetas_desaprobadas(){
        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
        if (mysqli_connect_errno()) return [];
        if (!isset($_SESSION['token'])) return [];
        $token=mysqli_real_escape_string($con, $_SESSION['token']);
        $sql = "SELECT PID FROM usuarios WHERE token='$token' AND rol_id='1'";
        if(!$resultado_usuario = mysqli_query($con,$sql)) return [];
        if(!$usuario = mysqli_fetch_array($resultado_usuario)) return [];
        $sql = "SELECT usuarios.usuario, tarjeta_usuario.PID 
                FROM tarjeta_usuario 
                inner join usuarios on tarjeta_usuario.usuario_id=usuarios.PID 
                WHERE tarjeta_usuario.aprobado = 0";
        if(!$tarjetas_query = mysqli_query($con,$sql)) return [];
        if(!$tarjetas= mysqli_fetch_all($tarjetas_query)) return [];
        mysqli_close($con);
        return $tarjetas;
    }
    function tarjeta($pid){
        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
        if (mysqli_connect_errno()) return null;
        if (!isset($_SESSION['token'])) return null;
        $token=mysqli_real_escape_string($con, $_SESSION['token']);
        $sql = "SELECT PID FROM usuarios WHERE token='$token' AND rol_id='1'";
        if(!$resultado_usuario = mysqli_query($con,$sql)) return null;
        if(!$usuario = mysqli_fetch_array($resultado_usuario)) return null;
        $sql = "SELECT * FROM tarjeta_usuario WHERE PID='$pid'";
        if(!$tarjetas_query = mysqli_query($con,$sql)) return null;
        if(!$tarjetas= mysqli_fetch_array($tarjetas_query)) return null;
        mysqli_close($con);
        return $tarjetas;
    }
    function aprobar(){
        $html = "";
        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
        if (mysqli_connect_errno()) return $html.= "Error en la conexión: " . mysqli_connect_error();
        if (!isset($_SESSION['token'])) return $html.= "Debe iniciar sesión como administrador";
        if (!isset($_POST['PID'])) return $html.= "Error de numero de tarjeta";
        if (!isset($_POST['cupo']) || $_POST['cupo']<0) return $html.= "Error de cupo";
        if (!isset($_POST['sobrecupo']) || $_POST['sobrecupo']<0) return $html.= "Error de sobrecupo";
        if (!isset($_POST['cuota']) || $_POST['cuota']<0) return $html.= "Error de cuota";
        if (!isset($_POST['interes']) || $_POST['interes']<0) return $html.= "Error de interes";
        $token=mysqli_real_escape_string($con, $_SESSION['token']);
        $sql = "SELECT PID FROM usuarios WHERE token='$token' AND rol_id='1'";
        if(!$resultado_usuario = mysqli_query($con,$sql)) return $html.="Error de autenticación";
        if(!$usuario = mysqli_fetch_array($resultado_usuario)) return $html.="Error de autenticación";
        $interes=$_POST['interes']/100;
        $sql = "UPDATE tarjeta_usuario SET cupo='{$_POST['cupo']}', sobrecupo='{$_POST['sobrecupo']}', cuota='{$_POST['cuota']}', interes='$interes', aprobado='1' WHERE PID='{$_POST['PID']}'";
        if(mysqli_query($con,$sql)){
            $html.="Tarjeta aprobada";
        }
        else{
            $html.= "Error en la aprobación";
        }
        mysqli_close($con);
        return $html;
    }