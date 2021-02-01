
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,X-Requested-With");

require_once "../../config/Database.php";
require_once "../../models/User.php";
require_once "../../models/HttpResponse.php";

$db = new Database();
$user = new User($db);
$http = new HttpResponse();


// CHECK INCOMING GET REQUESTS
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userReceived = json_decode(file_get_contents("php://input"));
    if((!$userReceived->userName) || (!$userReceived->password)){
    $http->badRequest("Username and Password should be provide");
        exit();
    }else{
        
    $username = $userReceived->userName;
    $password = $userReceived->password;
    $pass = md5($password); 
    //$query ="SELECT * FROM users WHERE userName =? AND password =?";
    $results = $user->fetchLoggedUser($username,$pass);
    if ($results === 0 ) {
        $message = "No user ";
        $message = " with the credentials was found";
        $http->notFound($message);

    } else {
        $http->OK($results);
    }
    }
    
} 

