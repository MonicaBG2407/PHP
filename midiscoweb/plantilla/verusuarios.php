
<?php
// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();

?>
<form action='index.php'> 
<h2>Gesti�n de usuarios</h2>
<input type='submit' name="archivos" value='Ir a mis archivos'>
<input type='hidden' name='orden' value='Cerrar'> 
<input type='submit' value='Cerrar Sesión'> 
<table>
<tr>
<?php  
$auto = $_SERVER['PHP_SELF'];
/* identificador => Nombre, email, plan y Estado
*/
foreach ($usuarios as $clave => $datosusuario){
?>
<tr>
<?php 
        echo "<td>$clave</td>";
        for ($j=0; $j < count($datosusuario); $j++){
                echo "<td>$datosusuario[$j]</td>";
        }
 ?>
<td><a href="#" onclick="confirmarBorrar('<?= $datosusuario[0]."','".$clave."'"?>);" >Borrar</a></td>
<td><a href="<?= $auto?>?orden=Modificar&id=<?= $clave ?>">Modificar</a></td>
<td><a href="<?= $auto?>?orden=Detalles&id=<?= $clave?>">Detalles</a></td>
</tr>
<?php } ?>
</table>  
<input type='hidden' name='nuevo' value='Nuevo'> 

</form>       

<?php 
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido de la página principal
$contenido = ob_get_clean();
include_once "principal.php";

?>