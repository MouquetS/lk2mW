<?php
namespace Controller;

use \W\Controller\Controller;
use \W\Security\AuthorizationModel;
use \W\Security\AuthentificationModel;
use \W\Model\UsersModel;
use Model\UserModel;

class UserController extends Controller
{

	public function login()
	{
    $userLog = new AuthentificationModel();

    // si utilisateur connecté, redirige vers la page utilisateur
    if(!is_null($userLog ->getLoggedUser())) { $this->redirectToRoute('user_home'); }
    // Pas de post ou un post mais pas du formulaire "connexion" donc affichage de la page par défaut du login
    else if(!isset($_POST['form_name']) || (isset($_POST['form_name']) && $_POST['form_name'] !== 'connection')) { $this->show("user/SignInView"); }
    // utilisateur non connecté et un post du formulaire de connexion
    else {
        // prépare et envoie les données au modèle pour vérification
        $userData = array(
            "mail" => htmlentities($_POST['e_mail']),
            "password" => htmlentities($_POST['password']),
        );

        $userLog = new UserModel();
        $errors = $userLog -> login($userData);

        // pas d'erreur lors de la connexion donc renvoi vers la page utilisateur
        if(is_null($errors)) { $this->redirectToRoute('user_home'); }
        // retourne les erreurs à la page par défaut de la connexion
        else { $this->show("user/SignInView",['errorLogin'=>$errors]); }
    }
	}

	public function logout()
	{
    $userLog = new AuthentificationModel();

    // l'utilisateur est connecté
    if(!is_null($userLog ->getLoggedUser())) {
        $userLog->logUserOut();
        $this->show("user/SignInView",["deconnection" => true]);
    } else {
        $this->redirectToRoute('user_login');
    }
  }

  public function signIn()
  {
    $userLog = new AuthentificationModel();

    // si utilisateur connecté, redirige vers la page utilisateur
    if(!is_null($userLog ->getLoggedUser())) { $this->redirectToRoute('user_home'); }
    // Pas de post ou un post mais pas du formulaire "inscription" donc affichage de la page par défaut de l'inscription
    else if (!isset($_POST['form_name']) || (isset($_POST['form_name']) && $_POST['form_name'] !== 'signIn')) { $this->show("user/SignInView"); }
    else {
        // prépare et envoie les données au modèle pour vérification
        $userData = array(
            "lastname" => htmlentities($_POST['lastname']),
            "firstname" => htmlentities($_POST['firstname']),
            "mail" => htmlentities($_POST['email']),
            "password" => htmlentities($_POST['password']),
            "phone" => htmlentities($_POST['numTel']),
        );

        $userLog = new UserModel();
        $errors = $userLog -> signIn($userData);
        // pas d'erreur lors de l'inscription donc renvoi vers la view d'inscription avec la donnée de réussite d'inscription
        if(is_null($errors)) { $this->show("user/SignInView",['successSignIn'=>true]); }
        // Erreur lors de l'inscription donc renvoi vers la view d'inscription avec la donnée des erreurs
        else { $this -> show("user/SignInView",['errorSignIn'=>$errors]); }
    }
  }
// EST_CE QU@IL NE FAUT PAS PLUTOT UTILISER REDIRECT ?
// Dans ton cas, la redirection est meilleure :) Pour mon cas de signin, j'affiche le message de confirmation d'inscription donc je sais pas si je peux envoyer le success dans le redirect.
// pour la méthode home, le redirect est bien amusant !!
//GWEN: je me suis posé exactement la meme question pour le modifyCoordinates: je voulais un affichage pour dire "OK, c'est bien modifié"...



  public function home()
  {
    // cette page est accessible si on est membre, admin ou superadmin
    $this-> AllowTo(['1','2','3']);

    $userGrant = new AuthorizationModel();
    if($userGrant->isGranted('1') || $userGrant->isGranted('2')) { // l'utilisateur connecté est un (super-)administrateur donc redirige vers la view admin
       $this->show("user/AdminView",['connectLinkChoice' => true]);
    } else {    // l'utilisateur connecté est un simple membre donc redirige vers la view utilisateur simple
       $this->show("user/UserView",['connectLinkChoice' => true]);
    }
  }

  public function modifyCoordinates()
  {
    $userLog = new AuthentificationModel();

    // si aucun utilisateur est connecté, redirige vers la page de login (bizarre dans ce cas puisque ta route est en POST)
    if(is_null($userLog ->getLoggedUser()))
			{$this->redirectToRoute('user_home');}
    // Pas de post ou un post mais pas du formulaire "modifycoordinates" donc affichage de la page par défaut de l'inscription
    else if (!isset($_POST['form_name']) || (isset($_POST['form_name']) && $_POST['form_name'] !== 'modifyCoordinates'))
			{$this->show("user/SignInView");}

    else {
        // prépare et envoie les données au modèle pour modification
        $userData = array(
            "lastname" => htmlspecialchars($_POST['lastname']),
            "firstname" => htmlspecialchars($_POST['firstname']),
            "mail" => htmlspecialchars($_POST['email']),
            "phone" => htmlspecialchars($_POST['numTel']),
        );

		// récupération de l'ID de l'utilisateur connecté
		$user_id=$_SESSION['user']['id'];

        $userModel = new UserModel();
        $errors = $userModel -> update($userData, $user_id);

		// pas d'erreur lors de l'inscription donc renvoi vers la view de modification avec la donnée de réussite d'inscription
        if($errors != false)
					// {$this->show("user/UserView",['successModifyCoordinates'=>true]);}
					//J'utilise plutot un redirect pour rafraichir les champs du formulaire
					{
                        $userLog->refreshUser(); // rafraichissement de la session
												//Bien joué! Je ne connaissais pas ca: je pensais le faire manuellement et changer directement les valeurs de $_SESSION.
                        $this->redirectToRoute('user_home');
                    }

        // Erreur lors de l'inscription donc renvoi vers la view de modification avec la donnée des erreurs
        else {
					$this -> show("user/UserView",['errorModifyCoordinates'=>$errors]);}
    }
  }
}
