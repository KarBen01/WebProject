<?php

class User{
    private $id;
    private $anrede;
    private $vorname;
    private $nachname;
    private $adresse;
    private $plz;
    private $ort;
    private $username;
    private $password;
    private $emailadresse;
    private $timestamp;

    function __construct($id,$anrede,$vorname,$nachname,$adresse,$plz,$ort,$username,$password,$emailadresse,$timestamp){
        $this->id = $id;
        $this->anrede = $anrede;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->adresse = $adresse;
        $this->plz = $plz;
        $this->ort = $ort;
        $this->username = $username;
        $this->password = $password;
        $this->emailadresse = $emailadresse;
        $this->timestamp = $timestamp;
    }

    //set id und get id
    function set_id ($new_id){
        $this->id = $new_id;
    }
    function get_id (){
        return $this->id;
    }

    //set anrede und get anrede
    function set_anrede ($new_anrede){
        $this->anrede = $new_anrede;
    }
    function get_anrede (){
        return $this->anrede;
    }

    //set vorname und get vorname
    function set_vorname ($new_vorname){
        $this->vorname = $new_vorname;
    }
    function get_vorname (){
        return $this->vorname;
    }

    //set nachname und get nachname
    function set_nachname ($new_nachname){
        $this->nachname = $new_nachname;
    }
    function get_nachname (){
        return $this->nachname;
    }

    //set adresse und get adresse
    function set_adresse ($new_adresse){
        $this->adresse = $new_adresse;
    }
    function get_adresse (){
        return $this->adresse;
    }

    //set plz und get plz
    function set_plz ($new_plz){
        $this->plz = $new_plz;
    }
    function get_plz (){
        return $this->plz;
    }

    //set ort und get ort
    function set_ort ($new_ort){
        $this->ort = $new_ort;
    }
    function get_ort (){
        return $this->ort;
    }

    //set username und get username
    function set_username ($new_username){
        $this->username = $new_username;
    }
    function get_username (){
        return $this->username;
    }

    //set password und get password
    function set_password ($new_password){

        $this->password = $new_password;
    }
    function get_password (){
        return $this->password;
    }

    //set emailadresse und get emailadresse
    function set_emailadresse ($new_emailadresse){
        $this->emailadresse = $new_emailadresse;
    }
    function get_emailadresse (){
        return $this->emailadresse;
    }

    function set_timestamp ($new_timestamp){
        $this->timestamp = $new_timestamp;
    }
    function get_timestamp (){
        return $this->timestamp;
    }

}


?>




