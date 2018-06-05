<?php
namespace modele\metier;

class Genre {
    /**
     * identifiant du genre
     * @var int
     */
    private $id;
    /**
     * libelle du genre
     * @var string
     */
    private $libelle;

    function __construct($id, $libelle) {
        $this->id = $id;
        $this->libelle = $libelle;
    }

    function getId() {
        return $this->id;
    }

    function getLibelle() {
        return $this->libelle;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLibelle($libelle) {
        $this->libelle = $libelle;
    }
}