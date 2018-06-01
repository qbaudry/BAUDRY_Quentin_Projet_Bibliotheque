<?php
namespace modele\metier;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Création de la classe Lieu par RONY

class Lieu {
    /**
     * code  de 8 caractères alphanum.
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $nomLieu;
    /**
     * nom du lieu
     * @var string
     */
    private $adresseLieu;
    /**
     * adresseLieu
     * @var integer
     */
    private $capaciteAccueil;
    
    
    function __construct($id, $nomLieu, $adresseLieu, $capaciteAccueil) {
        $this->id = $id;
        $this->nomLieu = $nomLieu;
        $this->adresseLieu = $adresseLieu;
        $this->capaciteAccueil = $capaciteAccueil;
        
    }
    
    function getId() {
        return $this->id;
    }

    function getNomLieu() {
        return $this->nomLieu;
    }

    function getAdresseLieu() {
        return $this->adresseLieu;
    }

    function getcapaciteAccueil() {
        return $this->capaciteAccueil;
    }

   function setId($id) {
        $this->id = $id;
    }

    function setNomLieu($nomLieu) {
        $this->nomLieu = $nomLieu;
    }

    function setAdresseLieu($adresseLieu) {
        $this->adresseLieu = $adresseLieu;
    }

    function setcapaciteAccueil($capaciteAccueil) {
        $this->capaciteAccueil = $capaciteAccueil;
    }

}