<?php

class PersonalInfo{
    public $id;
    public $firstname;
    public $lastname;
    public $phone;
    public $email;
    public $linkedin;
    public $drivingLicense;
    public $about;

    function __construct($id, $firstname, $lastname, $phone, $email, $linkedin, $drivingLicense, $about) {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->phone = $phone;
        $this->email = $email;
        $this->linkedin = $linkedin;
        $this->drivingLicense = $drivingLicense;
        $this->about = $about;
    }
}