<?php

namespace Models;

use PDO;
use Exception;

class User extends Database
{
    private $database;

    public function __construct()
    {
        parent::__construct();
        $this->database = $this->pdo;
    }
    public function addUser($firstnamePost, $lastnamePost, $loginPost, $emailPost, $passPost)
    {

        if(isset($firstnamePost, $lastnamePost, $loginPost, $emailPost, $passPost) &&
            !empty($firstnamePost) && !empty($lastnamePost) && !empty($loginPost) && !empty($emailPost) && !empty($passPost)
        ) {

            // strip_tags for the login
            $firstname = strip_tags($firstnamePost);
            $lastname = strip_tags($lastnamePost);
            $login = strip_tags($loginPost);

            // check valid email
            $email = filter_var($emailPost, FILTER_VALIDATE_EMAIL);

            // hash the password
            $password = password_hash($passPost, PASSWORD_BCRYPT);

            // check if the user already exists
            if ($this->userExists($login, $email)) {
                echo "User or Email already exists";
                echo "<button onclick=\"location.href='/register'\">Go Back</button>";                exit();
            }

            //SQL part
            $q = $this->query(
                "INSERT INTO users(firstname, lastname, nickname, email, password, admin) 
              VALUES (:firstname, :lastname, :nickname, :email, :password, :admin)",
                [":firstname" => $firstname,
                    ":lastname" => $lastname,
                    ":nickname" => $login,
                    ":email" => $email,
                    ":password" => $password,
                    ":admin" => 0]);

            if (!$q) {
                die("form not sent to the db");
            }

            // retreive the last ID
            $id = $this->lastInsertId();

            // store data of user in $_SESSION
            $_SESSION["user"] = [
                "id" => $id,
                "login" => $login,
                "email" => $email
            ];

        } else {
            throw new Exception("form incomplete");
        }
    }

    public function loginUser($nicknamePost, $passwordPost)
    {
        if (isset($nicknamePost, $passwordPost) && !empty($nicknamePost) && !empty($passwordPost)) {
            $nickname = strip_tags($nicknamePost);

            // Query the database for the user with the provided nickname
            $stmt = $this->database->prepare("SELECT * FROM users WHERE nickname = ?");
            $stmt->execute([$nickname]);
            $user = $stmt->fetch();

            // Check if a user was found and the provided password is correct
            if ($user && password_verify($passwordPost, $user['password'])) {
                // Store user data in session
                $_SESSION['user'] = [
                    'sess_id' => $user['id'],
                    'nickname' => $user['nickname'],
                    'email' => $user['email']
                ];
                return $user['id'];
            } else {
                // If the user was not found or the password is incorrect, return false
                return false;
            }
        } else {
            throw new Exception("Nickname and password must be provided");
        }
    }
    public function getAllUsers()
    {
        $q = $this->query("SELECT * FROM users");

        if (!$q) {
            die("Failed to retrieve users");
        }

        $users = $q->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }

    public function userExists($nickname, $email)
    {
        $q = $this->query(
            "SELECT * FROM users WHERE nickname = :nickname OR email = :email",
            [":nickname" => $nickname, ":email" => $email]
        );

        $user = $q->fetch(PDO::FETCH_ASSOC);

        return $user ? true : false;
    }
}

