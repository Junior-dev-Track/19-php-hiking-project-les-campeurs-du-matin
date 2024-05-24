<?php
declare(strict_types=1);

namespace Controllers;

use Exception;
use Models\Product;

class ProductController
{
    public  function index()
    {
      try {
        $products = (new Product())->findAll(20);

        include __DIR__ . '/../views/includes/header.view.php';
        include __DIR__ . '/../views/index.view.php';
        include __DIR__ . '/../views/includes/footer.view.php';

      } catch (Exception $e) {
        echo $e->getMessage();
      }
    }

    public function show(string $productCode)
    {
      try {
        $product = (new Product())->find($productCode);

        if(empty($product)){
          throw new Exception('Product not found');
        }

        include __DIR__ . '/../views/includes/header.view.php';
        include __DIR__ . '/../views/product.view.php';
        include __DIR__ . '/../views/includes/footer.view.php';

      } catch(Exception $e) {
        echo $e->getMessage();
      }
    }


}