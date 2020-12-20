<?php 
ob_start()
?>

<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<form name='MODIFICAR' method="POST" action="index.php?orden=Modificar">
	<h2>Modificar Usuario</h2>
	<label>Identificador</label><input type="text" name="id" value="<?=(isset($_POST['id']))?$_POST['id']:$idUsuario?>" readonly><br>
	<label>Nombre</label><input type="text" name="nombre" value="<?=(isset($_POST['nombre']))?$_POST['nombre']:$nombre?>"><br>
	<label>Correo Electrónico</label><input type="email" name="correo" value="<?=(isset($_POST['correo']))?$_POST['correo']:$correo?>"><br>
	<label>Contraseña</label><input type="password" name="clave" value="<?=(isset($_POST['clave']))?$_POST['clave']:$contra?>"><br>
	
	<label>Estado</label><select name="estado" size="3">
		<option value="A" <?= ($estado=="A")?"selected= \"selected\"":""; ?>>Activo</option>
		<option value="B" <?= ($estado=="B")?"selected= \"selected\"":""; ?>>Bloqueado</option>
		<option value="I" <?= ($estado=="I")?"selected= \"selected\"":""; ?>>Desactivado</option>
	</select><br>
	
	<label>Plan</label><select name="plan" size="3">
		<option value="0" <?= ($plan==0)?"selected= \"selected\"":""; ?>>Básico</option>
		<option value="1" <?= ($plan==1)?"selected= \"selected\"":""; ?>>Profesional</option>
		<option value="2" <?= ($plan==2)?"selected= \"selected\"":""; ?>>Premium</option>
		<option value="3" <?= ($plan==3)?"selected= \"selected\"":""; ?>>Master</option>
	</select><br>
	
	<input type="submit" name="modificar" value="Modificar">
	<input type="submit" name="cancelar" value="Cancelar">
</form>
<?php 
$contenido=ob_get_clean();
include_once 'principal.php';
?>