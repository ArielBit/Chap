<?php
//Base de Donées stockées dans l'app Mysql
$dbname="Db_1";
$host="127.0.0.1";
$port=3307;
$user="webuser";
$password="motdepassefort";


try{
    $connect = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $user, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Erreur de connexion" . $e->getMessage();
}

?>
