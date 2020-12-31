<?php
include '../controller/connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <title>Signup</title>
</head>

<body class="bgImg">
    <div class="topnavi" id="">
        <a href="gallery.php">Visit the gallery</a>

    </div>
    <?php if (!empty($_SESSION['message'])) : ?>
        <div style="color:black; background-color:white; text-align: center">
            <?php
            echo $_SESSION['message'];
            ?>
        </div>
    <?php endif ?>
    <form method="post" action="signin.php">
        <h2 style="color:white">Sign In</h2>
        <div class="input-group">
            <input type="text" placeholder="Username" name="username" required>
        </div>
        <div class="input-group">
            <input type="password" placeholder="Password" name="password" required>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="login-btn">login</button>
        </div>

        <p><a href="forgotPSW.php" style="color:white"><small>Forgot password?</small></a></p>
        <a href="register.php" style="color:white"><small>Sign up</small></a>
    </form>
</body>

</html>