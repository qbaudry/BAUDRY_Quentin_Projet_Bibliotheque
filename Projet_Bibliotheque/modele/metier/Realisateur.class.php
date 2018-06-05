<?php
namespace modele\metier;

class Realisateur {
    /**
     * identifiant du realisateur
     * @var int
     */
    private $id;
    /**
     * nom du realisateur
     * @var string
     */
    private $nom;
    /**
     * prenom du realisateur
     * @var string 
     */
    private $prenom;

    function __construct($id, $nom, $prenom) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }
}