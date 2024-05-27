<?php
declare(strict_types=1);

namespace Controllers;

use Exception;
use Models\User;

class AuthController
{

  public function subscribe(string $firstnamePost, string $lastnamePost, string $loginPost, string $emailPost, string $passPost)
  {
      $user = new User();
      $user->addUser($firstnamePost, $lastnamePost, $loginPost, $emailPost, $passPost);

      // redirect to index when done
      header("location: ./");
  }

  public function showSubscriptionForm()
  {
    include __DIR__ . '/../views/includes/header.view.php';
    include __DIR__ . '/../views/register.view.php';
    include __DIR__ . '/../views/includes/footer.view.php';
  }

    public function login($nicknamePost, $passwordPost)
    {
        $user = new User();
        $user->loginUser($nicknamePost, $passwordPost);

        header("location: ./");
    }

  public function showLoginForm()
  {
    include __DIR__ . '/../views/includes/header.view.php';
    include __DIR__ . '/../views/login.view.php';
    include __DIR__ . '/../views/includes/footer.view.php';
  }

  public function logout()
  {
    // delete session variable
    unset($_SESSION['user']);

    header('Location: ./');
  }

}