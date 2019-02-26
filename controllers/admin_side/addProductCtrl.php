<?php
// J'ai besoin ici des models me permettant l'ajout d'un produit dans ma base de données
require '../../models/Database.php';
require '../../models/Products.php';
// Si le nombre de valeurs dans le tableau POST est supérieur à 0,
if(COUNT($_POST) > 0){
    
    // J'instancie ma classe Products dans une variable $product, celle-ci devient alors un objet.
    $product = new Products();
    // Je crée un tableau qui me servira à renvoyer les erreurs commises par l'administrateur lors de l'ajout d'un produit
    $errors = [];
    
    // Je stocke le contenu de chaque POST envoyé dans des variables
    $price = htmlspecialchars($_POST['price']);
    $name = htmlspecialchars($_POST['name']);
    // Je récupère ici le nom temporaire du fichier dans le tableau FILES
    $image = file_get_contents($_FILES['image']['tmp_name']);
    // Ici je stocke le type de l'image
    $image_type = addslashes($_FILES['image']['type']);
    // Grâce à la méthode exif_imagetype je récupère l'extension du fichier
    $image_ext = exif_imagetype($_FILES['image']['tmp_name']);
    // Je stocke également la valeur de la taille du fichier
    $image_size = $_FILES['image']['size'];
    $description = htmlspecialchars($_POST['description']);
    
    // Je stocke dans des variables les regex qui vont me permettre de tester les valeurs envoyées
    $regexPrice = '#^[0-9\.]+$#';
    $regexName = '#^[a-zéèàëäâêç \/\-_]+$#i';
    $regexText = '#^.+$#';
    
    // J'effectue ensuite une série de tests se basant sur mes regex et sur la tailles des données envoyées
    if(!preg_match($regexPrice, $price)){
        $errors[] = 'Veuillez renseigner un prix valide.';
    }else if(!preg_match($regexName, $name)){
        $errors[] = 'Veuillez renseigner un nom de produit valide.';
    }else if(!preg_match($regexText, $description) || strlen($description) > 255 || strlen($description) == 0){
        $errors[] = 'Veuillez renseigner une description correcte.';
    // 2 correspond au type JPEG et 3 correspond au type PNG
    }else if($image_ext != 3  && $image_ext != 2){
        $errors[] = 'Veuillez ajouter une image au format PNG ou JPEG.';
    }else if($image_size > 750000){
        $errors[] = 'Veuillez ajouter une image moins lourde (taille max : 750ko).';
    }else{
        
        // Si aucune erreur n'est renvoyé je peux donc hydrater les attriubuts nécessaires à l'ajout d'un produit
        $product->price = $price;
        $product->name = $name;
        $product->image = $image;
        $product->image_type = $image_type;
        $product->description = $description;
        
        // Si la méthode retourne true
        if($product->addProduct()){
            // Je redirige l'administrateur vers la page de gestion des produits
            header('Location: productsManagement.php');
        }
    }
}
