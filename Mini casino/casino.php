<html>
<head>
<meta charset="UTF-8">
<meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
<title>Casino</title>
</head>
<body>

<?php 
session_start();
function paroimpar($num){
    if($num=='1'){
        $resu='IMPAR';
    }else {
        $resu='PAR';
    }
    return $resu;
}
$visitas=0;
if(isset($_COOKIE['visitas'])){
    $visitas= $_COOKIE['visitas'];
}

if (! isset($_SESSION['total'])) {
    echo"<h1>BIENVENIDO AL CASINO</h1>
         <form method='post'>
         Esta es su:  ".$visitas."º visita.<br>
         Introduzca el dinero con el que va a jugar: <input type='number' name='total' autofocus>
         </form>";
    if (!empty($_POST['total']) && isset($_POST['total']) && $_POST['total']>0){
        $_SESSION['total'] = $_POST['total'];
        echo " COMENZAMOS <br>";
        $visitas++;
        setcookie('visitas', $visitas, time() + 30*24*3600);
        header("refresh: 2;");
    }
    
}else{
    
    $fichas=$_SESSION['total'];
    echo "<h2>Dispone de ".$fichas." para jugar</h2>
          <form method='post'>
          Cantidad a apostar: <input type='number' name='apuesta' autofocus><br>
          Tipo de apuesta: Par<input type='radio' value='par' name='par'>  Impar<input type='radio' value='impar' name='impar'><br>
          <input type='submit' value='Apostar Cantidad' name='send'><input type='submit' value='Abandonar Casino 'name='exit'>
          </form>";
    
    if (isset($_POST['send'])){
        if (!empty($_POST['apuesta']) && isset($_POST['apuesta']) && $_POST['apuesta']>0) {
            $apuesta =  $_POST['apuesta'];
            $num=rand(1,2);
            $resultado=paroimpar($num);
            if ($_POST['apuesta']>$_SESSION['total']){
                echo'No puede apostar más de lo que tiene';
            }else{
                if (isset($_POST['par']) && $num=='2'){
                    $_SESSION['total']+=$_POST['apuesta'];
                    echo "EL RESULTADO DE LA APUESTA ES: ".$resultado."<br>";
                    echo "GANASTE"; 
                }elseif (isset($_POST['impar']) && $num=='1') {
                    $_SESSION['total']+=$_POST['apuesta'];
                    echo "EL RESULTADO DE LA APUESTA ES: ".$resultado."<br>";
                    echo "GANASTE";
                }else{
                    $_SESSION['total']-=$_POST['apuesta'];
                    echo "HAS PERDIDO"; 
                }
                header("refresh: 1;");
            }
            if( $_SESSION['total']==0  ){
                echo "<h3>No le quedan fichas, ha perdido: ".$fichas."</h3>";
                session_destroy();
            }
        
        }
    }elseif(isset($_POST['exit'])){
        echo "Muchas gracias por jugar con nosotros.<br>
              Su resultado final es de ".$fichas." Euros";
        session_destroy();
        header("refresh: 2;");
    }
    
    
}
?>
</body>
</html>
