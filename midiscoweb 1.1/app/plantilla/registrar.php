<?php 
ob_start()
?>

<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<form name='REGISTRAR' method="POST" action="index.php?orden=Registrar">
	<h2>Alta de usuarios</h2>
	<label>Identificador</label><input type="text" name="id"><br>
	<label>Nombre</label><input type="text" name="nombre"><br>
	<label>Correo Electr�nico</label><input type="email" name="correo"><br>
	<label>Contrase�a</label><input type="password" name="clave"><br>
	<label>Repite Contrase�a </label><input type="password" name="clave2"><br>
	
	<label>Plan</label><select name="plan" size="3">
		<option value="0" selected>B�sico</option>
		<option value="1">Profesional</option>
		<option value="2">Premium</option>
		<option value="3">M�ster</option>
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