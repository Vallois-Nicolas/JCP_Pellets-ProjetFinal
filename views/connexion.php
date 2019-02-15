<?php
session_start();
require '../controllers/connexionCtrl.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>Connexion - JCP Pellets</title>
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Produits
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="products.php">Tous les produits</a>
                            <a class="dropdown-item" href="products.php?category=REMPLIR">Another action</a>
                            <a class="dropdown-item" href="products.php?category=REMPLIR">Something else here</a>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="connexion.php">Se connecter</a>
                    </li>
                    <li>
                        <a class="nav-link" href="register.php">S'inscrire</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container generalDisplay shadow-lg p-3bg-white mt-3 mb-3 rounded">
            <h1 class="title">Connexion</h1>
            <form action="connexion.php" method="post" class="connexionForm">
                <div class="row connexionDiv">
                    <div class="offset-lg-1 col-lg-4">
                        <label for="username">Votre nom d'utilisateur : </label>
                    </div>
                    <div class="offset-lg-1 col-lg-4">
                        <input id="username" type="text" name="username" value="<?php if(isset($errors)){echo $_POST['username'];} ?>" data-toggle="popover" data-trigger="focus" title="Votre nom d'utilisateur" data-content="Doit correspondre à celui que vous avez renseigné lors de votre inscription." required>
                    </div>
                </div>
                <div class="row connexionDiv">
                    <div class="offset-lg-1 col-lg-4">
                        <label for="password">Votre mot de passe : </label>
                    </div>
                    <div class="offset-lg-1 col-lg-4">
                        <input id="password" type="password" name="password" data-toggle="popover" data-trigger="focus" title="Votre mot de passe" data-content="Doit correspondre à celui que vous avez renseigné lors de votre inscription." required>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-lg-5 col-lg-3">
                        <button type="submit" class="btn btn-primary buttonSubmit2">Se connecter</button>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-lg-4 col-lg-6">
                        <p class="dumbRegister">Vous n'êtes pas encore inscrit ? Inscrivez-vous ici: <a href="register.php">inscription</a></p>
                    </div>
                </div>
            </form>
            <?php
            if(COUNT($errors) > 0){
                foreach ($errors as $error){
                    ?>
            <div class="toast toastConnexion" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
                <div class="toast-header fail">
                    <img src="../assets/img/logoJCP.png" class="logoToast rounded mr-2" alt="logo JCP">
                    <strong class="mr-auto">Erreur</strong>
                </div>
                <div class="toast-body fail">
                    <?= $error; ?>
                </div>
            </div>
                    <?php
                }
            }
            ?>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <script src="../assets/js/script.js"></script>
    </body>
</html>