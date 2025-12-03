<?php
//Connexion à la base de donnée
$Dbname="Db_1";
$host="127.0.0.1";
$port=3307;
$user="webuser";
$password="motdepassefort";


try{
    //Initiation d'exception

    $connect= new PDO("mysql:host=$host;dbname=$Dbname;port=$port", $user, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Vérification par la méthode POST

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_name= filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email= filter_input(INPUT_POST, 'email' , FILTER_SANITIZE_SPECIAL_CHARS);
        $pass= filter_input(INPUT_POST, 'pass' , FILTER_SANITIZE_SPECIAL_CHARS);
    

   //Vérification des champs
    if($user_name && $email && $pass) {

        //Vérification de l'existence des champs
        $stmt = $connect->prepare("SELECT COUNT(*) FROM dat WHERE user_name = :user_name AND email = :email AND mot_de_passe = :pass");
        $stmt->bindParam(':user_name', $user_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if($count > 0) {
            echo "Ce compte existe déjà.";
        }else{
            //Insertion des données non existant dans la base de donnéee
            $stmt = $connect->prepare("INSERT INTO dat (user_name, email, mot_de_passe) VALUES(:user_name, :email, :pass)");
            $stmt->bindParam(':user_name', $user_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pass', $pass);

            if($stmt->execute()) {
                echo" Les données ont été enregistrés avec succès";
                header("Location: Confirm.html");
            }else{
                echo" erreur lors de l'enregistrement des données";
            }
        }
     }else{
        echo "Tous les champs sont obligatoires.";
     }

    }

}catch(PDOException $e) {
    echo "erreur de connexion :" . $e->getMessage();
}
?>