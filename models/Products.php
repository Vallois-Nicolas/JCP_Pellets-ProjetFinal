<?php

/**
 * Description of Products
 *
 * @author majorduky
 */
class Products extends Database{
    
    public $id;
    public $price;
    public $name;
    public $image;
    public $image_type;
    public $description;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function addProduct(){
        $query = 'INSERT INTO `jcp_products`(price, name, image, image_type, description) VALUES (:price, :name, :image, :image_type, :description)';
        $addProduct = $this->db->prepare($query);
        $addProduct->bindValue(':price', $this->price, PDO::PARAM_STR);
        $addProduct->bindValue(':name', $this->name, PDO::PARAM_STR);
        $addProduct->bindValue(':image', $this->image, PDO::PARAM_LOB);
        $addProduct->bindValue(':image_type', $this->image_type, PDO::PARAM_STR);
        $addProduct->bindValue(':description', $this->description, PDO::PARAM_STR);
        if($addProduct->execute()){
            return true;
        }
    }
}
