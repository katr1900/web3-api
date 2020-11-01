<?php

class Education{
    public $id;
    public $course;
    public $school;
    public $startDate;
    public $endDate;

    function __construct($id, $course, $school, $startDate, $endDate) {
        $this->id = $id;
        $this->course = $course;
        $this->school = $school;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
}