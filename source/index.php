<?php
include('includes/config.php');
include('classes/cv.php');

header("Content-Type: application/json; charset=UTF-8"); // Returnera JSON

// Aktivera CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type");

$method = $_SERVER['REQUEST_METHOD']; // Läs ut vilket verb anropet har

switch($method){
    case 'GET':
        get();
    break;
    case 'POST':
        post();
    break;
    case 'DELETE':
        delete();
    break;
    case 'PUT':
        put();
    break;
}
function get(){
    http_response_code(200);
    $cv = new CV();
    $response = $cv->get();
    echo json_encode($response); // Returnerar CV som JSON
}

function post(){
    http_response_code(200);
    $data = json_decode(file_get_contents('php://input'), true); // Hämta anropets data och konvertera från JSON
    $cv = new CV();
    // Kontrollera vad som ska läggas till
    if (isset($data['language'])) {
        $language = $data['language'];
        $language = new Language(0, $language['name'], $language['level']);
        $cv->addLanguage($language);
    } else if (isset($data['skill'])) {
        $skill = $data['skill'];
        $skill = new Skill(0, $skill['name'], $skill['level']);
        $cv->addSkill($skill);
    } else if (isset($data['interest'])) {
        $interest = $data['interest'];
        $interest = new Interest(0, $interest['name']);
        $cv->addInterest($interest);
    } else if (isset($data['education'])) {
        $education = $data['education'];
        $education = new Education(0, $education['course'], $education['school'], $education['startdate'], $education['enddate']);
        $cv->addEducation($education);
    } else if (isset($data['experience'])) {
        $experience = $data['experience'];
        $experience = new WorkExperience(0, $experience['role'], $experience['employeer'], $experience['startdate'], $experience['enddate']);
        $cv->addWorkExperience($experience);
    } else if (isset($data['reference'])) {
        $reference = $data['reference'];
        $reference = new WorkReference(0, $reference['name'], $reference['phone']);
        $cv->addWorkReference($reference);
    }
}
function delete(){
    http_response_code(200);
    $data = json_decode(file_get_contents('php://input'), true);  // Hämta anropets data och konvertera från JSON
    $cv = new CV();

    // Kontrollera vad som ska tas bort
    if (isset($data['skill'])) {
        $skill = $data['skill'];
        $id = $skill['id'];
        $cv->deleteSkill($id);
    }
}
function put(){
    http_response_code(200);
    $data = json_decode(file_get_contents('php://input'), true);  // Hämta anropets data och konvertera från JSON
    $cv = new CV();

    // Kontrollera vad som ska uppdateras
    if (isset($data['personalInfo'])) {
        $personalInfo = $data['personalInfo'];
        $personalInfo=new PersonalInfo($personalInfo['id'], $personalInfo['firstname'], $personalInfo['lastname'], 
        $personalInfo['phone'], $personalInfo['email'], $personalInfo['linkedin'], $personalInfo['drivinglicense'], $personalInfo['about']);
        $cv->updatePersonalInfo($personalInfo);
    } else if (isset($data['address'])) {
        $address = $data['address'];
        $address = new Address($address["id"], $address['street'], $address['zip'], $address['city'], $address['country']);
        $cv->updateAddress($address);
    }
}
?>
