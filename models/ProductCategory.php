<?php
class ProductCategory {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function fetchAllProductCategory() {
        $query = "SELECT
        *
        FROM productCategory  ";
        return $this->db->fetchAll($query);
    }
    public function fetchOneProductCategory($parameter) {
        $query = "SELECT
        *
        FROM productCategory 
        WHERE id = ?";
        return $this->db->fetchOne($query, $parameter);
    }

    public function insertProductCategory($parameters) {
        $query = "INSERT INTO productCategory (category)
        VALUES (?)";
        if (isset($parameters->category) ) {
            $category = $parameters->category;
            $this->db->insertProductCategory($query, $category);
            return $parameters;
        }else {
          return -1;
        }
    }
    public function updateProductCategory($parameters) {
        $query = "UPDATE productCategory SET
        category = ?
        WHERE id = ?";
        if (isset($parameters['category']) && isset($parameters['id']) ) {
            $id = $parameters['id'];
            $category = $parameters['category'];
            $results = $this->db->updateProductCategory($query,$category,$id);
            return $parameters;
        } else {
            return -1;
        }
    }
    public function deleteProductCategory($id) {
        $query = "DELETE FROM productCategory WHERE id = ?";
        $results = $this->db->deleteOne($query, $id);
        return [
            "message" => "ProductCategory with the id $id was successfully deleted",
        ];
    }

}