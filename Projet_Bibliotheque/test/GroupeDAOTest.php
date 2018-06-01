<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>GroupeDAO : test</title>
    </head>

    <body>

        <?php
        use modele\metier\Groupe;
        use modele\dao\GroupeDAO;
        use modele\dao\Bdd;

        require_once __DIR__ . '/../includes/autoload.php';

        $id = 'g010';
        Bdd::connecter();

        echo "<h2>Test GroupeDAO</h2>";
/*
        // Test n°1
        echo "<h3>Test getOneById</h3>";
        try {
            $objet = GroupeDAO::getOneById($id);
            var_dump($objet);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°2
        echo "<h3>Test getAll</h3>";
        try {
            $lesObjets = GroupeDAO::getAll();
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°3
        echo "<h3>Test getAllToHost</h3>";
        try {
            $lesObjets = GroupeDAO::getAllToHost();
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        
        // Test n°4
        echo "<h3>3- insert</h3>";
        try {
            $id = 'g100';
            $objet = new Groupe($id, 'La Joliverie', null, null, 1, 'France', 'O');
            $ok = GroupeDAO::insert($objet);
            if ($ok) {
                echo "<h4>ooo réussite de l'insertion ooo</h4>";
                $objetLu = GroupeDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de l'insertion ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }
        
        // Test n°4-bis
        echo "<h3>3- insert déjà présent</h3>";
        try {
            $id = 'g100';
            $objet = new Groupe($id, 'La Joliverie2', null, null, 1, 'France', 'O');
            $ok = GroupeDAO::insert($objet);
            if ($ok) {
                echo "<h4>*** échec du test : l'insertion ne devrait pas réussir  ***</h4>";
                $objetLu = Bdd::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>ooo réussite du test : l'insertion a logiquement échoué ooo</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>ooo réussite du test : la requête d'insertion a logiquement échoué ooo</h4>" . $e->getMessage();
        }
        
        // Test n°4
        echo "<h3>4- update</h3>";
        $id = 'g100';
        $objet = new Groupe($id, 'La Joliverie', null, null, 1, 'France', 'O');
            
        try {
            $objet->setNom('Groupe Joliverie');
            $objet->setNomPays('Belgique');
            $ok = GroupeDAO::update($id, $objet);
            if ($ok) {
                echo "<h4>ooo réussite de la mise à jour ooo</h4>";
                $objetLu = GroupeDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de la mise à jour ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }
        
        // Test n°6
        echo "<h3>5- delete</h3>";
        try {
            $ok = GroupeDAO::delete($id);
            if ($ok) {
                echo "<h4>ooo réussite de la suppression ooo</h4>";
            } else {
                echo "<h4>*** échec de la suppression ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }
        */
        // Test n°7
        echo "<h3>6-1- isAnExistingIdInAttribution - id existant</h3>";
        $id = "g001"; // id existant
        try {
            $ok = GroupeDAO::isAnExistingIdInAttribution($id);
            if ($ok == 1) {
                echo "<h4>ooo réussite du test, l'id existe ooo</h4>";
            } else {
                echo "<h4>*** échec du test ***</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        echo "<h3>6-2- isAnExistingIdInAttribution - id inexistant</h3>";
        $id = "g101"; // id absent
        try {
            $ok = GroupeDAO::isAnExistingIdInAttribution($id);
            if ($ok == 1) {
                echo "<h4>*** échec du test, l'id ne devrait pas exister ***</h4>";
                echo "$ok";
            } else {
                echo "<h4>ooo réussite du test, l'id n'existe pas ooo</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        
        Bdd::deconnecter();
        ?>
        
    </body>
</html>
