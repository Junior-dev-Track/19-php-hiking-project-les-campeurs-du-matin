<?php
declare(strict_types=1);

namespace Controllers;

use Exception;
use Models\Hike;

class HikeController
{
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


}