<?php
namespace modele\dao;

use modele\metier\Realisateur;
use PDOStatement;
use PDO;

class RealisateurDAO {

    /**
     * Instancier un objet de la classe Realisateur à partir d'un enregistrement de la table REALISATEUR
     * @param array $enreg
     * @return Realisateur
     */
    protected static function enregVersMetier(array $enreg) {
        $id = $enreg['ID'];
        $nom = $enreg['NOM'];
        $prenom = $enreg['PRENOM'];
        
        $unRealisateur = new Realisateur($id, $nom, $prenom);

        return $unRealisateur;
    }
    
    /**
     * Complète une requête préparée
     * les paramètres de la requête associés aux valeurs des attributs d'un objet métier
     * @param Realisateur $objetMetier
     * @param PDOStatement $stmt
     */
    protected static function metierVersEnreg(Realisateur $objetMetier, PDOStatement $stmt) {
        $stmt->bindValue(':id', $objetMetier->getId());
        $stmt->bindValue(':nom', $objetMetier->getNom());
        $stmt->bindValue(':prenom', $objetMetier->getPrenom());
    }

    /**
     * Retourne la liste de tous les realisateurs
     * @return array tableau d'objets de type Realisateur
     */
    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM realisateur";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            // Tant qu'il y a des enregistrements dans la table
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //ajoute un nouveau realisateur au tableau
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }

    /**
     * Recherche un realisateur selon la valeur de son identifiant
     * @param int $id
     * @return Realisateur le realisateur trouvé ; null sinon
     */
    public static function getOneById($id) {
        $objetConstruit = null;
        $requete = "SELECT * FROM realisateur WHERE ID = :id";
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
     * Retourne la liste des realisateurs attribués à un film donné
     * @param int $idEtab
     * @return array tableau d'éléments de type Realisateur
     */
    public static function getAllByFilm($idFilm) {
        $lesRealisateurs = array();  // le tableau à retourner
        $requete = "SELECT * FROM realisateur
                    WHERE ID IN (
                    SELECT DISTINCT ID FROM realisateur r
                            INNER JOIN film_realisateur fr ON r.ID = fr.IDRealisateur
                            WHERE IDFilm=:id
                    )";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $idFilm);
        $ok = $stmt->execute();
        if ($ok) {
            // Tant qu'il y a des enregistrements dans la table
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //ajoute un nouveau realisateur au tableau
                $lesRealisateurs[] = self::enregVersMetier($enreg);
            }
        } 
        return $lesRealisateurs;
    }
    
    /**
     * Insérer un nouvel enregistrement dans la table à partir de l'état d'un objet métier
     * @param Realisateur $objet objet métier à insérer
     * @return boolean =FALSE si l'opération échoue
     */
    public static function insert(Realisateur $objet) {
        $requete = "INSERT INTO realisateur VALUES (:id, UPPER(:nom), SUBSTRING(:prenom))";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }
    
    /**
     * Mettre à jour enregistrement dans la table à partir de l'état d'un objet métier
     * @param int identifiant de l'enregistrement à mettre à jour
     * @param Realisateur $objet objet métier à mettre à jour
     * @return boolean =FALSE si l'opérationn échoue
     */
    public static function update($id, Realisateur $objet) {
        $requete = "UPDATE realisateur SET Nom =UPPER(:nom), Prenom =SUBSTRING(:prenom) WHERE ID = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
    }
    
    /**
     * Détruire un enregistrement de la table REALISATEUR d'après son identifiant
     * @param int identifiant de l'enregistrement à détruire
     * @return boolean =TRUE si l'enregistrement est détruit, =FALSE si l'opération échoue
     */
    public static function delete($id) {
        $ok = false;
        $requete = "DELETE FROM realisateur WHERE ID = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
    }

    /**
     * Recherche si le realisateur proposé existe déjà dans la base de données
     * @param string $nom
     * @param string $prenom
     * @return int le nombre de realisateurs déjà existant dans la BD (0 ou 1) ; c'est donc aussi un booléen
     */
    public static function isAnExistingRealisateur($nom, $prenom) {
        //$nom = str_replace("'", "''", $nom);
        $requete = "SELECT COUNT(*) FROM realisateur WHERE Nom LIKE UPPER(:nom) AND Prenom LIKE SUBSTRING(:prenom)";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }
    
    /**
     * Recherche un identifiant de realisateur existant dans FILM_REALISATEUR
     * @param int $id du realisateur recherché
     * @return int le nombre de realisateurs correspondant à cet id (0 ou 1)
     */
    public static function isAnExistingIdInFilmRealisateur($id) {
        $requete = "SELECT COUNT(*) FROM film_realisateur WHERE IDRealisateur=:id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }
}
