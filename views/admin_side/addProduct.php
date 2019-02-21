<?php
// Je démarre la session afin de pouvoir utiliser les éventuelles variables de session créées lors de la connexion
session_start();
// J'ai besoin ici de mon controller correspondant à la page d'ajout des produits côté administrateur
require '../../controllers/admin_side/addProductCtrl.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>Gestion produits - JCP Pellets</title>
        <link rel="shortcut icon" href="../assets/img/logoJCP.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="stylesheet" href="../../assets/css/style.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow">
            <a class="navbar-brand" href="accueilAdmin.php"><img src="../../assets/img/logoJCP.png" id="logoNavabarJCP"/>JCP Pellets</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="usersManagement.php">Gestion utilisateurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="addProduct.php">Ajouter un produit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="productsManagement.php">Gestion produits</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php
            if(isset($_SESSION['username'])){
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../../index.php?disconnect">Se déconnecter</a>
                    </li>
                <?php
            }else{
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="connexion.php">Se connecter</a>
                    </li>
                    <li>
                        <a class="nav-link" href="register.php">S'inscrire</a>
                    </li>
                <?php
            }
            ?>
                </ul>
            </div>
        </nav>
        <div class="container generalDisplay shadow-lg p-3bg-white mt-3 mb-3 rounded">
            <h1 class="title">Ajout de produit</h1>
            <form action="connexion.php" method="post" class="addProductForm">
                <div class="row addProductDiv">
                    <div class="offset-lg-1 col-lg-4">
                        <label for="name">Nom de l'objet : </label>
                    </div>
                    <div class="offset-lg-1 col-lg-4">
                        <input id="name" type="text" name="name" data-toggle="popover" data-trigger="focus" title="Choisir un nom pour le produit" data-content="Doit être clair et compréhensible" required>
                    </div>
                </div>
                <div class="row addProductDiv">
                    <div class="offset-lg-1 col-lg-4">
                        <label for="price">Prix : </label>
                    </div>
                    <div class="offset-lg-1 col-lg-4">
                        <input id="price" type="text" name="price" data-toggle="popover" data-trigger="focus" title="Choisir un prix" data-content="Doit être un chiffre entier ou décimal." required>
                    </div>
                </div>
                <div class="row addProductDiv">
                    <div class="offset-lg-1 col-lg-4">
                        <label for="description">Description : </label>
                    </div>
                    <div class="offset-lg-1 col-lg-4">
                        <textarea id="description" name="description" data-toggle="popover" data-trigger="focus" title="Entrer une description" data-content="Doit faire au maximum 255 caractères." required></textarea>
                    </div>
                </div>
                <div class="row addProductDiv">
                    <div class="offset-lg-1 col-lg-4">
                        <label for="image">Image (png): </label>
                    </div>
                    <div class="offset-lg-1 col-lg-4">
                        <input id="image" type="file" name="image" data-toggle="popover" data-trigger="focus" title="Choisir une image" data-content="Doit être au format png." required>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-lg-5 col-lg-3">
                        <button type="submit" class="btn btn-primary buttonSubmit2">Ajout produit</button>
                    </div>
                </div>
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <script src="../../assets/js/script.js"></script>
    </body>
</html>
