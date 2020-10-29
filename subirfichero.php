<html>
<head>
<title>Procesa una subida de archivos </title>
<meta charset="UTF-8">
	<style>
        #formulario{
            text-align:center;
            border: 1px black solid;
            background:#99D19C;
            width:50%;
            margin-left:22%;
        }
    </style>
</head>
<?php

$codigosErrorSubida= [ 
    0 => 'Subida correcta',
    1 => 'El tamaño del archivo excede el admitido por el servidor',
    2 => 'El tamaño del archivo excede el admitido por el cliente',
    3 => 'El archivo no se pudo subir completamente',
    4 => 'No se selecciono ningun archivo para ser subido',
    6 => 'No existe un directorio temporal donde subir el archivo',
    7 => 'No se pudo guardar el archivo en disco',
    8 => 'Una extensión PHP evito la subida del archivo'
]; 

if (isset($_FILES['archivo1']['name'])) {
    $nombreFichero=$_FILES['archivo1']['name'];
    $numeroFicheros=count($nombreFichero);
    $tamanoFichero=array_sum($_FILES['archivo1']['size']);
    $directorioSubida = $_REQUEST['directorio'];
    $mensaje = '';
    if (($numeroFicheros>=2 && $tamanoFichero>300000) || ($numeroFicheros==1 && $tamanoFichero>200000)){
        $mensaje .= $codigosErrorSubida[1];
    }else{
        for($i=0;$i<$numeroFicheros;$i++){
            $nombreFichero=$_FILES['archivo1']['name'][$i];
            $ficheroTemporal=$_FILES['archivo1']['tmp_name'][$i];
            $errorFichero=$_FILES['archivo1']['error'][$i];
            $tipoFichero=$_FILES['archivo1']['type'][$i];
            if ($errorFichero > 0) {
                echo $mensaje .= $codigosErrorSubida[$errorFichero];
            }
            else{
                $mensaje .= "No hay errores en el archivo. <br><br>";
                if(comprobarImagen($tipoFichero)){
                    if ( is_dir($directorioSubida) && is_writable ($directorioSubida) && !file_exists($directorioSubida.'/'.$nombreFichero)) {
                      if (move_uploaded_file($ficheroTemporal,  $directorioSubida .'/'. $nombreFichero) == true) {
                          $mensaje .= 'Intentando subir el archivo: '.' <br />';
                          $mensaje .= "- Nombre: $nombreFichero" . ' <br />';
                          $mensaje .= '- Tamano: '.number_format(($tamanoFichero / 1000), 1, ',', '.').' KB <br />';
                          $mensaje .= "- Tipo: $tipoFichero" . ' <br />' ;
                          $mensaje .= "- Nombre archivo temporal: $ficheroTemporal".' <br />';
                          $mensaje .= "- Codigo de estado: $errorFichero".' <br />';
                          $mensaje .= '<br />RESULTADO:<br />';
                          $mensaje .= 'Archivo guardado en: '.$directorioSubida .'/'.$nombreFichero .' <br />';
                      } else {
                          $mensaje .= 'ERROR: Archivo no guardado correctamente <br />';
                      }
                  } else {
                      $mensaje .= 'ERROR: No es un directorio correcto, no se tiene permiso de escritura o el archivo ya existe. <br />';
                  }
                  
                }
                else{
                    $mensaje .= 'Formato incorrecto.';
                }
            }
        }
    }
} 
else 
{ 
    $mensaje .= $codigosErrorSubida[4];        
}
    
function comprobarImagen($tipoFichero){
    if(($tipoFichero=="image/png")==true || ($tipoFichero=="image/jpeg")== true){
        return true;
    }
    return false;    
}
?>

<body>
	<div id="formulario">
		<h2 style="color:5F00BA"><?php echo "Bienvenido ".$_REQUEST['nombre']."<br>"?></h2>
			<p style="color:6A1AC2; text-align:left; margin-left: 50px; margin-right:50px;"><?php echo $mensaje; ?></p>
			<br />
			<a href="subirfichero.html">Volver a la página de subida</a>
	</div>
</body>
</html>