<?php 
ob_start()
?>

<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<form name='DETALLES' method="POST">
	<h2>Detalles de <?= $user?></h2>
	
	<p>Nombre: <?= $nombre?></p>
	<p>Correo Electrónico: <?= $correo?></p>
	<p>Plan: <?= $plan?></p>
	<p>Número de ficheros: 0</p>
	<p>Espacio ocupado: 0</p>
	
	<input type="submit" name="volver" value="Volver">
</form>
	
<?php 
$contenido=ob_get_clean();
include_once 'principal.php';
?>
