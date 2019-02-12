<?php
session_start();
require '../../controllers/admin_side/usersManagementCtrl.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>Produits - JCP Pellets</title>
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
                        <a class="nav-link" href="../profil.php">Votre profil</a>
                    </li>
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
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <script src="../../assets/js/script.js"></script>
    </body>
</html>