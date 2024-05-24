<?php
declare(strict_types=1);

namespace Models;

use PDO;

class Hike extends Database
{
  public function findAll(int $limit = 0): array
  {
    if($limit == 0) {
      $sql = "SELECT * FROM hikes";
    } else {
      $sql = "SELECT * FROM hikes LIMIT " . $limit;
    }

    $stmt = $this->query($sql);

    $hikes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $hikes;
  }

  public function find(string $id): array|false
    {
        $stmt = $this->query(
            "SELECT * FROM hikes WHERE id = ?",
            [$id]
        );
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}