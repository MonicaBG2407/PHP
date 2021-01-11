<?php
// ------------------------------------------------
// Controlador que realiza la gestiÃ³n de usuarios
// ------------------------------------------------
include_once 'config.php';
include_once 'AccesoDatos.php';

/*
 * Inicio Muestra o procesa el formulario (POST)
 */

function  ctlUserInicio(){
    $msg = "";
    $user ="";
    $clave ="";
    if ( $_SERVER['REQUEST_METHOD'] == "POST"){
        if (isset($_POST['user']) && isset($_POST['clave'])){
            $idUsuario =$_POST['user'];
            $clave=$_POST['clave'];
            $usuario=user($idUsuario);
            
            if ( modeloOkUser($usuario,$clave)){
                if ( modeloObtenerTipo($usuario)){
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
        limpiarArrayEntrada($_POST);
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
        $idUsuario=$_GET['id'];
        $db = AccesoDatos::getModelo();
        $user = $db->getUsuario($idUsuario);
    }
    include_once 'plantilla/detallesUser.php';
}
    


function ctlUserModificar() {
    $msg="";
    $user="";
    $error=false;
    if (isset($_GET['id'])){
        $idUsuario=$_GET['id']; 
        $db = AccesoDatos::getModelo();
        $user = $db->getUsuario($idUsuario);
        
    }else {
        $idUsuario=$_POST['id']; 
        $db = AccesoDatos::getModelo();
        $user = $db->getUsuario($idUsuario);
        
    }
    if(isset($_POST['cancelar'])){
        header("Location: index.php?orden=VerUsuarios");
    }else if(isset($_POST['modificar'])){
        limpiarArrayEntrada($_POST);
    
        $user2 = new Usuario();
        $user2->id  = $_POST['id'];
        $user2->plan = $_POST['plan'];
        $user2->estado = $_POST['estado'];
        $user2->nombre  = $_POST['nombre'];
        
        if(!validarContra($_POST['clave'])){
            $msg="La contraseña tiene que tener entre 8-15 caracteres.";
            $error=true;
            
        }else {
            $user2->pass  = $_POST['clave'];
        }
        if($user->mail!=$_POST['correo']){
            if(!validarCorreo($_POST['correo'], $user->id)){
                $msg="El correo está repetido o no es válido.";
                $error=true;
            }else{
                $user2->mail  = $_POST['correo'];
            }
            
        }else{
            $user2->mail  = $_POST['correo'];
        }
        if(!$error){
        
        $db = AccesoDatos::getModelo();
        $db->modUsuario($user2);
        header("Location: index.php?orden=VerUsuarios");
        }
        
        
    }
    include_once 'plantilla/modificarUser.php';
    
    
}

function ctlUserBorrar() {
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $db=AccesoDatos::getModelo();
        $tuser=$db->borrarUsuario($id);
        header("Refresh:0; url=index.php?orden=VerUsuarios");
    }
    
    
}

// Cierra la sesiÃ³n y vuelva los datos
function ctlUserCerrar(){
    session_destroy();
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
        limpiarArrayEntrada($_POST);
        $msg=altaRegistrar($msg, $error);
    }
    if(isset($_POST['cancelar'])){
        header("Refresh:0; url=index.php");
    }
    include_once 'plantilla/registrar.php';
}

function altaRegistrar($msg, $error){
    $user2 = new Usuario();
    $user2->plan = $_POST['plan'];
    $user2->nombre  = $_POST['nombre'];
    $user2->estado  ="I";
    
    $idUsuario=$_POST['id'];
    $contra=$_POST['clave'];
    $correo=$_POST['correo'];
    if(!validarId($idUsuario)){
        $msg="El usuario esta repetido o debe contener entre 5-10 caracteres alfanumericos.";
        $error=true;
    }else{  
        $user2->id  = $_POST['id'];   
    }
    if(!validarcontra($contra)){
        $msg="La contraseña tiene que tener entre 8-15 caracteres.";
        $error=true;
    }else{
        $user2->pass  = $_POST['clave'];
    }
    if(!validarCorreo($correo, $idUsuario)){
        $msg="El correo ya existe o no es válido.";
        $error=true;
    }else{
        $user2->mail  = $_POST['correo'];
    }
    if(!$error){
        $db = AccesoDatos::getModelo();
        $db->addUsuario($user2);
        header("Location: index.php?orden=VerUsuarios");
    }
    
    return $msg;
}

function user($idUsuario){
    
    $db = AccesoDatos::getModelo();
    $user = $db->getUsuario($idUsuario);
    
    return $user;
}

function limpiarEntrada(string $entrada):string{
    $salida = trim($entrada); // Elimina espacios antes y después de los datos
    $salida = strip_tags($salida); // Elimina marcas
    return $salida;
}
// Función para limpiar todos elementos de un array
function limpiarArrayEntrada(array &$entrada){
    
    foreach ($entrada as $key => $value ) {
        $entrada[$key] = limpiarEntrada($value);
    }
}
