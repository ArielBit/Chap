<?php
session_start();
?>


<?php
//Base de Donées stockées dans l'app Mysql
$Dbname="Db_1";
$host="127.0.0.1";
$port=3307;
$user="webuser";
$password="motdepassefort";


try{
    $connect = new PDO("mysql:host=$host;dbname=$Dbname;port=$port", $user, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
    echo "Erreur de connexion" . $e->getMessage();
  exit();
}
?>

<?php
  //Recuperation des données
  $stmt=$connect->prepare('SELECT id, email FROM tri');
  $stmt->execute();
  $data=$stmt->fetch(FETCH_ASSOC);
  ?>

<?php
if(!empty($data)){
  foreach($data as $row): ?>


    

