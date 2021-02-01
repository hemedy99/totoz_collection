<?php
class UserStatus {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function fetchAllUserStatus() {
        $query = "SELECT
        *
        FROM userStatus  ";
        return $this->db->fetchAll($query);
    }
    public function fetchOneUserStatus($parameter) {
        $query = "SELECT
        *
        FROM userStatus 
        WHERE id = ?";
        return $this->db->fetchOne($query, $parameter);
    }

    public function insertUserStatus($parameters) {
        $query = "INSERT INTO userStatus (name)
        VALUES (?)";
        if (isset($parameters->name) ) {
            $name = $parameters->name;
            $this->db->insertUserStatus($query, $name);
            return $parameters;
        }else {
          return -1;
        }
    }
    public function updateUserStatus($parameters) {
        $query = "UPDATE userStatus SET
        name = ?
        WHERE id = ?";
        if (isset($parameters['name']) && isset($parameters['id']) ) {
            $id = $parameters['id'];
            $name = $parameters['name'];
            $results = $this->db->updateUserStatus($query,$name,$id);
            return $parameters;
        } else {
            return -1;
        }
    }
    public function deleteUserStatus($id) {
        $query = "DELETE FROM userStatus WHERE id = ?";
        $results = $this->db->deleteOne($query, $id);
        return [
            "message" => "UserStatus with the id $id was successfully deleted",
        ];
    }

}