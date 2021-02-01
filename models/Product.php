<?php
class Product {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function fetchAllProducts() {
        $query = "SELECT
        p.id AS productId,
        p.productCode,
        pc.id AS productCategoryId,
        pc.category AS productCategoryName,
        p.description,
        p.BP,
        p.SP,
        p.profit,
        p.quantity
        FROM products p
        LEFT JOIN productCategory pc ON p.productCategory=pc.id
        ";
        return $this->db->fetchAll($query);
    }
    public function fetchOneProduct($parameter) {
        $query = "SELECT
        p.id AS productId,
        p.productCode,
        pc.id AS productCategoryId,
        pc.category AS productCategoryName,
        p.description,
        p.BP,
        p.SP,
        p.profit,
        p.quantity
        FROM products p
        LEFT JOIN productCategory pc ON p.productCategory=pc.id
        WHERE p.id = ?";
        return $this->db->fetchOne($query, $parameter);
    }

    public function insertProduct($parameters) {
        $query = "INSERT INTO products (productCode,productCategory,description,BP,SP,profit,quantity)
        VALUES (?,?,?,?,?,?,?)";
        if (isset($parameters->productCode) && isset($parameters->productCategory) && isset($parameters->description) && isset($parameters->BP) && isset($parameters->SP) && isset($parameters->profit)&& isset($parameters->quantity) ) {
            $productCode = $parameters->productCode;
            $productCategory = $parameters->productCategory;
            $description = $parameters->description;
            $BP = $parameters->BP;
            $SP = $parameters->SP;
            $profit = $parameters->profit;
            $quantity = $parameters->quantity;
            $this->db->insertProduct($query, $productCode,$productCategory,$description,$BP,$SP,$profit,$quantity);
            return $parameters;
        }else {
          return -1;
        }
    }
    public function updateProductCategory($parameters) {
        $query = "UPDATE products SET
        productCode =?,
        productCategory=?,
        description=?,
        BP=?,
        SP=?,
        profit=?,
        quantity=?
        WHERE id = ?";
        if (isset($parameters['productCode']) && isset($parameters['id'])  && isset($parameters['productCategory']) && isset($parameters['description']) && isset($parameters['BP']) && isset($parameters['SP']) && isset($parameters['profit']) && isset($parameters['quantity'])) {
            $id = $parameters['id'];
            $productCode = $parameters['productCode'];
            $productCategory = $parameters['productCategory'];
            $description = $parameters['description'];
            $BP = $parameters['BP'];
            $SP = $parameters['SP'];
            $profit = $parameters['profit'];
            $quantity = $parameters['quantity'];
            $results = $this->db->updateProduct($query, $productCode,$productCategory,$description,$BP,$SP,$profit,$quantity,$id);
            return $parameters;
        } else {
            return -1;
        }
    }
    public function deleteProduct($id) {
        $query = "DELETE FROM products WHERE id = ?";
        $results = $this->db->deleteOne($query, $id);
        return [
            "message" => "Product with the id $id was successfully deleted",
        ];
    }

}