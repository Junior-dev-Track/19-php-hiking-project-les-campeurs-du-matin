<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classic Models</title>
    <link rel="stylesheet" href="<?= CSS_PATH ?>style.css">
</head>
<body>



<header>
    <nav>
        <ul>
            <li class="home"><a href="./">Home</a></li>
            <?php if(!isset($_SESSION["user"])): ?>
            <li><a href="./login">Login</a></li>
            <li><a href="./subscribe">Subscription</a></li>
            <?php else: ?>
            <li><a href="./logout">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<h1>Classic Models</h1>


