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

    
    public function getTags(string $hikeId)
    {
        $sql = "SELECT tags.* FROM tags 
                JOIN hike_tag ON tags.id = hike_tag.tags_id 
                WHERE hike_tag.hikes_id = ?";
        $stmt = $this->query($sql, [$hikeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}