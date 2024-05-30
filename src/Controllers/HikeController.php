<?php
declare(strict_types=1);

namespace Controllers;

use Exception;
use Models\Hike;

class HikeController
{
    protected Hike $hikeModel;
    public function __construct()
    {
        $this->hikeModel = new Hike();
    }
    public function addHike($name, $description, $distance, $duration, $elevation_gain, $created_at, $updated_at, $user_id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $distance = $_POST['distance'];
            $duration = $_POST['duration'];
            $elevation_gain = $_POST['elevation_gain'];
            $created_at = date('Y-m-d H:i:s'); // current date and time
            $updated_at = date('Y-m-d H:i:s'); // current date and time

            try {
                $this->hikeModel->addHike($name, $description, $distance, $duration, $elevation_gain, $created_at, $updated_at, $user_id);

                header('Location: /hikes');

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

    }

    public  function index()
    {
        try {
            $hikes = (new Hike())->findAll(20);

            include __DIR__ . '/../views/includes/header.view.php';
            include __DIR__ . '/../views/index.view.php';
            include __DIR__ . '/../views/includes/footer.view.php';

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function show(string $id)
    {
        try {
            $hike = (new Hike())->find($id);
            $tags = (new Hike())->getTags($id);

            if(empty($hike)){
                throw new Exception('Hike not found');
            }

            include __DIR__ . '/../views/includes/header.view.php';
            include __DIR__ . '/../views/hike.view.php';
            include __DIR__ . '/../views/includes/footer.view.php';

        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function deleteHike($id): void
    {

        try {
            error_log("Attempting to delete hike with id: " . $id); // Log the id of the hike being deleted
            $this->hikeModel->deleteHike($id);
            header('Location: /hikes');
            // Redirect to the list of hikes
            exit();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function edit($id) {
        $hike = $this->hikeModel->find($id);

        require __DIR__ . "/../views/editeHike.view.php";
    }

    public function update($id, $name, $description, $distance, $duration, $elevation_gain, $updated_at): void
    {
        // Update the hike data
        $this->hikeModel->updateHike($id, $name, $description, $distance, $duration, $elevation_gain, $updated_at);

        // Redirect to the hike details page
        header('Location: /hikes/' . $id);
    }

}