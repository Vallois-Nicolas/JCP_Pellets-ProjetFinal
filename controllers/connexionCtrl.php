<?php
// J'ai besoin sur ce controller des models impliqués dans la connexion
require '../models/Database.php';
require '../models/Users.php';
// Je crée ensuite un tableau $errors qui me servira par la suite à renvoyer les éventuelles erreurs commises par l'utilisateur lors de sa connexion
$errors = [];

//Si les deux données du formulaire sont renseignées,
if(isset($_POST['username']) && isset($_POST['password'])){
    // j'instancie ma classe Users dans une variable $user, celle-ci devient alors un objet.
    $user = new Users();
    // Je stocke le contenu de l'input servant à récupérer le nom d'utilisateur dans une variable $username tout en protégeant son contenu d'éventuelles injection de script grâce à le méthode php htmlspecialchars
    $username = htmlspecialchars($_POST['username']);
    // J'hydrate l'attribut username de mon objet $user avec le contenu de ma variable $username
    $user->username = $username;
    // Je stocke dans une nouvelle variable $selectByUsername le résultat de l'application de la méthode selectByUsername sur mon objet $user. Cette méthode me permet de filtrer les utilisateurs inscrits par leur username.
    $selectByUsername = $user->selectByUsername();
    // Si $selectByUsername contient des données c'est que l'utilisateur existe bien dans ma base de données,
    if(COUNT($selectByUsername) > 0){
        // je stocke alors le mot de passe renseigné par l'utilisateur dans le formulaire de connexion dans une nouvelle variable $password
        $passwordUser = $_POST['password'];
        // Si le mot de passe renseigné par l'utilisateur diffère de celui hashé renseigné dans la base de données,
        if(!password_verify($passwordUser, $user->password)){
            // Je renvoie un message d'erreur à l'utilisateur en lui indiquant qu'il a saisi un mot de passe incorrect
            $errors[] = 'Vous avez saisi un mot de passe incorrect !';
        }else{
            // Si les 2 mots de passe correspondent, je stocke dans des variables de session les différentes données clés qui me seront utiles par la suite.
            $_SESSION['id'] = $user->id;
            $_SESSION['username'] = $username;
            $_SESSION['rights'] = $selectByUsername[0]->rights;
            // Puis je redirige l'utilisateur alors connecté sur la page index
            header('Location: ../index.php');
        }
    }else{
        // Si $selectByUsername ne contient aucune données, c'est que le nom d'utilisateur renseigné ne correspond à aucune entrée dans la base de données, et donc je renvoie une erreur signalant à l'utilisateur qu'il a saisi un nom inexistant.
        $errors[] = 'Vous avez saisi un nom d\'utilisateur inconnu !';
    }
}
