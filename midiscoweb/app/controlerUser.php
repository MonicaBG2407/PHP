<?php
// ------------------------------------------------
// Controlador que realiza la gestiÃ³n de usuarios
// ------------------------------------------------
include_once 'config.php';
include_once 'modeloUser.php';

/*
 * Inicio Muestra o procesa el formulario (POST)
 */

function  ctlUserInicio(){
    $msg = "";
    $user ="";
    $clave ="";
    if ( $_SERVER['REQUEST_METHOD'] == "POST"){
        if (isset($_POST['user']) && isset($_POST['clave'])){
            $user =$_POST['user'];
            $clave=$_POST['clave'];
            if ( modeloOkUser($user,$clave)){
                $_SESSION['user'] = $user;
                $_SESSION['tipouser'] = modeloObtenerTipo($user);
                echo  $_SESSION['tipouser'];
                if ( $_SESSION['tipouser'] == "3"){
                    $_SESSION['modo'] = GESTIONUSUARIOS;
                    header('Location:index.php?orden=VerUsuarios');
                }
                else {
                  // Usuario normal;
                  // PRIMERA VERSIÃ“N SOLO USUARIOS ADMISTRADORES
                  $msg="Error: Acceso solo permitido a usuarios Administradores.";
                  // $_SESSION['modo'] = GESTIONFICHEROS;
                  // Cambio de modo y redireccion a verficheros
                }
            }
            else {
                $msg="Error: usuario y contraseÃ±a no vÃ¡lidos.";
           }  
        }
    }
    
    include_once 'plantilla/facceso.php';
}

function ctlUserAlta(){
    $msg="";
    $error=false;
    if ( isset($_POST['alta'])){
        $msg=altaRegistrar($msg, $error);
    }
    if(isset($_POST['cancelar'])){
        header("Refresh:0; url=index.php?orden=VerUsuarios");
    }
    include_once 'plantilla/fnuevo.php';
}


function ctlUserDetalles() {
    
    if(isset($_POST['volver'])){
        header("Location: index.php?orden=VerUsuarios");
    }else{
        $user ="";
        $nombre="";
        $correo="";
        $plan="";
        if(isset($_GET['id'])){
            $user=$_GET['id'];
            $nombre= $_SESSION['tusuarios'][$user][1];
            $correo= $_SESSION['tusuarios'][$user][2];
            $plan=PLANES[$_SESSION['tusuarios'][$user][3]];
            $tipouser=$_SESSION['tipouser'];
        }
        include_once 'plantilla/detallesUser.php';
    }
    
}

function ctlUserModificar() {
    if(isset($_GET['id'])){
    $idUsuario=$_GET['id']; 
    $nombre=$_SESSION['tusuarios'][$idUsuario][1];
    $correo=$_SESSION['tusuarios'][$idUsuario][2];
    $contra=$_SESSION['tusuarios'][$idUsuario][0];
    $estado=$_SESSION['tusuarios'][$idUsuario][4];
    $plan=$_SESSION['tusuarios'][$idUsuario][3];
    }
    if(isset($_POST['cancelar'])){
        header("Location: index.php?orden=VerUsuarios");
    }
    if (isset($_POST['modificar'])){
        $idUsuario=$_POST['id'];
        $contra=$_POST['clave'];
        $correo=$_POST['correo'];
        
        $_SESSION['tusuarios'][$_POST['id']][1]=$_POST['nombre'];
        $_SESSION['tusuarios'][$_POST['id']][3]=$_POST['plan'];
        $_SESSION['tusuarios'][$_POST['id']][4]=$_POST['estado'];
        
        if (!validarcontra($contra)){
            $msg="La contraseña tiene que tener entre 8-15 caracteres.";
            $error=true;
        }else {
            $_SESSION['tusuarios'][$_POST['id']][0]=$_POST['clave'];
        }
        
        if($_SESSION['tusuarios'][ $_POST['id']][2]!=$correo){
            if(!validarCorreo($correo, $idUsuario)){
                $msg="El correo está repetido o no es válido.";
                $error=true;
            }else{
                $_SESSION['tusuarios'][$_POST['id']][2]=$_POST['correo'];
            }        
        }
        header("Location: index.php?orden=VerUsuarios");
    }
    
    
    include_once 'plantilla/modificarUser.php';
    
}

function ctlUserBorrar() {
    $user=$_GET['id'];
    modeloUserDel($user);
    
}

// Cierra la sesiÃ³n y vuelva los datos
function ctlUserCerrar(){
    session_destroy();
    modeloUserSave();
    header('Location:index.php');
}

// Muestro la tabla con los usuario 
function ctlUserVerUsuarios (){
    // Obtengo los datos del modelo
    $usuarios = modeloUserGetAll(); 
    // Invoco la vista 
    include_once 'plantilla/verusuariosp.php';
   
}


function ctlUserRegistro() {
    $msg="";
    $error=false;
    if ( isset($_POST['alta'])){
        $msg=altaRegistrar($msg, $error);
    }
    if(isset($_POST['cancelar'])){
        header("Refresh:0; url=index.php");
    }
    include_once 'plantilla/registrar.php';
}

function altaRegistrar($msg, $error){
    $idUsuario=$_POST['id'];
    $contra=$_POST['clave'];
    $correo=$_POST['correo'];
    var_dump($_POST);
    if(!validarId($idUsuario)){
        $msg="El usuario esta repetido o debe contener entre 5-10 caracteres alfanumericos.";
        $error=true;
    }
    if(!validarcontra($contra)){
        $msg="La contraseña tiene que tener entre 8-15 caracteres.";
        $error=true;
    }
    if(!validarCorreo($correo, $idUsuario)){
        $msg="El correo ya existe o no es válido.";
        $error=true;
    }
    if(!$error){
        $datos=array ($_POST['clave'],$_POST['nombre'],$_POST['correo'],$_POST['plan'],"I");
        modeloUserAdd($idUsuario,$datos);
    }
    return $msg;
}
