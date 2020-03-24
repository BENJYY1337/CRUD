<?php
        if (!(isset ($_POST['Envoyer']))){
            //On récupère les valeurs entrées par l'utilisateur :
            $pseudo=htmlspecialchars($_POST['pseudo']);
            $motdepasse=htmlspecialchars(hash("Whirlpool",$_POST['mot_de_passe'])); // hash = Génère une valeur de hachage (empreinte numérique)
            $description=htmlspecialchars($_POST['description']);
            //On construit la date d'aujourd'hui
            //strictement comme sql la construit
            //$today = date("y-m-d");
            if(($val = update_user($pseudo, $motdepasse, $description)) == -1){
                echo "User not found"; // Erreur écrite
        }
    }
            function update_user($pseudo, $motdepasse, $description){
                // on se connecte a la dbb
                $DB_NAME = "crud"; //database_name
                $DB_DSN = "mysql:host=127.0.0.1:3308;dbname=".$DB_NAME; //database_datasourcename
                $DB_USER = "root"; //database_user
                $DB_PASSWORD = ""; //database_mot_de_passe
                try {
                    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $query= $bdd->prepare("SELECT pseudo FROM user WHERE pseudo=:pseudo"); // verifie que les données rentrées sont bonnes par rapport à la bdd
                    $query->execute(array(':pseudo' => $pseudo)); // Exécute une requête préparée
                    $val = $query->fetch(); // recupere les valeurs preparées
                    if($val == null){
                        $query->closeCursor();  // Ferme le curseur, permettant à query d'être de nouveau exécuté
                        return (-1);
                    }
                    $query = $bdd->prepare("UPDATE user SET mot_de_passe=:mot_de_passe , description=:description WHERE pseudo=:pseudo"); // Update  les données user
                    $query->execute(array(':mot_de_passe' => $motdepasse, ':description' => $description, 'pseudo'=> $pseudo));
                    return (0);
                } catch (PDOException $e) {
            }
        }
        ?>