<?php

namespace Model;

use \W\Model\Model;
use \W\Security\AuthentificationModel;

class UserModel extends Model
{

  public function inscription()
  {
    $mdp = new AuthentificationModel();

    $userData = array(
      "lastname" => $_POST['lastname'],
      "firstname" => $_POST['firstname'],
      "mail" => $_POST['email'],
      "password" => $mdp->hashPassword($_POST['password']),
      "phone" => $_POST['numTel']
    );
    return $userData;
  }
}
