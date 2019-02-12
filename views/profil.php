<?php
session_start();
require '../controllers/profilCtrl.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>Mon profil - JCP Pellets</title>
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
                        <a class="nav-link" href="profil.php">Votre profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php?disconnect">Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container generalDisplay shadow-lg p-3bg-white mt-3 mb-3 rounded">
            <h1 class="title">Vos informations</h1>
            <form method="post" action="profil.php">
                <div class="row">
                    <div class="offset-lg-3 col-lg-3 infoDisplay">
                        <p>Votre nom :</p>
                    </div>
                    <div class="col-lg-5 resultInfoDisplay">
                        <p class="infoUser"><?= $user->lastname; ?></p>
                        <input type="text" name="changeLastname" value="<?= $user->lastname; ?>" class="modifyForm" data-toggle="popover" data-trigger="focus" title="Votre nom" data-content="Doit contenir 2 lettres au minimum." required>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-lg-3 col-lg-3 infoDisplay">
                        <p>Votre prénom :</p>
                    </div>
                    <div class="col-lg-5 resultInfoDisplay">
                        <p class="infoUser"><?= $user->firstname; ?></p>
                        <input type="text" name="changeFirstname" value="<?= $user->firstname; ?>" class="modifyForm" data-toggle="popover" data-trigger="focus" title="Votre prénom" data-content="Doit contenir 2 lettres au minimum." required>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-lg-3 col-lg-3 infoDisplay">
                        <p>Votre date de naissance :</p>
                    </div>
                    <div class="col-lg-5 resultInfoDisplay">
                        <p class="infoUser"><?php setlocale(LC_TIME, 'fr_FR.UTF8');$date = strftime('%A %d %B %Y', strtotime("$user->birthdate"));echo $date; ?></p>
                        <input type="date" name="changeBirthdate" value="<?= $user->birthdate; ?>" class="modifyForm" required>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-lg-3 col-lg-3 infoDisplay">
                        <p>Votre numéro de téléphone :</p>
                    </div>
                    <div class="col-lg-5 resultInfoDisplay">
                        <p class="infoUser"><?= $user->phone; ?></p>
                        <input type="text" name="changePhone" value="<?= $user->phone; ?>" class="modifyForm" data-toggle="popover" data-trigger="focus" title="Votre numéro de téléphone" data-content="Doit contenir entre 10 et 15 chiffres." required>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-lg-3 col-lg-3 infoDisplay">
                        <p>Votre adresse mail :</p>
                    </div>
                    <div class="col-lg-5 resultInfoDisplay">
                        <p class="infoUser"><?= $user->mail; ?></p>
                        <input type="text" name="changeMail" value="<?= $user->mail; ?>" class="modifyForm" data-toggle="popover" data-trigger="focus" title="Votre adresse mail" data-content="Doit correspondre au format d'une adresse mail."required>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-lg-3 col-lg-3 infoDisplay">
                        <p>Votre nom d'utilisateur :</p>
                    </div>
                    <div class="col-lg-5 resultInfoDisplay">
                        <p class="infoUser"><?= $user->username; ?></p>
                        <input type="text" name="changeUsername" value="<?= $_SESSION['username']; ?>" class="modifyForm" data-toggle="popover" data-trigger="focus" title="Votre nom d'utilisateur" data-content="Doit contenir entre 2 et 10 caractères." required>
                    </div>
                </div>
                <button type="submit" id="submitModifForm" class="btn btn-primary modificationButtons">Soumettre vos modifications</button>
            </form>
            <button id="showModifForm" class="btn btn-primary modificationButtons">Modifier vos informations</button>
            <button id="cancelModifForm" class="btn btn-warning cancelButton">Annuler la modification</button>
            <div>
                <button id="deleteAccount" class="btn btn-danger">Supprimer votre compte</button>
                <p id="agreementSentence">Souhaitez-vous réellement supprimer votre compte ? L'action est irréversible, vous perdrez toutes vos données.</p>
                <a id="agreementDeleteAccount" class="btn btn-danger" href="../index.php?deleteAccount">Oui</a>
                <button id="disagreeDeleteAccount" class="btn btn-danger">Non, retour</button>       
            </div>
            <?php
            if(COUNT($errors) > 0){
                foreach ($errors as $error){
                    ?>
            <div class="toast toastModify" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
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
            if(isset($success) && COUNT($success) > 0){
                foreach ($success as $isOk){
                    ?>
            <div class="toast toastModify" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
                <div class="toast-header success">
                    <img src="../assets/img/logoJCP.png" class="logoToast rounded mr-2" alt="logo JCP">
                    <strong class="mr-auto">Succès !</strong>
                </div>
                <div class="toast-body success">
                    <?= $isOk; ?>
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