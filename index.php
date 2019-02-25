<?php
// Je démarre la session afin de pouvoir utiliser les éventuelles variables de session créées lors de la connexion
session_start();
// J'ai besoin ici de mon controller correspondant à la page d'accueil
require 'controllers/accueilCtrl.php'
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>JCP Pellets</title>
  <link rel="shortcut icon" href="assets/img/logoJCP.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow">
    <a class="navbar-brand" href="index.php"><img src="assets/img/logoJCP.png" id="logoNavabarJCP"/>JCP Pellets</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="views/cart.php">Mon panier</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Produits
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="views/products.php">Tous les produits</a>
                    <a class="dropdown-item" href="views/products.php?category=REMPLIR">Another action</a>
                    <a class="dropdown-item" href="views/products.php?category=REMPLIR">Something else here</a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav">
            <?php
            // Si la variable de session 'username' est présente, c'est que l'utilisateur est connecté et donc il est pertinent de lui afficher les liens vers la page de profil et de déconnexion
            if(isset($_SESSION['username'])){
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="views/profil.php">Votre profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?disconnect">Se déconnecter</a>
                </li>
                <?php
            // Sinon, l'utilisateur n'est pas connecté, par conséquent je lui affiche les liens vers les pages de connexion et d'inscription.
            }else{
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="views/connexion.php">Se connecter</a>
                </li>
                <li>
                    <a class="nav-link" href="views/register.php">S'inscrire</a>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</nav>
<?php
// Ici j'ai crée une vue spéciale pour l'accueil, je l'inclus donc donc mon index grâce à un include.
include 'views/accueil.php';
?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>
