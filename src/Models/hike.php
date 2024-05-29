<?php
declare(strict_types=1);

namespace Models;

use PDO;
use PDOException;

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
    public function addHike($name, $description, $distance, $duration, $elevation_gain, $created_at, $updated_at, $user_id)
    {
        try {
            if (isset($name, $description, $distance, $duration, $elevation_gain, $created_at, $updated_at) &&
                !empty($name) && !empty($description) && !empty($distance) && !empty($duration) && !empty($elevation_gain) && !empty($created_at) && !empty($updated_at)) {

                //SQL part
                $stmt = $this->query(
                    "INSERT INTO hikes(name, description, distance, duration, elevation_gain, created_at, updated_at, user_id) 
                VALUES (:name, :description, :distance, :duration, :elevation_gain, :created_at, :updated_at, :user_id)",
                    [
                        ":name" => $name,
                        ":description" => $description,
                        ":distance" => $distance,
                        ":duration" => $duration,
                        ":elevation_gain" => $elevation_gain,
                        ":created_at" => $created_at,
                        ":updated_at" => $updated_at,
                        ":user_id" => $user_id
                    ]
                );


                // Check if any rows were affected
                if ($stmt->rowCount() > 0) {
                    // retreive the last ID
                    $id = $this->lastInsertId();
                    return $id;
                } else {
                    throw new \Exception("No rows were affected, hike was not added to the database");
                }
            } else {
                throw new \Exception("Form incomplete");
            }
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception("General error: " . $e->getMessage());
        }
    }

    public function deleteHike($id): bool
    {
        try {
            $stmt = $this->query(
                "DELETE FROM hikes WHERE id = ?",
                [$id]
            );

            if ($stmt->rowCount() > 0) {
                error_log("Successfully deleted hike with id: " . $id); // Log successful deletion
                return true;
            } else {
                throw new \Exception("No rows were affected, hike was not deleted from the database");
            }
        } catch (\PDOException $e) {
            error_log("Database error deleting hike: " . $e->getMessage()); // Log any database errors
            throw new \Exception("Database error: " . $e->getMessage());
        } catch (\Exception $e) {
            error_log("General error deleting hike: " . $e->getMessage()); // Log any general errors
            throw new \Exception("General error: " . $e->getMessage());
        }
    }
}