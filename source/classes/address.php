<?php

class Address{
    public $id;
    public $street;
    public $zip;
    public $city;
    public $country;

    function __construct($id, $street, $zip, $city, $country) {
        $this->id = $id;
        $this->street = $street;
        $this->zip = $zip;
        $this->city = $city;
        $this->country = $country;
    }
}