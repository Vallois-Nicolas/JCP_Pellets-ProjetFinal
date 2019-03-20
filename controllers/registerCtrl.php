<?php
// J'ai besoin dans ce controller des models me permettant l'ajout d'utilisateurs et leur inscription dans la table des droits, leur donnant accès au contenu approprié selon leur rôle
require '../models/Database.php';
require '../models/Users.php';
require '../models/Rights.php';
// J'instancie ma classe Users dans une variable $user, celle-ci devient alors un objet
$user = new Users();
// J'instancie ma classe Rights dans une variable $rights, celle-ci devient alors un objet
$rights = new Rights();
// Je crée un tableau $errors qui me servira à renvoyer les éventuelles erreurs commises par l'utilisateur lors de son inscription
$errors = [];

// Si le tableau des POST contient des données,
if(COUNT($_POST) > 0){
    
    // je stocke dans des variables les données envoyées par l'utilisateur, tout en les protégeant des injections de script grâce à la méthode php htmlspecialchars
    $lastname = htmlspecialchars($_POST['lastname']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $birthdate = htmlspecialchars($_POST['birthdate']);
    $phone = htmlspecialchars($_POST['phone']);
    $mail = htmlspecialchars($_POST['mail']);
    $username = htmlspecialchars($_POST['username']);
    
    // Pour le captcha
    // La clé privée
    $secret = "";
    // La réponse de google 
    $response = $_POST['g-recaptcha-response'];
    // On récupère l'IP de l'utilisateur
    $remoteip = $_SERVER['REMOTE_ADDR'];
    $api_url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $response . "&remoteip=" . $remoteip ;
    $decode = json_decode(file_get_contents($api_url), true);
    // Si le mot de passe renseigné ne correspond pas à la forme attendue,
    if(!preg_match_all('#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$#', $_POST['password'])){
        // je renvoie une erreur dans mon tableau $errors signalant à l'utilisateur que son mot de passe ne correspond pas au format
        $errors[] = 'Veuillez utiliser un mot de passe conforme aux instructions.';
    
    }else{
        // Sinon, si le format du mot de passer correspond je hash le password renseigné par l'utilisateur et je stocke le mot de passe de vérification dans une variable $verifyPassword
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $passwordVerify = $_POST['verifyPassword'];
        
        // Je crée les regex qui me serviront pour les tests
        $regexText = '#^[a-zéèàëäâê._\- ]{2,}$#i';
        $regexDate = '#^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$#';
        $regexPhone = '#^[0-9]{10,15}$#';
        $regexUsername = '#^.{2,10}$#i';
        
        // Si les données envoyées par l'utilisateur ne correspondent pas aux regex voulues, je renvoie dans chaque cas une erreur dans mon tableau $errors correspondant à l'erreur
        if(!preg_match($regexText, $lastname)){
            $errors[] = 'Veuillez renseigner correctement votre nom';
        }else if(!preg_match($regexText, $firstname)){
            $errors[] = 'Veuillez renseigner correctement votre prénom';
        }else if(!preg_match_all($regexDate, $birthdate)){
            $errors[] = 'Veuillez renseigner correctement votre date de naissance';
        }else if(!preg_match($regexPhone, $phone)){
            $errors[] = 'Veuillez renseigner correctement votre numéro de téléphone';
        }else if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
            $errors[] = 'Veuillez renseigner correctement votre adresse mail';
        }else if(!preg_match($regexUsername, $username)){
            $errors[] = 'Veuillez renseigner correctement votre nom d\'utilisateur';
        // Si les 2 password ne correspondent pas,
        }else if(!password_verify($passwordVerify, $password)){
            // je renvoie une erreur à l'utilisateur lui signalant que les 2 mots de passe qu'il a renseigné doivent être identiques
            $errors[] = 'Veuillez renseigner les deux champs mot de passe à l\'identique';
        }else if($decode['success'] == false){
            $errors[] = 'Soit vous n\'avez pas renseigné le captcha soit vous êtes un robot,or j\'ai confiance en vous !';
        }else{
             // Si le processus de vérification a validé tous les tests, j'hydrate la majorité des attributs de mon objet $user afin d'inscrire l'utilsateur par la suite
            $user->lastname = $lastname;
            $user->firstname = $firstname;
            $user->birthdate = $birthdate;
            $user->phone = $phone;
            $user->mail = $mail;
            $user->username = $username;
            $user->password = $password;
            
            // Mais avant de pouvoir finaliser l'inscription, je vérifie si les données critiques comme le mail ou le nom d'utilisateur ne sont pas déjà utilisées par un autre utilisateur
            $filterMail = $user->filterByMail();
            $filterUsername = $user->filterByUsername();
            
            // Si un résultat sort de ma base de données pour le filtrage par mail,
            if(COUNT($filterMail) > 0){
                // je renvoie une erreur au futur utilisateur lui indiquant que l'adresse mail est déjà utilisée par une autre personne
                $errors[] = 'Cette adresse mail semble être déjà utilisée !';
            // Sinon si un résultat sort de ma base de données pour le filtrage par username,
            }else if(COUNT($filterUsername) > 0){
                // je renvoie une erreur au futur utilisateur lui indiquant que le nom d'utilisateur est déjà utilisé par une autre personne
                $errors[] = 'Ce nom d\'utilisateur est déjà pris !';
            // Si mes 2 filtrages sont passées sans problème et ont été validé
            }else{
                // Si l'exécution de mon insertion renvoie true,
                if($user->addUser()){
                    // Je vais chercher le username de la personne qui vient de s'inscrire grâce à mon filtre et je stocke le résultat dans une variable $username,
                    $username = $user->filterByUsername();
                    // Pour chaque résultat $username en tant que $userId
                    foreach ($username as $userId){
                        // J'hydrate l'attribut id_jcp_users de mon objet $rights avec la valeur de l'id de ma table users correspondant au username renvoyé par mon filtrage 
                        $rights->id_jcp_users = $userId->id;
                        // Si ma méthode d'insertion des droits appliquée à mon objet $rights renvoie true
                        if($rights->addRights()){
                            // Je crée un tableau $success me permettant de renvoyer un message de réussite de processus
                            $success = [];
                            $success[] = 'Vous êtes bien inscrit ! Merci de votre confiance !';
                        }
                    }
                }
            }
        }
    }
}