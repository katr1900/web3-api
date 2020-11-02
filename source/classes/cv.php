<?php
include('address.php');
include('education.php');
include('interest.php');
include('language.php');
include('personalInfo.php');
include('skill.php');
include('workExperience.php');
include('workReference.php');

class CV{
    private $db;

    public $address;
    public $educations;
    public $interests;
    public $languages;
    public $personalInfo;
    public $skills;
    public $workExperiences;
    public $workReferences;
    
    function __construct() {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE); // Anslut till databasen
        
        if($this->db->connect_errno > 0){
            die('unable to connect to database ['. $this->db->connect_error . ']');
        }
    }

    public function get(){
        $this->personalInfo = $this->getPersonalInfo();
        $this->address = $this->getAddress();
        $this->educations = $this->getEducations();
        $this->languages = $this->getLanguages();
        $this->skills = $this->getSkills();
        $this->workExperiences = $this->getWorkExperiences();
        $this->workReferences = $this->getWorkReferences();
        $this->interests = $this->getInterests();

        return $this;
    }

    public function deleteSkill($id){
        $statement = $this->db->prepare("DELETE FROM skills WHERE id = ?");
        $statement->bind_param("i",$id);
        $statement->execute();
    }

    private function getPersonalInfo() {
        $statement = $this->db->prepare("SELECT * FROM `personal_info`");
        $statement->execute();
        
        $result = $statement->get_result();

        if(!$result){
            die('There was an error running the query [' . $this->db->error. ']');
        }
        $row = $result->fetch_assoc(); // Hämta en rad
        if(!$row){ // Om Personal_Info inte finns
            return null;
        }
        
        return new PersonalInfo($row['id'], $row['firstname'], $row['lastname'], $row['phone'], $row['email'], $row['linkedin'], $row['driving_license'], $row['about']);
    }

    public function updatePersonalInfo($personalInfo) {
        $statement = $this->db->prepare("UPDATE personal_info SET firstname = ?, lastname = ?, phone = ?, email = ?, linkedin = ?, driving_license = ?, about = ? WHERE id = ?");
        $statement->bind_param("sssssssi",$personalInfo->firstname, $personalInfo->lastname, $personalInfo->phone, $personalInfo->email, 
            $personalInfo->linkedin, $personalInfo->drivingLicense, $personalInfo->about, $personalInfo->id);
        $statement->execute();
    }

    public function updateAddress($address) {
        var_dump($address);
        $statement = $this->db->prepare("UPDATE addresses SET street = ?, zip = ?, city = ?, country = ? WHERE id = ?");
        $statement->bind_param("ssssi",$address->street, $address->zip, $address->city, $address->country, $address->id);
        $statement->execute();
    }

    private function getAddress() {
        $statement = $this->db->prepare("SELECT * FROM `addresses`");
        $statement->execute();
        
        $result = $statement->get_result();

        if(!$result){
            die('There was an error running the query [' . $this->db->error. ']');
        }
        $row = $result->fetch_assoc(); // Hämta en rad
        if(!$row){ // Om address inte finns
            return null;
        }

        return new Address($row['id'], $row['street'], $row['zip'], $row['city'], $row['country']);
    }

    public function addLanguage($language) {
        $statement = $this->db->prepare("INSERT INTO languages (Name, Level) Values (?, ?)");
        $statement->bind_param("si",$language->name,$language->level);
        $statement->execute();
    }

    public function addSkill($skill) {
        $statement = $this->db->prepare("INSERT INTO skills (Name, Level) Values (?, ?)");
        $statement->bind_param("si",$skill->name,$skill->level);
        $statement->execute();
    }

    public function addInterest($interest) {
        $statement = $this->db->prepare("INSERT INTO interests (Name) Values (?)");
        $statement->bind_param("s",$interest->name);
        $statement->execute();
    }

    public function addEducation($education) {
        $statement = $this->db->prepare("INSERT INTO educations (course, school, startdate, enddate) Values (?, ?, ?, ?, ?)");
        $statement->bind_param("ssss",$education->course, $education->school, $education->startDate, $education->endDate);
        $statement->execute();
    }

    public function addWorkExperience($workExperience) {
        $statement = $this->db->prepare("INSERT INTO workexperiences (role, employeer, startdate, enddate) Values (?, ?, ?, ?, ?)");
        $statement->bind_param("ssss",$workExperience->role, $workExperience->employeer, $workExperience->startDate, $workExperience->endDate);
        $statement->execute();
    }

    public function addWorkReference($workReference) {
        $statement = $this->db->prepare("INSERT INTO workreferences (name, phone) Values (?, ?)");
        $statement->bind_param("ss",$workReference->name, $workReference->phone);
        $statement->execute();
    }

    private function getEducations() {
        $statement = $this->db->prepare("SELECT * FROM educations");
        $statement->execute();
        
        $result = $statement->get_result();

        if(!$result){
            die('There was an error running the query [' . $this->db->error. ']');
        }
        $educations = [];

        // Loopa igenom alla rader
        while($row = $result->fetch_assoc()){
            $education=new Education($row['id'], $row['course'], $row['school'], $row['startdate'], $row['enddate']);
            array_push($educations,$education);
        }

        return $educations;
    }

    private function getLanguages() {
        $statement = $this->db->prepare("SELECT * FROM languages");
        $statement->execute();
        
        $result = $statement->get_result();

        if(!$result){
            die('There was an error running the query [' . $this->db->error. ']');
        }
        $languages = [];

        // Loopa igenom alla rader
        while($row = $result->fetch_assoc()){
            $language=new Language($row['id'], $row['name'], $row['level']);
            array_push($languages,$language);
        }

        return $languages;
    }

    private function getSkills() {
        $statement = $this->db->prepare("SELECT * FROM skills");
        $statement->execute();
        
        $result = $statement->get_result();

        if(!$result){
            die('There was an error running the query [' . $this->db->error. ']');
        }
        $skills = [];

        // Loopa igenom alla rader
        while($row = $result->fetch_assoc()){
            $skill=new Skill($row['id'], $row['name'], $row['level']);
            array_push($skills,$skill);
        }

        return $skills;
    }

    private function getWorkExperiences() {
        $statement = $this->db->prepare("SELECT * FROM workexperiences");
        $statement->execute();
        
        $result = $statement->get_result();

        if(!$result){
            die('There was an error running the query [' . $this->db->error. ']');
        }
        $workExperiences = [];

        // Loopa igenom alla rader
        while($row = $result->fetch_assoc()){
            $workExperience=new WorkExperience($row['id'], $row['role'], $row['employeer'], $row['startdate'], $row['enddate']);
            array_push($workExperiences,$workExperience);
        }

        return $workExperiences;
    }

    private function getWorkReferences() {
        $statement = $this->db->prepare("SELECT * FROM workreferences");
        $statement->execute();
        
        $result = $statement->get_result();

        if(!$result){
            die('There was an error running the query [' . $this->db->error. ']');
        }
        $workReferences = [];

        // Loopa igenom alla rader
        while($row = $result->fetch_assoc()){
            $workReference=new WorkReference($row['id'], $row['name'], $row['phone']);
            array_push($workReferences,$workReference);
        }

        return $workReferences;
    }

    private function getInterests() {
        $statement = $this->db->prepare("SELECT * FROM interests");
        $statement->execute();
        
        $result = $statement->get_result();

        if(!$result){
            die('There was an error running the query [' . $this->db->error. ']');
        }
        $interests = [];

        // Loopa igenom alla rader
        while($row = $result->fetch_assoc()){
            $interest=new Interest($row['id'], $row['name']);
            array_push($interests,$interest);
        }

        return $interests;
    }
}