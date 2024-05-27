<?php

namespace Models;

use PDO;
use Exception;

class User extends Database
{
    public function addUser($loginPost, $emailPost, $passPost)
    {

        if (isset($loginPost, $emailPost, $passPost) &&
            !empty($loginPost) && !empty($emailPost) && !empty($passPost)
        ) {

            // strip_tags for the login
            $login = strip_tags($loginPost);

            // check valid email
            $email = filter_var($emailPost, FILTER_VALIDATE_EMAIL);

            // hash the password
            $pass = password_hash($passPost, PASSWORD_BCRYPT);

            // check if the user already exists
            if ($this->userExists($login, $email)) {
                echo "User or Email already exists";
                echo "<button onclick=\"location.href='/register'\">Go Back</button>";                exit();
            }
            //SQL part
            $q = $this->query(
                "INSERT INTO users(login, email, password) 
                    VALUES (:login, :email, :password)",
                [":login" => $login,
                    ":email" => $email,
                    ":password" => $pass]);

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

            $q = $this->query(
                "SELECT * FROM users WHERE nickname = :nickname",
                [":nickname" => $nickname]
            );

            if (!$q) {
                die("User or Password not valid");
            }

            $user = $q->fetch(PDO::FETCH_ASSOC);

            if ($user && !password_verify($passwordPost, $user['password'])) {
                die("User or Password not valid");
            };

            $_SESSION['user'] = [
                $user['id'],
                $user['nickname'],
                $user['email']
            ];
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

