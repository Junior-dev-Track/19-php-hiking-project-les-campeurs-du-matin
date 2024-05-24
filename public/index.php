<?php
declare(strict_types=1);

ini_set('display_errors', 1);
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use Controllers\AuthController;
use Controllers\HikeController;

Use Models\Database;


session_start();

$router = new AltoRouter();


$router -> map('GET', '/', function() {

    require __DIR__ . "/../src/views/index.view.php";
});
$router -> map('GET', '/home', function() {
    require __DIR__ . "/../src/views/index.view.php";
});

$router -> map('GET', '/hike', function() {
    $hikeController = new HikeController();
    $hikeController->index();
});

$router -> map('GET', '/hike/[i:id]', function($id) {
    $hikeController = new HikeController();
    $hikeController->show($id);
});

$router -> map('GET', '/login', function() {
    $authController = new AuthController();
    $authController->showLoginForm();
});

$router -> map('POST', '/login', function() {
    $authController = new AuthController();
    $authController->login($_POST['login'], $_POST['pass']);
});

$router -> map('GET', '/logout', function() {
    $authController = new AuthController();
    $authController->logout();
});

$router -> map('GET', '/register', function() {
    $authController = new AuthController();
    $authController->showSubscriptionForm();
});

$router -> map('POST', '/register', function() {
    $authController = new AuthController();
    $authController->subscribe($_POST['login'], $_POST['email'], $_POST['pass']);
});

$router -> map('GET', '/404', function() {
    require __DIR__ . "/../src/views/404.view.php";
});

$router -> map('GET', '/500', function() {
    require __DIR__ . "/../src/views/500.view.php";
});




// match current request
$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // no route was matched
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
?>









<!--
try {
    $url_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), "/");
    $method = $_SERVER['REQUEST_METHOD']; // GET -- POST

    $url_base = "Classic_models_part2";

    switch ($url_path) {
      case "/":
      case $url_base:
          $productController = new ProductController();
          $productController->index();
          break;
      case $url_base . "/product":
            $productController = new ProductController();
            $productController->show($_GET['productCode']);
            break;
      case $url_base . "/subscribe":
        //instantiate Auth
        $authController = new AuthController();
        //if GET
        if ($method == "GET") { $authController->showSubscriptionForm(); }
        //if POST
        if($method == "POST"){ $authController->subscribe($_POST["login"], $_POST["email"], $_POST["pass"]); }
        break;
      case $url_base . "/login":
            $authController = new AuthController();
            if ($method === "GET") $authController->showLoginForm();
            if ($method === "POST") $authController->login($_POST['login'], $_POST['pass']);
            break;
        case $url_base . "/logout":
            $authController = new AuthController();
            $authController->logout();
            break;
      default:
        $pageController = new PageController();
        $pageController->page_404();
    }
}
catch (Exception $e) {
    //echo $e->getMessage();
    $pageController = new PageController();
    $pageController->page_500($e->getMessage());
}
-->