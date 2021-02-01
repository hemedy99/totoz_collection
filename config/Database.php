<?php
class Database {
  // localhost
  private $hostName = "localhost";
  private $dbname = "totoz_collection";
  private $username = "root";
  private $password = "";


  private $pdo;

  // Start Connection
  public function __construct() {
    $this->pdo = null;
    try {
      $this->pdo = new PDO("mysql:host=$this->hostName;dbname=$this->dbname;", $this->username, $this->password);
      $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e) {
      echo "Error : ". $e->getMessage();
    }
  }

  public function fetchAll($query) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    if ($rowCount <= 0) {
      return 0;
    }
    else {
      return $stmt->fetchAll();
    }
  }

  public function fetchOne($query, $parameter) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$parameter]);
    $rowCount = $stmt->rowCount();
    if ($rowCount <= 0) {
      return 0;
    }else {
      return $stmt->fetch();
    }
  }

  public function fetchRequestNo() {
    $year = date('Y');
    $sql = "SELECT * FROM requests";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    if ($rowCount <= 0) {
      $asc =  '1/';
      return $asc.$year;
    }else {
      $sql1 = "SELECT * FROM requests ORDER BY id DESC LIMIT 1";
      $stmt1 = $this->pdo->prepare($sql1);
      $stmt1->execute();
      $row = $stmt1->fetch();
      $req = $row['requestNo'];
      $exp = explode("/" , $req); 
      $incre = $exp[0];
      $new_inc = $incre + 1;
      return $new_inc.'/'.$year;

    }
  }
  
  public function fetchLoggedUser($query, $username,$password) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$username,$password]);
    $rowCount = $stmt->rowCount();
    if ($rowCount <= 0) {
      return 0;
    }else {
      return $stmt->fetch();
    }
  }
  
    public function deleteOne($query, $id) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$id]);
  }
  
  public function insertUser($query, $userType,$firstName,$middleName,$lastName,$userName,$password,$userStatus) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$userType,$firstName,$middleName,$lastName,$userName,$password,$userStatus]);
  }
  
  public function updateUser($query, $userType,$firstName,$middleName,$lastName,$userName,$password,$userStatus, $id) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$userType,$firstName,$middleName,$lastName,$userName,$password,$userStatus, $id]);
  }
  
    public function insertUserType($query, $name) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$name]);
  }
  
  public function updateUserType($query, $name, $id) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$name,$id]);
  }

    public function insertUserStatus($query, $name) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$name]);
  }
  
  public function updateUserStatus($query, $name, $id) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$name,$id]);
  }

    public function insertProductCategory($query, $category) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$category]);
  }
  
  public function updateProductCategory($query, $category, $id) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$category,$id]);
  }

   public function insertProduct($query, $productCode,$productCategory,$description,$BP,$SP,$profit,$quantity) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$productCode,$productCategory,$description,$BP,$SP,$profit,$quantity]);
  }
  
  public function updateProduct($query, $productCode,$productCategory,$description,$BP,$SP,$profit,$quantity, $id) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$productCode,$productCategory,$description,$BP,$SP,$profit,$quantity,$id]);
  }

    

}