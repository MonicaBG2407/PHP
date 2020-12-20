<?php

// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();
// FORMULARIO DE ALTA DE USUARIOS
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<form name='ALTA' method="POST" action="index.php?orden=Alta">
	<h2>Alta de usuarios</h2>
	<label>Identificador</label><input type="text" name="id"><br>
	<label>Nombre</label><input type="text" name="nombre"><br>
	<label>Correo Electrónico</label><input type="email" name="correo"><br>
	<label>Contraseña</label><input type="password" name="clave"><br>
	<label>Repite Contraseña </label><input type="password" name="clave2"><br>
	
	<label>Plan</label><select name="plan" size="3">
		<option value="0" selected="selected">Básico</option>
		<option value="1">Profesional</option>
		<option value="2">Premium</option>
		<option value="3">Máster</option>
	</select><br>
	
	<input type="submit" name="alta" value="Alta">
	<input type="submit" name="cancelar" value="Cancelar">
</form>
<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "principal.php";

?>