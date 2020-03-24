<?php
if (!(isset ($_POST['Envoyer']))){

    $pseudo=htmlspecialchars($_POST['pseudo']);
            //On récupère les valeurs entrées par l'utilisateur :
            // $motdepasse=htmlspecialchars($_POST['mot_de_passe']);
            // $description=htmlspecialchars($_POST['description']);
            //On construit la date d'aujourd'hui
            //strictement comme sql la construit
            //$today = date("y-m-d");
    if(($val = read_user($pseudo)) == -1){
        echo "User not found"; // Erreur écrite
    }
        echo $val['mot_de_passe'];
        ?>
        <html> </br> </html>
        <?php
        echo $val['description'];
        
}
    function read_user($pseudo){
        // on se connecte a la base
        $DB_NAME = "crud"; //database_name
        $DB_DSN = "mysql:host=127.0.0.1:3308;dbname=".$DB_NAME; //database_datasourcename
        $DB_USER = "root"; //database_user
        $DB_PASSWORD = ""; //database_mot_de_passe
        try {
            $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configure un attribut PDO
            $query= $bdd->prepare("SELECT mot_de_passe, description FROM user WHERE pseudo=:pseudo"); // verifie que les données rentrées sont bonnes par rapport à la bdd
            $query->execute(array(':pseudo' => $pseudo)); // Exécute une requête préparée
            $val = $query->fetch(); // recupere les valeurs preparées
            if($val == null){
                $query->closeCursor();  // Ferme le curseur, permettant à query d'être de nouveau exécuté
                return (-1);
            }
            $query->closeCursor();
            return ($val);
        } catch (PDOException $e) {
    }
}
?>