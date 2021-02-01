<?php
class UserType {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function fetchAllUserTypes() {
        $query = "SELECT
        *
        FROM userType  ";
        return $this->db->fetchAll($query);
    }
    public function fetchOneUserType($parameter) {
        $query = "SELECT
        *
        FROM userType 
        WHERE id = ?";
        return $this->db->fetchOne($query, $parameter);
    }

    public function insertUserType($parameters) {
        $query = "INSERT INTO userType (name)
        VALUES (?)";
        if (isset($parameters->name) ) {
            $name = $parameters->name;
            $this->db->insertUserType($query, $name);
            return $parameters;
        }else {
          return -1;
        }
    }
    public function updateUserType($parameters) {
        $query = "UPDATE userType SET
        name = ?
        WHERE id = ?";
        if (isset($parameters['name']) && isset($parameters['id']) ) {
            $id = $parameters['id'];
            $name = $parameters['name'];
            $results = $this->db->updateUserType($query,$name,$id);
            return $parameters;
        } else {
            return -1;
        }
    }
    public function deleteUserType($id) {
        $query = "DELETE FROM userType WHERE id = ?";
        $results = $this->db->deleteOne($query, $id);
        return [
            "message" => "UserType with the id $id was successfully deleted",
        ];
    }

}