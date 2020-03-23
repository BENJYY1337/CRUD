<?php
        if (!(isset ($_POST['Envoyer']))){
            //On récupère les valeurs entrées par l'utilisateur :
            $pseudo=htmlspecialchars($_POST['pseudo']);
            $motdepasse=htmlspecialchars($_POST['mot_de_passe']);
            $description=htmlspecialchars($_POST['description']);
            //On construit la date d'aujourd'hui
            //strictement comme sql la construit
            //$today = date("y-m-d");
            //On se connecte
            $DB_NAME = "crud"; //database_name
            $DB_DSN = "mysql:host=127.0.0.1:3308;dbname=".$DB_NAME; //database_datasourcename
            $DB_USER = "root"; //database_user
            $DB_PASSWORD = ""; //database_mot_de_passe
            try {
                $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configure un attribut PDO
                $query= $bdd->prepare("SELECT pseudo FROM user WHERE pseudo=:pseudo"); // verifie que les données rentrées sont bonnes par rapport à la bdd
                $query->execute(array(':pseudo' => $pseudo)); // Exécute une requête préparée
                $val = $query->fetch(); // recupere les valeurs preparées
                $query->closeCursor(); // Ferme le curseur, permettant à query d'être de nouveau exécuté
                $query = $bdd->prepare("DELETE FROM user WHERE pseudo=:pseudo"); // Delete une entrée
                $query->execute(array('pseudo'=> $pseudo));
            } catch (PDOException $e) {
        }
    }
            ?>