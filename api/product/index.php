<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With");

require_once "../../config/Database.php";
require_once "../../models/Product.php";
require_once "../../models/HttpResponse.php";

$db = new Database();
$prod = new Product($db);
$http = new HttpResponse();


if ($_SERVER['REQUEST_METHOD'] !== 'OPTIONS') {
if (!isset($_SERVER['PHP_AUTH_USER']) && !isset($_SERVER['PHP_AUTH_PW'])) {
    $http->notAuthorized("You must authenticate yourself before you can use our REST API services");
    exit();
} else {
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
   // $pass = md5($password);
    $query = "SELECT * FROM users WHERE username = ?";
    $results = $db->fetchOne($query, $username);

    if ($results === 0 || $results['password'] !== $password) {
        $http->notAuthorized("You provided wrong credentials");
        exit();
    } else {
        $user_id = $results['id'];
    }
}
}
// CHECK INCOMING GET REQUESTS
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id']) && !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
        // ERROR ONLY INTEGER IS ALLOWED
        $http->badRequest("Only a valid integer is allowed to fetch a Product");
        die();
    }
    // FETCH ONE USER IF ID EXISTS OR ALL IF ID DOESN'T EXIST
    $resultsData = isset($_GET['id']) ? $prod->fetchOneProduct($_GET['id']) : $prod->fetchAllProducts();

    if ($resultsData === 0) {
        $message = "No Product ";
        $message .= isset($_GET['id']) ? "with the id " . $_GET['id'] : "";
        $message .= " was found";
        $http->notFound($message);
    }else {
      $http->OK($resultsData);
    }
} else if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $prodReceived = json_decode(file_get_contents("php://input"));
    $results = $prod->insertProduct($prodReceived);
    if ($results === -1) {
      $http->badRequest("A valid JSON of ProductCategory fields is required");
    }else {
      $http->OK($results);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  $prodReceived = json_decode(file_get_contents("php://input"));
  if (!$prodReceived->id) {
    // POST ID NOT PROVIDED BAD REQUEST
    $http->badRequest("Please an id is required to make a PUT request");
    exit();
  }
  $query = "SELECT * FROM products WHERE id = ?";
  $results = $db->fetchOne($query, $prodReceived->id);
  if ($results === 0) {
    // Post NOT Found
    $http->notFound("Product with the id $prodReceived->id was not found");
  }else {
    // USER CAN UPDATE
    $parameters = [
      'id' => $prodReceived->id,
      'productCode' => isset($prodReceived->productCode) ? $prodReceived->productCode : $results['productCode'],
      'productCategory' => isset($prodReceived->productCategory) ? $prodReceived->productCategory : $results['productCategory'],
      'description' => isset($prodReceived->description) ? $prodReceived->description : $results['description'],
      'BP' => isset($prodReceived->BP) ? $prodReceived->BP : $results['BP'],
      'SP' => isset($prodReceived->SP) ? $prodReceived->SP : $results['SP'],
      'profit' => isset($prodReceived->profit) ? $prodReceived->profit : $results['profit'],
      'quantity' => isset($prodReceived->quantity) ? $prodReceived->quantity : $results['quantity']
      
    ];

    $resultsData = $prod->updateProduct($parameters);
      $http->OK($resultsData);
    
  }
} else if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
  $idReceived = json_decode(file_get_contents("php://input"));
  if (!$idReceived->id) {
    $http->badRequest("No id was provided");
    exit();
  }
  $query = "SELECT * FROM products WHERE id = ?";
  $results = $db->fetchOne($query, $idReceived->id);

  if ($results === 0) {
    // POST NOT FOUND
    $http->notFound("Product with the id $idReceived->id was not found");
    exit();
  }
  else {
    // User CAN NOW DELETE USER
    $resultsData = $prod->deleteProduct($idReceived->id);

      $http->OK( $resultsData);
  }


}