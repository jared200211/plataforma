<?php
$conexion = null;
$servidor = "localhost";
$bd="grupoindustrialibarra";
$user="root";
$pass="";

try{
    $pdo=new PDO('mysql:host='.$servidor.';dbname='.$bd.';charset=utf8',$user,$pass);

}catch(PDOException $e){
    echo("Error en la conexion");
    exit;
}

return $pdo;

?>