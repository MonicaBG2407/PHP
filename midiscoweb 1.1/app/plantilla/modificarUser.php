<?php 
ob_start()
?>

<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<form name='MODIFICAR' method="POST" action="index.php?orden=Modificar">
	<h2>Modificar Usuario</h2>
	<label>Identificador</label><input type="text" name="id" value="<?=$user->id?>" readonly><br>
	<label>Nombre</label><input type="text" name="nombre" value="<?=$user->nombre?>"><br>
	<label>Correo Electrónico</label><input type="email" name="correo" value="<?=$user->mail?>"><br>
	<label>Contraseña</label><input type="password" name="clave" value="<?=$user->pass?>"><br>
	
	<label>Estado</label><select name="estado" size="3">
		<option value="A" <?= ($user->estado=="A")?"selected= \"selected\"":""; ?>>Activo</option>
		<option value="B" <?= ($user->estado=="I")?"selected= \"selected\"":""; ?>>Bloqueado</option>
		<option value="I" <?= ($user->estado=="B")?"selected= \"selected\"":""; ?>>Desactivado</option>
	</select><br>
	
	<label>Plan</label><select name="plan" size="3">
		<option value="0" <?= ($user->plan==0)?"selected= \"selected\"":""; ?>>Básico</option>
		<option value="1" <?= ($user->plan==1)?"selected= \"selected\"":""; ?>>Profesional</option>
		<option value="2" <?= ($user->plan==2)?"selected= \"selected\"":""; ?>>Premium</option>
		<option value="3" <?= ($user->plan==3)?"selected= \"selected\"":""; ?>>Master</option>
	</select><br>
	
	<input type="submit" name="modificar" value="Modificar">
	<input type="submit" name="cancelar" value="Cancelar">
</form>
<?php 
$contenido=ob_get_clean();
include_once 'principal.php';
?>