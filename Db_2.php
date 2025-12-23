<?php
//Connexion à la base de donnée
$dbname="Db_1";
$host="127.0.0.1";
$port=3307;
$user="webuser";
$password="motdepassefort";


try{
    //Initiation d'exception

    $connect= new PDO("mysql:host=$host;dbname=$dbname;port=$port", $user, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Vérification par la méthode POST

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $user_name= trim(filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_SPECIAL_CHARS));
        $email= trim(filter_input(INPUT_POST, 'email' , FILTER_SANITIZE_SPECIAL_CHARS));
        $pass= trim($_POST['pass']?? '');
    

   //Vérification des champs
    if(empty($user_name) || empty($email) empty($pass)) {
        die('Tous les champs sont obligatoires.');
    }
        if(!filter_var($email,FILTER_EMAIL_VALIDATE)){
            die('Email invalide.');
        }

        $passHash = password_hash($pass, PASSWORD_DEFAULT);
        //Vérification de l'existence des champs
        $stmt = $connect->prepare("SELECT COUNT(*) FROM dat WHERE user_name = :user_name OR email = :email ");
        $stmt->bindParam(':user_name', $user_name);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if($count > 0) {
            echo "Ce compte existe déjà.";
        }else{
            //Insertion des données non existant dans la base de donnéee
            $stmt = $connect->prepare("INSERT INTO dat (user_name, email, mot_de_passe) VALUES(:user_name, :email, :pass)");
            $stmt->bindParam(':user_name', $user_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pass', $passHash);

            if($stmt->execute()) {
                header('Location: Confirm.html');
                
            }else{
                echo" Erreur lors de l'enregistrement des données.";
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
