<?php

namespace Models;

use PDO;
use Exception;

class User extends Database
{
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


  public function loginUser($loginPost, $passPost)
  {
      if (isset($loginPost, $passPost) && !empty($loginPost) && !empty($passPost)) {

        $login = strip_tags($loginPost);

        $q = $this->query(
          "SELECT * FROM users WHERE login = :login",
          [":login" => $login]
        );

        // execute return a boolean
        if(!$q) {
          die("User or Password not valid");
        }

        $user = $q->fetch(PDO::FETCH_ASSOC);

        // check the password input with the password in db
        if($user && !password_verify($passPost, $user['password'])) {
            die("User or Password not valid");
        };

        // store data of user in $_SESSION
        $_SESSION['user'] = [
         $user['id'],
         $user['login'],
         $user['email']
        ];

      }
  }

}