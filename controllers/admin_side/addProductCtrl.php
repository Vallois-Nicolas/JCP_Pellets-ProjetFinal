<?php
require '../../models/Database.php';
require '../../models/Products.php';
if(COUNT($_POST) > 0){
    
    $product = new Products();
    $errors = [];
    
    $price = htmlspecialchars($_POST['price']);
    $name = htmlspecialchars($_POST['name']);
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $image_type = addslashes($_FILES['image']['type']);
    $image_ext = exif_imagetype($_FILES['image']['tmp_name']);
    $image_size = $_FILES['image']['size'];
    $description = addslashes(htmlspecialchars($_POST['description']));
    
    $regexPrice = '#^[0-9\.]+$#';
    $regexName = '#^[a-zéèàëäâêç]+$#i';
    $regexText = '#^.+$#';
    
    if(!preg_match($regexPrice, $price)){
        $errors[] = 'Veuillez renseigner un prix valide.';
    }else if(!preg_match($regexName, $name)){
        $errors[] = 'Veuillez renseigner un nom de produit valide.';
    }else if(!preg_match($regexText, $description) || strlen($description) > 255 || strlen($description) == 0){
        $errors[] = 'Veuillez renseigner une description correcte.';
    }else if($image_ext != 3){
        $errors[] = 'Veuillez ajouter une image au format PNG ou JPEG.';
    }else if($image_size > 750000){
        $errors[] = 'Veuillez ajouter une image moins lourde (taille max : 750ko).';
    }else{
        
        $product->price = $price;
        $product->name = $name;
        $product->image = $image;
        $product->image_type = $image_type;
        $product->description = $description;
        
        if($product->addProduct()){
            header('Location: productsManagement.php');
        }
    }
}
