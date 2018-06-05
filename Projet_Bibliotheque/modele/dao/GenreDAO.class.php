<?php
namespace modele\dao;

use modele\metier\Genre;
use PDOStatement;
use PDO;

class GenreDAO {

    /**
     * Instancier un objet de la classe Genre à partir d'un enregistrement de la table GENRE
     * @param array $enreg
     * @return Genre
     */
    protected static function enregVersMetier(array $enreg) {
        $id = $enreg['ID'];
        $libelle = $enreg['LIBELLE'];
        
        $unGenre = new Genre($id, $libelle);

        return $unGenre;
    }
    
    /**
     * Complète une requête préparée
     * les paramètres de la requête associés aux valeurs des attributs d'un objet métier
     * @param Genre $objetMetier
     * @param PDOStatement $stmt
     */
    protected static function metierVersEnreg(Genre $objetMetier, PDOStatement $stmt) {
        $stmt->bindValue(':id', $objetMetier->getId());
        $stmt->bindValue(':libelle', $objetMetier->getLibelle());
    }

    /**
     * Retourne la liste de tous les genres
     * @return array tableau d'objets de type Genre
     */
    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM genre";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            // Tant qu'il y a des enregistrements dans la table
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //ajoute un nouveau genre au tableau
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }

    /**
     * Recherche un genre selon la valeur de son identifiant
     * @param int $id
     * @return Genre le genre trouvé ; null sinon
     */
    public static function getOneById($id) {
        $objetConstruit = null;
        $requete = "SELECT * FROM genre WHERE ID = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }
        return $objetConstruit;
    }

    /**
     * Retourne la liste des genres attribués à un film donné
     * @param int $idFilm
     * @return array tableau d'éléments de type Genre
     */
    public static function getAllGenreByFilm($idFilm) {
        $lesGenres = array();  // le tableau à retourner
        $requete = "SELECT * FROM genre
                    WHERE ID IN (
                    SELECT DISTINCT ID FROM genre g
                            INNER JOIN film_genre fg ON g.ID = fg.IDGenre
                            WHERE IDFilm = :id
                    )";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $idFilm);
        $ok = $stmt->execute();
        if ($ok) {
            // Tant qu'il y a des enregistrements dans la table
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //ajoute un nouveau genre au tableau
                $lesGenres[] = self::enregVersMetier($enreg);
            }
        } 
        return $lesGenres;
    }
    
    /**
     * Insérer un nouvel enregistrement dans la table à partir de l'état d'un objet métier
     * @param Genre $objet objet métier à insérer
     * @return boolean =FALSE si l'opération échoue
     */
    public static function insert(Genre $objet) {
        $requete = "INSERT INTO genre VALUES (:id, :libelle)";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }
    
    /**
     * Mettre à jour enregistrement dans la table à partir de l'état d'un objet métier
     * @param int identifiant de l'enregistrement à mettre à jour
     * @param Genre $objet objet métier à mettre à jour
     * @return boolean =FALSE si l'opérationn échoue
     */
    public static function update($id, Genre $objet) {
        $requete = "UPDATE genre SET Libelle = :libelle WHERE ID = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
    }
    
    /**
     * Détruire un enregistrement de la table GENRE d'après son identifiant
     * @param int identifiant de l'enregistrement à détruire
     * @return boolean =TRUE si l'enregistrement est détruit, =FALSE si l'opération échoue
     */
    public static function delete($id) {
        $ok = false;
        $requete = "DELETE FROM genre WHERE ID = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
    }

    /**
     * Recherche si le genre proposé existe déjà dans la base de données
     * @param string $libelle
     * @return int le nombre de genres déjà existant dans la BD (0 ou 1) ; c'est donc aussi un booléen
     */
    public static function isAnExistingGenre($libelle) {
        $requete = "SELECT COUNT(*) FROM genre WHERE Libelle LIKE :libelle";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':libelle', $libelle);
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }
    
    /**
     * Recherche un identifiant de genre existant dans FILM_GENRE
     * @param int $id du genre recherché
     * @return int le nombre de genres correspondant à cet id (0 ou 1)
     */
    public static function isAnExistingIdInFilmGenre($id) {
        $requete = "SELECT COUNT(*) FROM film_genre WHERE IDGenre = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }
}
