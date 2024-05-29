<?php
declare(strict_types=1);

ini_set('display_errors', 1);
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use Controllers\AuthController;
use Controllers\HikeController;

use Models\Database;


session_start();

$router = new AltoRouter();




try {
    $database = new Database();
    $stmt = $database->query("SELECT * FROM hikes");
    $hikes = $stmt->fetchAll();
} catch (Exception $e) {
    echo "Error executing query: " . $e->getMessage();
}
try {
    $database = new Database();
    $stmt = $database->query("SELECT * FROM users");
    $users = $stmt->fetchAll();

} catch (Exception $e) {
    echo "Error executing query: " . $e->getMessage();
}

$router -> map('GET', '/', function() use ($hikes) {
    require __DIR__ . "/../src/views/includes/header.view.php";
    require __DIR__ . "/../src/views/index.view.php";
});

$router -> map('GET', '/home', function() use ($hikes) {
    require __DIR__ . "/../src/views/includes/header.view.php";
    require __DIR__ . "/../src/views/index.view.php";
});

$router -> map('GET', '/hikes', function() {
    $hikeController = new HikeController();
    $hikeController->index();
});

$router -> map('GET', '/hikes/[i:id]', function($id) {
    $hikeController = new HikeController();
    $hikeController->show($id);
});

$router -> map('GET', '/login', function() {
    $authController = new AuthController();
    $authController->showLoginForm();
});
/* ancient login a garder juste si je merde
$router -> map('POST', '/login', function() {
    $authController = new AuthController();
    $authController->login($_POST['nickname'], $_POST['password']);

});
*/

$router -> map('POST', '/login', function() {
    $authController = new AuthController();
    $loginSuccessful = $authController->login($_POST['nickname'], $_POST['password']);

    var_dump($loginSuccessful);

    if ($loginSuccessful !== false){
        // Assuming the login method returns the user's ID on successful login
        $_SESSION['user_id'] = $loginSuccessful;

    } else {
        // Handle error
        $_SESSION['error'] = 'Login failed. Please check your nickname and password.';
    }

    // header("location: ./");
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
    $authController->subscribe($_POST['firstname'], $_POST['lastname'], $_POST['login'], $_POST['email'], $_POST['password']);
});

$router -> map('GET', '/404', function() {
    require __DIR__ . "/../src/views/404.view.php";
});

$router -> map('GET', '/500', function() {
    require __DIR__ . "/../src/views/500.view.php";
});

$router -> map('GET', '/hike/newHike', function() {
    require __DIR__ . "/../src/views/newHike.view.php";
});
$router -> map('POST', '/hike/addHike/[i:id]', function($id) {

    $hikeController = new HikeController();
    $created_at = isset($_POST['created_at']) ? $_POST['created_at'] : date('Y-m-d H:i:s');
    $updated_at = isset($_POST['updated_at']) ? $_POST['updated_at'] : date('Y-m-d H:i:s');

    $hikeController->addHike($_POST['name'], $_POST['description'], $_POST['distance'], $_POST['duration'], $_POST['elevation_gain'], $created_at, $updated_at, $id);
});

$router -> map('POST', '/hike/deleteHike/[i:id]', function($id) {
    $hikeController = new HikeController();
    $hikeController->deleteHike($id);
    header('Location: /hikes');
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

