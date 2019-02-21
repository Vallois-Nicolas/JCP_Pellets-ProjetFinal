<?php
// Je démarre la session afin de pouvoir utiliser les éventuelles variables de session créées lors de la connexion
session_start();
// J'ai besoin ici de mon controller correspondant à la page d'inscription
require '../controllers/registerCtrl.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>Inscription - JCP Pellets</title>
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
            <h1 class='title'>Formulaire d'inscription</h1>
            <form method="post" action="register.php" class="registerForm">
                <div class="row registerDiv">
                    <div class="offset-lg-1 col-lg-4">
                        <label for="lastname">Nom : </label>
                    </div>
                    <div class="offset-lg-1 col-lg-4">
                        <input id="lastname" type="text" name="lastname" value="<?php if(COUNT($errors) > 0){echo $_POST['lastname'];}else{echo '';} ?>" data-toggle="popover" data-trigger="focus" title="Votre nom" data-content="Doit contenir 2 lettres au minimum." required>
                    </div>
                </div>
                <div class="row registerDiv">
                    <div class="offset-lg-1 col-lg-4">
                        <label for="firstname">Prénom : </label>
                    </div>
                    <div class="offset-lg-1 col-lg-4">
                        <input id="firstname" type="text" name="firstname" value="<?php if(COUNT($errors) > 0){echo $_POST['firstname'];}else{echo '';} ?>" data-toggle="popover" data-trigger="focus" title="Votre prénom" data-content="Doit contenir 2 lettres au minimum." required>
                    </div>
                </div>
                <div class="row registerDiv">
                    <div class="offset-lg-1 col-lg-4">
                        <label for="birthdate">Date de naissance : </label>
                    </div>
                    <div class="offset-lg-1 col-lg-4">
                        <input id="birthdate" type="date" name="birthdate" value="<?php if(COUNT($errors) > 0){echo $_POST['birthdate'];}else{echo '';} ?>" required>
                    </div>
                </div>
                <div class="row registerDiv">
                    <div class="offset-lg-1 col-lg-4">
                        <label for="phone">Numéro de téléphone : </label>
                    </div>
                    <div class="offset-lg-1 col-lg-4">
                        <input id="phone" type="tel" name="phone" value="<?php if(COUNT($errors) > 0){echo $_POST['phone'];}else{echo '';} ?>" data-toggle="popover" data-trigger="focus" title="Votre numéro de téléphone" data-content="Doit contenir entre 10 et 15 chiffres." required>
                    </div>
                </div>
                <div class="row registerDiv">
                    <div class="offset-lg-1 col-lg-4">
                        <label for="mail">Adresse mail : </label>
                    </div>
                    <div class="offset-lg-1 col-lg-4">
                        <input id="mail" type="email" name="mail" value="<?php if(COUNT($errors) > 0){echo $_POST['mail'];}else{echo '';} ?>" data-toggle="popover" data-trigger="focus" title="Votre adresse mail" data-content="Doit correspondre au format d'une adresse mail."required>
                    </div>
                </div>
                <div class="row registerDiv">
                    <div class="offset-lg-1 col-lg-4">
                        <label for="username">Votre futur nom d'utilisateur : </label>
                    </div>
                    <div class="offset-lg-1 col-lg-4">
                        <input id="username" type="text" name="username" value="<?php if(COUNT($errors) > 0){echo $_POST['username'];}else{echo '';} ?>" data-toggle="popover" data-trigger="focus" title="Votre nom d'utilisateur" data-content="Doit contenir entre 2 et 10 caractères." required>
                    </div>
                </div>
                <div class="row registerDiv">
                    <div class="offset-lg-1 col-lg-4">
                        <label for="password">Votre futur mot de passe : </label>
                    </div>
                    <div class="offset-lg-1 col-lg-4">
                        <input id="password" type="password" name="password" data-toggle="popover" data-trigger="focus" title="Votre mot de passe" data-content="Doit contenir au minimum : entre 8 et 15 caractères,  un caractère spécial parmi $ @ % * + - _ ! , une majuscule, une minuscule et un chiffre." required>
                    </div>
                </div>
                <div class="row registerDiv">
                    <div class="offset-lg-1 col-lg-4">
                        <label for="verifyPassword">Confirmez votre mot de passe : </label>
                    </div>
                    <div class="offset-lg-1 col-lg-4">
                        <input id="verifyPassword" type="password" name="verifyPassword" data-toggle="popover" data-trigger="focus" title="Confirmation du mot de passe" data-content="Veuillez renseigner le champ avec le même contenu que le champ ci-dessus."required>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-lg-5 col-lg-5">
                        <button type="submit" class="btn btn-primary buttonSubmit">S'inscrire</button>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-lg-4 col-lg-5">
                        <p class="dumbConnexion">Vous avez déjà un compte ? Connectez-vous ici: <a href="connexion.php">connexion</a></p>
                    </div>
                </div>   
            </form>
            <?php
            // Si une valeur est présente dans le tableau $errors créé dans le controller
            if(COUNT($errors) > 0){
                // Pour chaque valeur présente dans ce tableau, j'affiche un toast bootstrap (nouveauté 4.2) contenant le texte du message d'erreur
                foreach ($errors as $error){
                    ?>
            <div class="toast toastRegister" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
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
            // Si le tableau $success a été créé dans le controller et qu'il contient des valeurs
            if(isset($success) && COUNT($success) > 0){
                // Pour chaque message de succès j'affiche un toast bootstrap (nouveauté 4.2) contenant le texte du message en question
                foreach ($success as $isOk){
                    ?>
            <div class="toast toastRegister" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
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