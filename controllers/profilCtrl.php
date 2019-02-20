<?php
// J'ai besoin sur ce controller des models permettant l'affichage et la modification des données d'un utilisateur.
require '../models/Database.php';
require '../models/Users.php';

// J'instancie ma classe Users dans une variable $user, celle-ci devient donc un objet
$user = new Users();
// J'hydrate l'attribut id de mon objet $user avec le contenu de la variable de session id alors présente
$user->id = $_SESSION['id'];
// J'applique la méthode infoUser qui me permet de récupérer toutes les informations d'un utilisateur à mon objet $user, je n'ai pas besoin de stocker les résultats de cette méthode car les résultats sont déjà hydratés dans le model.
$user->infoUser();
// Je crée un tableau $errors qui me permettra de renvoyer les éventuelles erreurs commises par l'utilisateur lors de la modification de ses données.
$errors = [];

// Si des données sont présentes dans le tableau superglobal POST, c'est que l'utilisateur veut modifier son profil, donc :
if(COUNT($_POST) > 0){
    // Je récupère toutes les données du formulaire de modification tout en les protégeant des injections de script grâce à la méthode php htmlspecialchars
    $lastname = htmlspecialchars($_POST['changeLastname']);
    $firstname = htmlspecialchars($_POST['changeFirstname']);
    $birthdate = htmlspecialchars($_POST['changeBirthdate']);
    $phone = htmlspecialchars($_POST['changePhone']);
    $mail = htmlspecialchars($_POST['changeMail']);
    $username = htmlspecialchars($_POST['changeUsername']);
    
    //Dans toutes les conditions suivantes, je teste les valeurs récupérées avec mes regex, si la regex n'est pas validée, un message d'erreur est envoyé dans le tableau $errors
    if(!preg_match('#^[a-zéèàëäâê._\- ]{2,}$#i', $lastname)){
            $errors[] = 'Veuillez renseigner correctement votre nom';
        }else if(!preg_match('#^[a-zéèàëäâê._\- ]{2,}$#i', $firstname)){
            $errors[] = 'Veuillez renseigner correctement votre prénom';
        }else if(!preg_match_all('#^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$#', $birthdate)){
            $errors[] = 'Veuillez renseigner correctement votre date de naissance';
        }else if(!preg_match('#^[0-9]{10,15}$#', $phone)){
            $errors[] = 'Veuillez renseigner correctement votre numéro de téléphone';
        }else if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
            $errors[] = 'Veuillez renseigner correctement votre adresse mail';
        }else if(!preg_match('#^.{2,10}$#i', $username)){
            $errors[] = 'Veuillez renseigner correctement votre nom d\'utilisateur';
        }else{
            
            // Si tous les tests sont passés et validés, j'hydrate les attributs username et mail de mon objet $user avec les valeurs renseignées par l'utilisateur
            $user->username = $username;
            $user->mail = $mail;
            // Je peux ensuite appliquer mes méthodes de filtrage à mon objet $user afin de savoir si les informations username et mail envoyées par l'utilisateur sont déjà renseignées dans la base de données et si oui par quel utilisateur elles sont utilisées
            $userUsernameFilter = $user->filterByUsername();
            $userMailFilter = $user->filterByMail();
            
            // Si le nombre de résultats de mon premier filtrage est supérieur à 0 et si l'id associé à ce résultat est différent de l'id de session de l'utilisateur, c'est que le nouveau nom d'utilisateur est déjà utilisé par quelqu'un d'autre, donc :
            if(COUNT($userUsernameFilter) > 0 && $userUsernameFilter[0]->id != $_SESSION['id']){
                // je renvoie une erreur dans mon tableau $errors pour signaler que le nouveau username que l'utilisateur a choisi est déjà utilisé par une autre personne
                $errors[] = 'Ce nom d\'utilisateur est déjà pris !';
            // Si le nombre de résultats de mon second filtrage est supérieur à 0 et si l'id associé à ce résultat est différent de l'id de session del'utilisateur, c'est que la nouvelle adresse mail est déjà utilisée par quelqu'un d'autre, donc :
            }else if(COUNT($userMailFilter) > 0 && $userMailFilter[0]->id != $_SESSION['id']){
                // je renvoie une erreur dans mon tableau $errors pour signaler que la nouvelle adresse mail que l'utilisateur a choisi est déjà utilisée par une autre personne
                $errors[] = 'Cette adresse mail semble être déjà utilisée !';
            }else{
                
                // Si mes deux filtrages sont passés sans problème, j'hydrate la majorité des attributs de mon objet $user avec les valeurs renseignées par l'utilisateur
                $user->lastname = $lastname;
                $user->firstname = $firstname;
                $user->birthdate = $birthdate;
                $user->phone = $phone;
                $user->mail = $mail;
                $user->username = $username;
                
                // Comme j'ai hydraté les éléments nécessaire à la modification
                $user->updateProfile();
                
                // Puis je crée un tableau $success qui va me permettre d'afficher un message de réussite 
                $success = [];
                $success[] = 'Vos modifications ont bien été enregistrées !';
            }
        }
}