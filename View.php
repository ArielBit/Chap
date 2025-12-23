<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View</title>

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

}catch(PDOException $e){
    echo "Erreur de connexion" . $e->getMessage();
  exit();
}
?>

<?php
  //Recuperation des données
  $stmt=$connect->prepare('SELECT id, email, nom FROM tri');
  $stmt->execute();
  $data=$stmt->fetch(FETCH_ASSOC);
  ?>

<?php
if(!empty($data)){
  foreach($data as $row): ?>
      <h1>Données d'utilisateurs</h1>

     <?php echo htmlspecialchars($row['id']); ?>
      <p>Nom: <?php echo htmlspecialchars($row['nom']); ?></p>

     <?php echo htmlspecialchars($row['id']); ?>
      <p>Email: <?php echo htmlspecialchars($row['email']); ?></p>
    <?php }else{
    echo "Aucun utilisateur.";
    }?>
<?php endforeach; ?>
<?php endif; ?>

    </head>
<body>
    
</body>
</html>

