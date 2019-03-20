<?php
require '../models/Database.php';
require '../models/Products.php';

$product = new Products();
$productList = $product->listProducts();

if(isset($_GET['details'])){
    $productId = htmlspecialchars($_GET['details']);
    $product->id = $productId;
    $productDetails = $product->infoProduct();
}