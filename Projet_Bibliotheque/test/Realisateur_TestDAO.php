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

        $id = 1;
        $idInexistant = 999;
        $idFilm = 1;
        Bdd::connecter();

        echo "<h2>Test RealisateurDAO</h2>";

        // Test n°1
        echo "<h3>1- Test getAll</h3>";
        try {
            $lesObjets = RealisateurDAO::getAll();
            echo '<h5 style="color:green">RÉUSSITE DU TEST</h5>';
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $ex->getMessage();
        }
        
        // Test n°2
        echo "<h3>2- Test getOneById</h3>";
        try {
            $objet = RealisateurDAO::getOneById($id);
            echo '<h5 style="color:green">RÉUSSITE DU TEST</h5>';
            var_dump($objet);
        } catch (Exception $ex) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $ex->getMessage();
        }

        // Test n°3
        echo "<h3>3- Test getAllRealisateurByFilm</h3>";
        try {
            $lesObjets = RealisateurDAO::getAllRealisateurByFilm($idFilm);
            echo '<h5 style="color:green">RÉUSSITE DU TEST</h5>';
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $ex->getMessage();
        }
        
        // Test n°4A
        echo "<h3>4A- INSERT</h3>";
        try {
            $objet = new Realisateur($idInexistant, 'baudry', 'quentin');
            $ok = RealisateurDAO::insert($objet);
            if ($ok) {
                echo '<h5 style="color:green">RÉUSSITE DE L\'INSERTION</h5>';
                $objetLu = RealisateurDAO::getOneById($idInexistant);
                var_dump($objetLu);
            } else {
                echo '<h5 style="color:red">ÉCHEC DE L\'INSERTION</h5>';
            }
        } catch (Exception $e) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $e->getMessage();
        }
        
        // Test n°4B
        echo "<h3>4B- INSERT - Déjà présent</h3>";
        try {
            $id = 1;
            $objet = new Realisateur($id, 'baudry', 'quentin');
            $ok = RealisateurDAO::insert($objet);
            if ($ok) {
                echo '<h5 style="color:red">ÉCHEC DU TEST, l\'insertion ne devrait pas réussir  ***</h5>';
                $objetLu = Bdd::getOneById($id);
                var_dump($objetLu);
            } else {
                echo '<h5 style="color:green">RÉUSSITE DU TEST, l\'insertion a logiquement échoué</h5>';
            }
        } catch (Exception $e) {
            echo '<h5 style="color:green">RÉUSSITE DU TEST, la requête d\'insertion a logiquement échoué</h5>' . $e->getMessage();
        }
        
        // Test n°5
        echo "<h3>5- UPDATE</h3>";
        $objet = new Realisateur($idInexistant, 'baudry', 'quentin');
            
        try {
            $objet->setNom('drion');
            $objet->setPrenom('anthony');
            $ok = RealisateurDAO::update($idInexistant, $objet);
            if ($ok) {
                echo '<h5 style="color:green">RÉUSSITE DE LA MISE À JOUR</h5>';
                $objetLu = RealisateurDAO::getOneById($idInexistant);
                var_dump($objetLu);
            } else {
                echo '<h5 style="color:red">ÉCHEC DE LA MISE À JOUR</h5>';
            }
        } catch (Exception $e) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $e->getMessage();
        }
        
        // Test n°6
        echo "<h3>6- DELETE</h3>";
        try {
            $ok = RealisateurDAO::delete($idInexistant);
            if ($ok) {
                echo '<h5 style="color:green">RÉUSSITE DE LA SUPPRESSION</h5>';
            } else {
                echo '<h5 style="color:red">ÉCHEC DE LA SUPPRESSION</h5>';
            }
        } catch (Exception $e) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $e->getMessage();
        }
        
        // Test n°7
        echo "<h3>7A- isAnExistingRealisateur - Realisateur existant</h3>";
        $nom = "baudry"; // nom existant
        $prenom = "quentin"; // prenom existant
        try {
            $ok = RealisateurDAO::isAnExistingRealisateur($nom, $prenom);
            if ($ok >= 1) {
                echo '<h5 style="color:green">RÉUSSITE DU TEST, le realisateur existe (Nombre: '.$ok.')</h5>';
            } else {
                echo '<h5 style="color:red">ÉCHEC DU TEST, le realisateur devrait exister (Nombre: '.$ok.')</h5>';
            }
        } catch (Exception $ex) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $ex->getMessage();
        }
        echo "<h3>7B- isAnExistingRealisateur - Realisateur inexistant</h3>";
        $nom = "123"; // nom inexistant
        $prenom = "ABC"; // prenom inexistant
        try {
            $ok = RealisateurDAO::isAnExistingRealisateur($nom, $prenom);
            if ($ok >= 1) {
                echo '<h5 style="color:red">ÉCHEC DU TEST, le realisateur ne devrait pas exister (Nombre: '.$ok.')</h5>';
                echo "$ok";
            } else {
                echo '<h5 style="color:green">RÉUSSITE DU TEST, le realisateur n\'existe pas (Nombre: '.$ok.')</h5>';
            }
        } catch (Exception $ex) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $ex->getMessage();
        }
        
        // Test n°8
        echo "<h3>8A- isAnExistingIdInFilmRealisateur - Realisateur existant</h3>";
        try {
            $ok = RealisateurDAO::isAnExistingIdInFilmRealisateur($id);
            if ($ok >= 1) {
                echo '<h5 style="color:green">RÉUSSITE DU TEST, le realisateur existe (Nombre: '.$ok.')</h5>';
            } else {
                echo '<h5 style="color:red">ÉCHEC DU TEST, le realisateur devrait exister (Nombre: '.$ok.')</h5>';
            }
        } catch (Exception $ex) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $ex->getMessage();
        }
        echo "<h3>8B- isAnExistingIdInFilmRealisateur - Realisateur inexistant</h3>";
        try {
            $ok = RealisateurDAO::isAnExistingIdInFilmRealisateur($idInexistant);
            if ($ok >= 1) {
                echo '<h5 style="color:red">ÉCHEC DU TEST, le realisateur ne devrait pas exister (Nombre: '.$ok.')</h5>';
                echo "$ok";
            } else {
                echo '<h5 style="color:green">RÉUSSITE DU TEST, le realisateur n\'existe pas (Nombre: '.$ok.')</h5>';
            }
        } catch (Exception $ex) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $ex->getMessage();
        }
        
        Bdd::deconnecter();
        ?>
        
    </body>
</html>
