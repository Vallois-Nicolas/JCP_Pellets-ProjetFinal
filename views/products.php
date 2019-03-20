<?php
session_start();
require '../controllers/productsCtrl.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>Produits - JCP Pellets</title>
        <link rel="shortcut icon" href="../assets/img/logoJCP.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow">
            <a class="navbar-brand" href="../index.php"><img src="../assets/img/logoJCP.png" id="logoNavabarJCP"/>JCP Pellets</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Mon panier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Nos produits</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php
            if(isset($_SESSION['username'])){
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="profil.php">Votre profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php?disconnect">Se déconnecter</a>
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
        <div class="container productsList generalDisplay shadow-lg p-3bg-white mt-3 mb-3 rounded">
            <?php
            if(isset($_GET['details'])){
                foreach($productDetails as $info){
                    ?>
            <div class="row spaceTop">
                <div class="col-5">
                    <img src="<?= 'data:' . $info->image_type . ';base64, ' . base64_encode($info->image) ?>" class="imgProductsDetails"/>
                </div>
                <div class="offset-1 col-6">
                    <h2><?= $info->name; ?></h2>
                    <hr>
                    <p>Description :</p>
                    <p class="descriptionProduct"><?= $info->description; ?></p>
                    <hr>
                    <p>Prix : <?= $info->price . ' €'; ?></p>
                    <?php
                    if(isset($_SESSION['id'])){
                        ?>
                    <p>Si vous souhaitez commander ce produit <?= $_SESSION['username'] ?>, merci de renseigner la quantité voulue, puis cliquez sur le bouton commander et laissez vous guider par nos instructions</p>
                    <form method="post" action="products.php">
                        <label for="quantity">Quantité voulue :</label>
                        <input type="number" name="quantity" id="quantity" data-toggle="popover" data-trigger="focus" title="Quantité" data-content="Doit être un chiffre." required>
                        <button type="submit" name="order" class="btn btn-warning btnDetails">Commander</button>
                    </form>
                        <?php
                    }else{
                        ?>
                    <p>Vous souhaitez commander cet article ? Inscrivez-vous dès maintenant en suivant <a href="register.php">ce lien</a> et profitez de notre catalogue !</p>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="row spaceTop">
                <div class="col-3 spaceTop">
                    <a href="products.php" class="btn btn-warning">Retour aux produits</a>
                </div>
            </div>
                    <?php
                }
            }else{
            ?>
            <div class="row spaceTop">
                <?php
                    foreach($productList as $prod){
                        ?>
                <div class="col-sm-12 col-lg-4 spaceTop">
                    <div class="card" style="width: 18rem;">
                        <img src="<?= 'data:' . $prod->image_type . ';base64, ' . base64_encode($prod->image) ?>" class="imgProducts"/>
                        <hr>
                        <div class="card-body">
                            <h5 class="card-title"><?= $prod->name; ?></h5>
                            <p class="price"><?= $prod->price . ' €'; ?></p>
                            <a href="products.php?details=<?= $prod->id; ?>" class="btn btn-primary btnDetails">Détails de l'article</a>
                        </div>
                    </div>
                </div>
                        <?php
                    }
                ?>
            </div>
            <?php
            }
            ?>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    </body>
</html>