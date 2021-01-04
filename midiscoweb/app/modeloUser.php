<?php 
include_once 'config.php';
/* DATOS DE USUARIO
â€¢ Identificador ( 5 a 10 caracteres, no debe existir previamente, solo letras y nÃºmeros)
â€¢ ContraseÃ±a ( 8 a 15 caracteres, debe ser segura)
â€¢ Nombre ( Nombre y apellidos del usuario
â€¢ Correo electrÃ³nico ( Valor vÃ¡lido de direcciÃ³n correo, no debe existir previamente)
â€¢ Tipo de Plan (0-BÃ¡sico |1-Profesional |2- Premium| 3- MÃ¡ster)
â€¢ Estado: (A-Activo | B-Bloqueado |I-Inactivo )
*/
// Inicializo el modelo 
// Cargo los datos del fichero a la session
function modeloUserInit(){
    
    /*
    $tusuarios = [ 
         "admin"  => ["12345"      ,"Administrado"   ,"admin@system.com"   ,3,"A"],
         "user01" => ["user01clave","Fernando PÃ©rez" ,"user01@gmailio.com" ,0,"A"],
         "user02" => ["user02clave","Carmen GarcÃ­a"  ,"user02@gmailio.com" ,1,"B"],
         "yes33" =>  ["micasa23"   ,"Jesica Rico"    ,"yes33@gmailio.com"  ,2,"I"]
        ];
    */
    if (! isset ($_SESSION['tusuarios'] )){
    $datosjson = @file_get_contents(FILEUSER) or die("ERROR al abrir fichero de usuarios");
    $tusuarios = json_decode($datosjson, true);
    $_SESSION['tusuarios'] = $tusuarios;
   }

   
}

// Comprueba usuario y contraseÃ±a (boolean)
function modeloOkUser($user,$clave){
    if(isset($_SESSION['tusuarios'][$user])){
        if($_SESSION['tusuarios'][$user][0]==$clave){
            return true;
        }
    }
    return false;
}


// Devuelve el plan de usuario (String)
function modeloObtenerTipo($user){
    return $_SESSION['tusuarios'][$user][3]; // MÃ¡ster
}

// Borrar un usuario (boolean)
function modeloUserDel($user){
    unset($_SESSION['tusuarios'][$user]);
    header("Location: index.php?orden=VerUsuarios");
}
// AÃ±adir un nuevo usuario (boolean)
function modeloUserAdd($idUsuario,$datos){
    $_SESSION['tusuarios'][$idUsuario]=$datos;
    modeloUserSave(); 
    
}

// Actualizar un nuevo usuario (boolean)
function modeloUserUpdate ($userid,$userdat){
    
}

// Tabla de todos los usuarios para visualizar
function modeloUserGetAll (){
    // Genero lo datos para la vista que no muestra la contraseÃ±a ni los cÃ³digos de estado o plan
    // sino su traducciÃ³n a texto
    $tuservista=[];
    foreach ($_SESSION['tusuarios'] as $clave => $datosusuario){
        $tuservista[$clave] = [$datosusuario[1],
                               $datosusuario[2],
                               PLANES[$datosusuario[3]],
                               ESTADOS[$datosusuario[4]]
                               ];
    }
    return $tuservista;
}
// Datos de un usuario para visualizar
function modeloUserGet ($user){
    
}

function validarId($idUsuario) {
    if(!existe($idUsuario)){
        if(strlen($idUsuario)>=5 && strlen($idUsuario)<=10){
            if (ctype_alnum($idUsuario)) {
                return true;
            }
        }
    }
    return false;
}
function existe($idUsuario){
    foreach ($_SESSION['tusuarios'] as $id => $datos){
        if($id ==$idUsuario){
            return true;
        }
    }
    return false;
}

function validarContra($contra){
    if(strlen($contra)>=8 && strlen($contra)<=15){
        return true;
    }
    return false;
}

function validarCorreo($correo,$idUsuario){
    if(!existeCorreo($correo)){
            if(filter_var($correo, FILTER_VALIDATE_EMAIL)==true){
                return true;
            }
    }
    return false;
}

function existeCorreo($correo){
    foreach ($_SESSION['tusuarios'] as $id => $datos){
        if( $datos[2]==$correo){
            return true;
        }
    }
    return false;
}

// Vuelca los datos al fichero
function modeloUserSave(){
    
    $datosjon = json_encode($_SESSION['tusuarios']);
    file_put_contents(FILEUSER, $datosjon) or die ("Error al escribir en el fichero.");
    //fclose($fich);
}
