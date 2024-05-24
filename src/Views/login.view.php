
    <h2>User Login</h2>

    <form method="post" action="">
        <?php if(isset($_POST["login"]) && !$user) {
            echo "<p>User or Password not valid</p>";
        } ?>
        <div>
            <label for="login">Login :</label>
            <input type="text" name="login">
        </div>
        <div>
            <label for="pass">Password</label>
            <input type="text" name="pass">
        </div>
        <button type="submit">Login</button>
    </form>

