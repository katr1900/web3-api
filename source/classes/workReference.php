<?php

class WorkReference{
    public $id;
    public $name;
    public $phone;

    function __construct($id, $name, $phone) {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
    }
}