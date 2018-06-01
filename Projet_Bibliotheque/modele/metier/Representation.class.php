<?php
namespace modele\metier;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Création de la classe representation par RONY

class Representation {
    /**
     * code  de 8 caractères alphanum.
     * @var string
     */
    private $id;
    
    /** nom du lieu
     * @var Lieu
     */
    private $leLieu;
    /**
     * nom du groupe
     * @var Groupe
     */
    private $leGroupe;
    /**
     * date
     * @var Date
     */
    private $dateRep;
    /**
     * heuredebut
     * @var temps
     */
    
    private $heureDebut ;
    /**
     * heureFin
     * @var temps
     */
    private $heureFin ;
    
    
    function __construct($id, Lieu $leLieu, Groupe $leGroupe, $dateRep, $heureDebut, $heureFin) {
        $this->id = $id;
        $this->leLieu = $leLieu;
        $this->leGroupe = $leGroupe;
        $this->dateRep = $dateRep;
        $this->heureDebut = $heureDebut;
        $this->heureFin= $heureFin;
        
    }
    
    function getId() {
        return $this->id;
    }

    function getLeLieu() {
        return $this->leLieu;
    }

    function getLeGroupe() {
        return $this->leGroupe;
    }

    function getDateRep() {
        return $this->dateRep;
    }

    function getHeureDebut() {
        return $this->heureDebut;
    }

    function getHeureFin() {
        return $this->heureFin;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLeLieu(Lieu $leLieu) {
        $this->leLieu = $leLieu;
    }

    function setLeGroupe(Groupe $leGroupe) {
        $this->leGroupe = $leGroupe;
    }

    function setDateRep(Date $dateRep) {
        $this->dateRep = $dateRep;
    }

    function setHeureDebut(temps $heureDebut) {
        $this->heureDebut = $heureDebut;
    }

    function setHeureFin(temps $heureFin) {
        $this->heureFin = $heureFin;
    }

}
