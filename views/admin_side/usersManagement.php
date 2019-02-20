<?php
session_start();
require '../../controllers/admin_side/usersManagementCtrl.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>Gestion utilisateurs - JCP Pellets</title>
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
        <?php
        if(!isset($_GET['modifyId'])){
        ?>
            <div class="container-fluid">
                <div class="generalDisplay shadow-lg p-3bg-white mt-3 mb-3 rounded usersList">
                    <center>
                        <h1 class="mb-3">Liste des utilisateurs</h1>
                        <table class="hideForModify">
                            <thead>
                                <tr>
                                    <th>Numéro utilisateur</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Date de naissance</th>
                                    <th>Numéro de téléphone</th>
                                    <th>Adresse mail</th>
                                    <th>Nom d'utilisateur</th>
                                    <th>Droits</th>
                                    <th>Modifier données</th>
                                    <th>Supprimer utilisateur</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($listUsers as $user){
                                ?>
                                <tr>
                                    <td><?= $user->id; ?></td>
                                    <td><?= $user->lastname; ?></td>
                                    <td><?= $user->firstname; ?></td>
                                    <td><?= $user->birthdate; ?></td>
                                    <td><?= $user->phone; ?></td>
                                    <td><?= $user->mail; ?></td>
                                    <td><?= $user->username; ?></td>
                                    <td><?= $user->rights; ?></td>
                                    <td><a href="usersManagement.php?modifyId=<?= $user->id; ?>">Modifier</a></td>
                                    <td><a href="usersManagement.php?deleteId=<?= $user->id; ?>">Supprimer</a></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </center>
                </div>
            </div>
        <?php
        }else{
        ?>
            <div class="container generalDisplay shadow-lg p-3bg-white mt-3 mb-3 rounded">
                <center>
                    <form method="post" action="usersManagement.php?modifyId=<?= $_GET['modifyId']; ?>" id="modifyFormAdmin">
                        <h1 class="title">Modification de l'utilisateur <?= $user->username; ?></h1>
                        <div class="row pt-5 modifyDiv">
                            <div class="offset-lg-1 col-lg-4">
                                <label for="lastname">Nom : </label>
                            </div>
                            <div class="offset-lg-1 col-lg-4">
                                <input id="lastname" type="text" name="lastname" value="<?= $user->lastname; ?>" data-toggle="popover" data-trigger="focus" title="Nom" data-content="Doit contenir 2 lettres au minimum." required>
                            </div>
                        </div>
                        <div class="row modifyDiv">
                            <div class="offset-lg-1 col-lg-4">
                                <label for="firstname">Prénom : </label>
                            </div>
                            <div class="offset-lg-1 col-lg-4">
                                <input id="firstname" type="text" name="firstname" value="<?= $user->firstname; ?>" data-toggle="popover" data-trigger="focus" title="Prénom" data-content="Doit contenir 2 lettres au minimum." required>
                            </div>
                        </div>
                        <div class="row modifyDiv">
                            <div class="offset-lg-1 col-lg-4">
                                <label for="birthdate">Date de naissance : </label>
                            </div>
                            <div class="offset-lg-1 col-lg-4">
                                <input id="birthdate" type="date" name="birthdate" value="<?= $user->birthdate; ?>" required>
                            </div>
                        </div>
                        <div class="row modifyDiv">
                            <div class="offset-lg-1 col-lg-4">
                                <label for="phone">Numéro de téléphone : </label>
                            </div>
                            <div class="offset-lg-1 col-lg-4">
                                <input id="phone" type="tel" name="phone" value="<?= $user->phone; ?>" data-toggle="popover" data-trigger="focus" title="Numéro de téléphone" data-content="Doit contenir entre 10 et 15 chiffres." required>
                            </div>
                        </div>
                        <div class="row modifyDiv">
                            <div class="offset-lg-1 col-lg-4">
                                <label for="mail">Adresse mail : </label>
                            </div>
                            <div class="offset-lg-1 col-lg-4">
                                <input id="mail" type="email" name="mail" value="<?= $user->mail; ?>" data-toggle="popover" data-trigger="focus" title="Adresse mail" data-content="Doit correspondre au format d'une adresse mail."required>
                            </div>
                        </div>
                        <div class="row modifyDiv">
                            <div class="offset-lg-1 col-lg-4">
                                <label for="rights">Rôle </label>
                            </div>
                            <div class="offset-lg-1 col-lg-4">
                                <select id="rights" name="rights">
                                    <option value="<?= $infoUser[0]->rights ?>"><?= $infoUser[0]->rights; ?></option>
                                    <option value="<?= ($infoUser[0]->rights == 'user')  ? 'admin' : 'user';?>"><?= ($infoUser[0]->rights == 'user')  ? 'admin' : 'user';?></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="offset-lg-3 col-lg-5">
                                <button type="submit" class="btn btn-primary buttonSubmit3">Modifier</button>
                            </div>
                        </div>
                    </form>
                    <a href="usersManagement.php">Retour</a>
                </center>
                <?php
                if(COUNT($errors) > 0){
                    foreach ($errors as $error){
                        ?>
                        <div class="toast toastModifyAdmin" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
                            <div class="toast-header fail">
                                <img src="../../assets/img/logoJCP.png" class="logoToast rounded mr-2" alt="logo JCP">
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
        <?php
        }
        ?>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <script src="../../assets/js/script.js"></script>
    </body>
</html>