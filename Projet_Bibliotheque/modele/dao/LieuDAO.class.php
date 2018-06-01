<?php
namespace modele\dao;

use modele\metier\Lieu;
use \PDO;

/**
 * Description of LieuDAO
 * Classe métier :  Lieu
 * @author qbaudry
 * @version 2017
 */
class LieuDAO {

    /**
     * Instancier un objet de la classe Lieu à partir d'un enregistrement de la table LIEU
     * @param array $enreg
     * @return Lieu
     */
    protected static function enregVersMetier(array $enreg) {
        $id = $enreg['ID'];
        $nomLieu = $enreg['NOMLIEU'];
        $adresseLieu = $enreg['ADRESSELIEU'];
        $capaciteAccueil = $enreg['CAPACITEACCUEIL'];
        $unLieu = new Lieu($id, $nomLieu, $adresseLieu, $capaciteAccueil);

        return $unLieu;
    }

    /**
     * Retourne la liste de tous les lieus
     * @return array tableau d'objets de type Groupe
     */
    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM Lieu";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            // Tant qu'il y a des enregistrements dans la table
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //ajoute un nouveau lieu au tableau
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }

    /**
     * Recherche un lieu selon la valeur de son identifiant
     * @param string $id
     * @return Groupe le groupe trouvé ; null sinon
     */
    public static function getOneById($id) {
        $objetConstruit = null;
        $requete = "SELECT * FROM Lieu WHERE id = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }
        return $objetConstruit;
    }
}