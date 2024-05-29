
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les campeurs du matin</title>
    <!--<link rel="stylesheet" href="./assets/style.css">-->
</head>
<?php

$user_id = isset($_SESSION['user']['sess_id']) ? $_SESSION['user']['sess_id'] : null;
var_dump($user_id);

?>
<body>



<header>
    <nav>
        <ul>
            <li class="home"><a href="/">Home</a></li>
            <?php if(!isset($_SESSION["user"])): ?>
                <li><a href="/login">Login</a></li>
                <li><a href="/register">Register</a></li>
            <?php else: ?>
                <li><a href="/logout">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<!--<h1>Classic Models</h1>-->


