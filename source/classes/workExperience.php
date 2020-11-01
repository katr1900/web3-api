<?php

class WorkExperience{
    public $id;
    public $role;
    public $employeer;
    public $startDate;
    public $endDate;

    function __construct($id, $role, $employeer, $startDate, $endDate) {
        $this->id = $id;
        $this->role = $role;
        $this->employeer = $employeer;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
}