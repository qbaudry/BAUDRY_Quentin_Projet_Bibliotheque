<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>GenreDAO : Test</title>
    </head>

    <body>

        <?php
        use modele\metier\Genre;
        use modele\dao\GenreDAO;
        use modele\dao\Bdd;

        require_once __DIR__ . '/../includes/autoload.php';

        $id = 1;
        $idInexistant = 999;
        $idFilm = 1;
        Bdd::connecter();

        echo "<h2>Test GenreDAO</h2>";

        // Test n°1
        echo "<h3>1- Test getAll</h3>";
        try {
            $lesObjets = GenreDAO::getAll();
            echo '<h5 style="color:green">RÉUSSITE DU TEST</h5>';
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $ex->getMessage();
        }
        
        // Test n°2
        echo "<h3>2- Test getOneById</h3>";
        try {
            $objet = GenreDAO::getOneById($id);
            echo '<h5 style="color:green">RÉUSSITE DU TEST</h5>';
            var_dump($objet);
        } catch (Exception $ex) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $ex->getMessage();
        }

        // Test n°3
        echo "<h3>3- Test getAllGenreByFilm</h3>";
        try {
            $lesObjets = GenreDAO::getAllGenreByFilm($idFilm);
            echo '<h5 style="color:green">RÉUSSITE DU TEST</h5>';
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $ex->getMessage();
        }
        
        // Test n°4A
        echo "<h3>4A- INSERT</h3>";
        try {
            $objet = new Genre($idInexistant, 'libelle');
            $ok = GenreDAO::insert($objet);
            if ($ok) {
                echo '<h5 style="color:green">RÉUSSITE DE L\'INSERTION</h5>';
                $objetLu = GenreDAO::getOneById($idInexistant);
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
            $objet = new Genre($id, 'libelle');
            $ok = GenreDAO::insert($objet);
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
        $objet = new Genre($idInexistant, 'libelle');
            
        try {
            $objet->setLibelle('genre');
            $ok = GenreDAO::update($idInexistant, $objet);
            if ($ok) {
                echo '<h5 style="color:green">RÉUSSITE DE LA MISE À JOUR</h5>';
                $objetLu = GenreDAO::getOneById($idInexistant);
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
            $ok = GenreDAO::delete($idInexistant);
            if ($ok) {
                echo '<h5 style="color:green">RÉUSSITE DE LA SUPPRESSION</h5>';
            } else {
                echo '<h5 style="color:red">ÉCHEC DE LA SUPPRESSION</h5>';
            }
        } catch (Exception $e) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $e->getMessage();
        }
        
        // Test n°7
        echo "<h3>7A- isAnExistingGenre - Genre existant</h3>";
        $libelle = "action"; // nom existant
        try {
            $ok = GenreDAO::isAnExistingGenre($libelle);
            if ($ok >= 1) {
                echo '<h5 style="color:green">RÉUSSITE DU TEST, le genre existe (Nombre: '.$ok.')</h5>';
            } else {
                echo '<h5 style="color:red">ÉCHEC DU TEST, le genre devrait exister (Nombre: '.$ok.')</h5>';
            }
        } catch (Exception $ex) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $ex->getMessage();
        }
        echo "<h3>7B- isAnExistingGenre - Genre inexistant</h3>";
        $libelle = "123"; // nom inexistant
        try {
            $ok = GenreDAO::isAnExistingGenre($libelle);
            if ($ok >= 1) {
                echo '<h5 style="color:red">ÉCHEC DU TEST, le genre ne devrait pas exister (Nombre: '.$ok.')</h5>';
                echo "$ok";
            } else {
                echo '<h5 style="color:green">RÉUSSITE DU TEST, le genre n\'existe pas (Nombre: '.$ok.')</h5>';
            }
        } catch (Exception $ex) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $ex->getMessage();
        }
        
        // Test n°8
        echo "<h3>8A- isAnExistingIdInFilmGenre - Genre existant</h3>";
        try {
            $ok = GenreDAO::isAnExistingIdInFilmGenre($id);
            if ($ok >= 1) {
                echo '<h5 style="color:green">RÉUSSITE DU TEST, le genre existe (Nombre: '.$ok.')</h5>';
            } else {
                echo '<h5 style="color:red">ÉCHEC DU TEST, le genre devrait exister (Nombre: '.$ok.')</h5>';
            }
        } catch (Exception $ex) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $ex->getMessage();
        }
        echo "<h3>8B- isAnExistingIdInFilmGenre - Genre inexistant</h3>";
        try {
            $ok = GenreDAO::isAnExistingIdInFilmGenre($idInexistant);
            if ($ok >= 1) {
                echo '<h5 style="color:red">ÉCHEC DU TEST, le genre ne devrait pas exister (Nombre: '.$ok.')</h5>';
                echo "$ok";
            } else {
                echo '<h5 style="color:green">RÉUSSITE DU TEST, le genre n\'existe pas (Nombre: '.$ok.')</h5>';
            }
        } catch (Exception $ex) {
            echo '<h5 style="color:red">ÉCHEC DE LA REQUÊTE</h5>' . $ex->getMessage();
        }
        
        Bdd::deconnecter();
        ?>
        
    </body>
</html>
