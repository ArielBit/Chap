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

    //Vérification par la méthode POST
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);


        if(empty($email) || empty($pass)){
            die('Tous les champs sont obligatoires.');
        }
            $stmt=$connect->prepare("SELECT mot_de_passe  FROM dat WHERE email = :email AND mot_de_passe = :pass");
            $stmt->bindParam(":email",$email);
            $stmt->bindParam(":pass", $pass);
            $stmt->execute();
            $count=$stmt->fetchColumn();

            if($count > 0){
                
                header("Location: Confirm.html");
                exit();
            }else{
                echo "Votre Compte n'existe pas.";
                echo "Veuillez en créer un SVP : Cliquez sur <a href=\"Inscription.html\">S'incrire</a>";
            }
        }
    }else{
        echo "Tout les champs sont obligatoires";
    }













}catch(PDOException $e){
    echo "Erreur de connexion" . $e->getMessage();

}
?>
