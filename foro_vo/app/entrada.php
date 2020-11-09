<form name='entrada' method="POST">
<table>
<tr>
<td>Nombre:</td><td> <input type="text" name="nombre" 
    value="<?=(isset($_REQUEST['nombre']))?$_REQUEST['nombre']:''?>"></td></tr>
<tr>
<td>Contraseña: </td><td><input type="password" name="contrasenia"
    value="<?=(isset($_REQUEST['contrasenia']))?$_REQUEST['contrasenia']:''?>"></td>
</tr>
</table>
<input type="submit" name="orden" value="Entrar">
</form>