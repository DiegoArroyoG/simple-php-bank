<?php
    include_once dirname(__FILE__, 2) . '/repository/config.php';
    if(!isset($_SESSION)) session_start(); 

    function generate_token($length = 100) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    function registrar(){
        $html = "";
        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
        if (mysqli_connect_errno()) return $html.= "Error en la conexión: " . mysqli_connect_error();
        $usuario=mysqli_real_escape_string($con, $_POST['usuario']);
        $contrasena=password_hash(mysqli_real_escape_string($con, $_POST['contrasena']), PASSWORD_DEFAULT);
        $token = generate_token();
        $sql = "INSERT INTO usuarios (usuario, contrasena, rol_id, token) VALUES ('$usuario', '$contrasena', '2', '$token')";
        if(mysqli_query($con,$sql)){
            $_SESSION['token']=$token;
            $html.= "Registro del usuario $usuario exitoso";
        }
        else{
            $html.= "Error en el registro del usuario $usuario, el usuario ya existe";
        }
        mysqli_close($con);
        return $html;
    }
    function autenticar(){
        $html = "";
        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
        if (mysqli_connect_errno()) return $html.= "Error en la conexión: " . mysqli_connect_error();
        $usuario=mysqli_real_escape_string($con, $_POST['usuario']);
        $contrasena=mysqli_real_escape_string($con, $_POST['contrasena']);
        $sql = "SELECT PID, contrasena FROM usuarios WHERE usuario='$usuario'";
        if(!$resultado_usuario = mysqli_query($con,$sql)) return $html.="Usuario inexistente";
        if(!$usuario_sql = mysqli_fetch_array($resultado_usuario)) return $html.="Usuario inexistente";
        if(!password_verify($contrasena, $usuario_sql['contrasena'])) return $html.="Error de autenticación";
        $token = generate_token();
        $sql = "UPDATE usuarios SET token='$token' WHERE PID='{$usuario_sql['PID']}'";
        if(mysqli_query($con,$sql)){
            $_SESSION['token']=$token;
            $html.= "Autenticación del usuario $usuario exitoso";
        }
        else{
            $html.= "Error en la autenticación del usuario $usuario";
        }
        mysqli_close($con);
        return $html;
    }