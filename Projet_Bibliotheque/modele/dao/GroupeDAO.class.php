<?php
namespace modele\dao;

use modele\metier\Groupe;
use PDOStatement;
use PDO;

/**
 * Description of GroupeDAO
 * Classe métier :  Groupe
 * @author prof
 * @version 2017
 */
class GroupeDAO {


    /**
     * Instancier un objet de la classe Groupe à partir d'un enregistrement de la table GROUPE
     * @param array $enreg
     * @return Groupe
     */
    protected static function enregVersMetier(array $enreg) {
        $id = $enreg['ID'];
        $nom = $enreg['NOM'];
        $identite = $enreg['IDENTITERESPONSABLE'];
        $adresse = $enreg['ADRESSEPOSTALE'];
        $nbPers = $enreg['NOMBREPERSONNES'];
        $nomPays = $enreg['NOMPAYS'];
        $hebergement = $enreg['HEBERGEMENT'];
        
        $unGroupe = new Groupe($id, $nom, $identite, $adresse, $nbPers, $nomPays, $hebergement);

        return $unGroupe;
    }
    
    /**
     * Complète une requête préparée
     * les paramètres de la requête associés aux valeurs des attributs d'un objet métier
     * @param Groupe $objetMetier
     * @param PDOStatement $stmt
     */
    protected static function metierVersEnreg(Groupe $objetMetier, PDOStatement $stmt) {
        $stmt->bindValue(':id', $objetMetier->getId());
        $stmt->bindValue(':nom', $objetMetier->getNom());
        $stmt->bindValue(':identite', $objetMetier->getIdentite());
        $stmt->bindValue(':adresse', $objetMetier->getAdresse());
        $stmt->bindValue(':nbpers', $objetMetier->getNbPers());
        $stmt->bindValue(':nompays', $objetMetier->getNomPays());
        $stmt->bindValue(':hebergement', $objetMetier->getHebergement());
    }

    /**
     * Retourne la liste de tous les groupes
     * @return array tableau d'objets de type Groupe
     */
    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM Groupe";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            // Tant qu'il y a des enregistrements dans la table
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //ajoute un nouveau groupe au tableau
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }

    /**
     * Recherche un groupe selon la valeur de son identifiant
     * @param string $id
     * @return Groupe le groupe trouvé ; null sinon
     */
    public static function getOneById($id) {
        $objetConstruit = null;
        $requete = "SELECT * FROM Groupe WHERE ID = :id";
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
     * Retourne la liste des groupes attribués à un établissement donné
     * @param string $idEtab
     * @return array tableau d'éléments de type Groupe
     */
    public static function getAllByEtablissement($idEtab) {
        $lesGroupes = array();  // le tableau à retourner
        $requete = "SELECT * FROM Groupe
                    WHERE ID IN (
                    SELECT DISTINCT ID FROM Groupe g
                            INNER JOIN Attribution a ON a.IDGROUPE = g.ID 
                            WHERE IDETAB=:id
                    )";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $idEtab);
        $ok = $stmt->execute();
        if ($ok) {
            // Tant qu'il y a des enregistrements dans la table
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //ajoute un nouveau groupe au tableau
                $lesGroupes[] = self::enregVersMetier($enreg);
            }
        } 
        return $lesGroupes;
    }

    
    /**
     * Retourne la liste des groupes souhaitant un hébergement, ordonnée par id
     * @return array tableau d'éléments de type Groupe
     */
    public static function getAllToHost() {
        $lesGroupes = array();
        $requete = "SELECT * FROM Groupe WHERE HEBERGEMENT='O' ORDER BY ID";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $lesGroupes[] = self::enregVersMetier($enreg);
            }
        }
        return $lesGroupes;
    }
    
    /**
     * Insérer un nouvel enregistrement dans la table à partir de l'état d'un objet métier
     * @param Groupe $objet objet métier à insérer
     * @return boolean =FALSE si l'opération échoue
     */
    public static function insert(Groupe $objet) {
        $requete = "INSERT INTO Groupe VALUES (:id, :nom, :identite, :adresse, :nbpers, :nompays, :hebergement)";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }
    
    /**
     * Mettre à jour enregistrement dans la table à partir de l'état d'un objet métier
     * @param string identifiant de l'enregistrement à mettre à jour
     * @param Groupe $objet objet métier à mettre à jour
     * @return boolean =FALSE si l'opérationn échoue
     */
    public static function update($id, Groupe $objet) {
        $requete = "UPDATE Groupe SET NOM =:nom, IDENTITERESPONSABLE =:identite, 
            ADRESSEPOSTALE =:adresse, NOMBREPERSONNES =:nbpers, 
            NOMPAYS =:nompays, HEBERGEMENT =:hebergement WHERE ID = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
    }
    
    /**
     * Détruire un enregistrement de la table TYPECHAMBRE d'après son identifiant
     * @param string identifiant de l'enregistrement à détruire
     * @return boolean =TRUE si l'enregistrement est détruit, =FALSE si l'opération échoue
     */
    public static function delete($id) {
        $ok = false;
        $requete = "DELETE FROM Groupe WHERE ID = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
    }

    /**
     * Recherche si le libellé proposé existe déjà dans la base de données
     * @param boolean $estModeCreation =true si mode création, =false si modification
     * @param string $id id du groupe à vérifier
     * @param string $nom
     * @return int le nombre de libellés de groupe déjà existant dans la BD (0 ou 1) ; c'est donc aussi un booléen
     */
    public static function isAnExistingNom($estModeCreation, $id, $nom) {
        $nom = str_replace("'", "''", $nom);
        // S'il s'agit d'une création, on vérifie juste la non existence du libellé
        // sinon on vérifie la non existence d'un autre type chambre (id!='$id') 
        // ayant le même libelle
        if ($estModeCreation) {
            $requete = "SELECT COUNT(*) FROM Groupe WHERE NOM=:nom";
            $stmt = Bdd::getPdo()->prepare($requete);
            $stmt->bindParam(':nom', $nom);
        } else {
            $requete = "SELECT COUNT(*) FROM Groupe WHERE NOM=:nom and ID <> :id";
            $stmt = Bdd::getPdo()->prepare($requete);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':id', $id);
        }
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }


    /**
     * Recherche un identifiant de type de chambre existant
     * @param string $id du type de chambre recherché
     * @return int le nombre de types de chambres correspondant à cet id (0 ou 1)
     */
    public static function isAnExistingId($id) {
        $requete = "SELECT COUNT(*) FROM Groupe WHERE ID=:id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }
    
    /**
     * Recherche un identifiant de type de chambre existant
     * @param string $id du type de chambre recherché
     * @return int le nombre de types de chambres correspondant à cet id (0 ou 1)
     */
    public static function isAnExistingIdInAttribution($id) {
        $requete = "SELECT COUNT(*) FROM Attribution WHERE IDGROUPE=:id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }
}
