<?php
require '../../models/Database.php';
require '../../models/Products.php';
// Si la variable de session rights n'est pas présente ou si elle est présente mais sa valeur est différente de 'admin'
if(!isset($_SESSION['rights']) || $_SESSION['rights'] != 'admin'){
    // je redirige sur la page index
    header('Location: ../../index.php');
}

$product = new Products();
$listProduct = $product->listProducts();