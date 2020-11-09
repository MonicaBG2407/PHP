<div>
<b> Detalles:</b><br>
<table>
<tr><td>Longitud:          </td><td><?= strlen($_REQUEST['comentario']) ?></td></tr>
<tr><td>Nº de palabras:    </td><td><?=str_word_count($_REQUEST['comentario'], 0)?></td></tr>
<?php
$comentario=$_REQUEST['comentario'];
$caracteres=count_chars($comentario, 0);
$repetido="";
$max=0;
foreach ($caracteres as $caracter=>$valor){
    if ($caracter!=32 && $valor>$max){   
        $max=$valor;
        $repetido=$caracter;
    }
}
?>
<tr><td>Letra + repetida:  </td><td><?= chr($repetido)?></td></tr>
<?php
$comentario=$_REQUEST['comentario'];
$comentarioSin=explode(" ",$comentario);
$max=0;
for($x=0; $x<count($comentarioSin); $x++){
    $repetido=substr_count($comentario,$comentarioSin[$x]);
    if( $repetido>$max ){
        $palabra=$comentarioSin[$x];
        $max=$repetido;
    } 
}

?>
<tr><td>Palabra + repetida:</td><td><?=$palabra?></td></tr>
</table>
</div>

