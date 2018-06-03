<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>RealisateurDAO : Test</title>
    </head>

    <body>

        <?php
        use modele\metier\Realisateur;
        use modele\dao\RealisateurDAO;
        use modele\dao\Bdd;

        require_once __DIR__ . '/../includes/autoload.php';

        $id = 100;
        $idFilm = 1;
        Bdd::connecter();

        echo "<h2>Test RealisateurDAO</h2>";

        // Test n°1
        echo "<h3>1- Test getAll</h3>";
        try {
            $lesObjets = RealisateurDAO::getAll();
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        
        // Test n°2
        echo "<h3>2- Test getOneById</h3>";
        try {
            $objet = RealisateurDAO::getOneById($id);
            var_dump($objet);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°3
        echo "<h3>3- Test getAllByFilm</h3>";
        try {
            $lesObjets = RealisateurDAO::getAllByFilm($idFilm);
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        
        // Test n°4A
        echo "<h3>4A- insert</h3>";
        try {
            $id = 1;
            $objet = new Realisateur($id, 'baudry', 'quentin');
            $ok = RealisateurDAO::insert($objet);
            if ($ok) {
                echo "<h4>ooo réussite de l'insertion ooo</h4>";
                $objetLu = RealisateurDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de l'insertion ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }
        
        // Test n°4B
        echo "<h3>4B- insert déjà présent</h3>";
        try {
            $id = 1;
            $objet = new Realisateur($id, 'baudry', 'quentin');
            $ok = RealisateurDAO::insert($objet);
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
        
        // Test n°5
        echo "<h3>5- update</h3>";
        $id = 1;
        $objet = new Realisateur($id, 'baudry', 'quentin');
            
        try {
            $objet->setNom('drion');
            $objet->setPrenom('anthony');
            $ok = RealisateurDAO::update($id, $objet);
            if ($ok) {
                echo "<h4>ooo réussite de la mise à jour ooo</h4>";
                $objetLu = RealisateurDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de la mise à jour ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }
        
        // Test n°6
        echo "<h3>6- delete</h3>";
        try {
            $ok = RealisateurDAO::delete($id);
            if ($ok) {
                echo "<h4>ooo réussite de la suppression ooo</h4>";
            } else {
                echo "<h4>*** échec de la suppression ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }
        
        // Test n°7
        echo "<h3>7A- isAnExistingRealisateur - Realisateur existant</h3>";
        $nom = "baudry"; // nom existant
        $prenom = "quentin"; // prenom existant
        try {
            $ok = RealisateurDAO::isAnExistingRealisateur($nom, $prenom);
            if ($ok == 1) {
                echo "<h4>ooo réussite du test, le realisateur existe ooo</h4>";
            } else {
                echo "<h4>*** échec du test ***</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        echo "<h3>6-2- isAnExistingIdInAttribution - Realisateur inexistant</h3>";
        $nom = "123"; // nom existant
        $prenom = "ABC"; // prenom existant
        try {
            $ok = RealisateurDAO::isAnExistingRealisateur($nom, $prenom);
            if ($ok == 1) {
                echo "<h4>*** échec du test, le realisateur ne devrait pas exister ***</h4>";
                echo "$ok";
            } else {
                echo "<h4>ooo réussite du test, le realisateur n'existe pas ooo</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        
        Bdd::deconnecter();
        ?>
        
    </body>
</html>
