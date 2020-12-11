<?php

class Website{
    public $id;
    public $title;
    public $url;
    public $description;

    function __construct($id, $title, $url, $description) {
        $this->id = $id;
        $this->title = $title;
        $this->url = $url;
        $this->description = $description;
    }
}