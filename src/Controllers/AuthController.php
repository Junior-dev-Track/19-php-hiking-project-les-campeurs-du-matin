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
        $userId = $user->loginUser($nicknamePost, $passwordPost);

        if ($userId  === false) {
            // Handle error
            $_SESSION['error'] = 'Login failed. Please check your nickname and password.';
        } else {
            // Store user ID in session
            $_SESSION['user']['sess_id'] = $userId;
        }
        // Start session and check user_id after login process
        $user_id = isset($_SESSION['user']['sess_id']) ? $_SESSION['user']['sess_id'] : null;
        // redirect to index when done
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