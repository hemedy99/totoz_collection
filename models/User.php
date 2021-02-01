<?php
class User {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function fetchAllUsers() {
        $query = "SELECT
        u.id AS userId,
        ut.id AS userTypeId,
        ut.name AS userTypeName,
        u.firstName,u.middleName,u.lastName,u.userName,
        u.password,
        us.id AS userStatusId,
        us.name AS userStatusName
        FROM users u 
        LEFT JOIN userType ut ON u.userType=ut.id
        LEFT JOIN userStatus us ON u.userStatus=us.id ";
        return $this->db->fetchAll($query);
    }
    public function fetchOneUser($parameter) {
        $query = "SELECT
        u.id AS userId,
        ut.id AS userTypeId,
        ut.name AS userTypeName,
        u.firstName,u.middleName,u.lastName,u.userName,
        u.password,
        us.id AS userStatusId,
        us.name AS userStatusName
        FROM users u 
        LEFT JOIN userType ut ON u.userType=ut.id
        LEFT JOIN userStatus us ON u.userStatus=us.id
        WHERE u.id = ?";
        return $this->db->fetchOne($query, $parameter);
    }
    
    public function fetchLoggedUser($username,$password) {
        $query = "SELECT
        u.id AS userId,
        ut.id AS userTypeId,
        ut.name AS userTypeName,
        u.firstName,u.middleName,u.lastName,u.userName,
        u.password,
        us.id AS userStatusId,
        us.name AS userStatusName
        FROM users u 
        LEFT JOIN userType ut ON u.userType=ut.id
        LEFT JOIN userStatus us ON u.userStatus=us.id
        WHERE u.userName = ? AND password=?";
        return $this->db->fetchLoggedUser($query, $username,$password);
    }
    
    

    public function insertUser($parameters) {
        $query = "INSERT INTO users (userType,firstName,middleName,lastName,userName,password,userStatus)
        VALUES (?, ?, ?,?,?,?,?)";
        if (isset($parameters->userType) && isset($parameters->firstName) && isset($parameters->middleName) && isset($parameters->lastName) && isset($parameters->userName)&& isset($parameters->password) && isset($parameters->userStatus) ) {
            $userType = $parameters->userType;
            $firstName = $parameters->firstName;
            $middleName = $parameters->middleName;
            $lastName = $parameters->lastName;
            $userName = $parameters->userName;
            $pass = $parameters->password;
            $password = md5($pass);
            $userStatus = $parameters->userStatus;
         
            $this->db->insertUser($query, $userType,$firstName,$middleName,$lastName,$userName,$password,$userStatus);
            return $parameters;
        }else {
          return -1;
        }
    }
    public function updateUser($parameters) {
        $query = "UPDATE users SET
        userType = ?,
        firstName = ? ,
        middleName = ?,
        lastName = ? ,
        userName = ?,
        password = ? ,
        userStatus = ?
        WHERE id = ?";
        if (isset($parameters['userType']) && isset($parameters['id']) && isset($parameters['firstName'])  && isset($parameters['middleName']) && isset($parameters['lastName'])  && isset($parameters['userName']) && isset($parameters['password']) && isset($parameters['userStatus'])) {
            $id = $parameters['id'];
            $userType = $parameters['userType'];
            $firstName = $parameters['firstName'];
            $middleName = $parameters['middleName'];
            $lastName = $parameters['lastName'];
            $userName = $parameters['userName'];
            $pass = $parameters['password'];
            $password = md5($pass);
            $userStatus = $parameters['userStatus'];
            $results = $this->db->updateUser($query,$userType,$firstName,$middleName,$lastName,$userName,$password,$userStatus, $id);
            return $parameters;
        } else {
            return -1;
        }
    }
    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE id = ?";
        $results = $this->db->deleteOne($query, $id);
        return [
            "message" => "User with the id $id was successfully deleted",
        ];
    }

}