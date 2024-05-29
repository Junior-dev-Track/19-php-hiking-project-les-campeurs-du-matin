<?php

namespace Models;

require_once "config.php";

use PDO;
use PDOStatement;
use Exception;

class Database
{

  protected PDO $pdo;

  public function __construct()
  {
    try {
      // We create a new instance of the class PDO
      $this->pdo = new PDO("mysql:host=" . HOST . ";dbname=" . DB . ";port=" . PORT, LOGIN, PASSWORD);

      $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

      //We want any issues to throw an exception with details, instead of a silence or a simple warning
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }

  public function query(string $query, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return $stmt;
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}



