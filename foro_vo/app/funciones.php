<?php
function usuarioOk($usuario, $contrasenia) :bool {
  
    return ( $contrasenia==strrev($usuario) && strlen($usuario)>=8);
    
}

