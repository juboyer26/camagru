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
    <title>Registration</title>
</head>

<body class="bgImg">
    <form method="post" action=>
        <h2 style="color:white">Register</h2><br>
        <p style="color:white">Please fill in this form to create an account.</p>
        <div class="input-group">
            <input type="text" placeholder="Username" name="username" required>
        </div>
        <div class="input-group">
            <input type="email" placeholder="Email" name="email" required>
        </div>
        <div class="input-group">
            <input type="password" placeholder="Password" name="password" required>
        </div>
        <div class="input-group">
            <input type="password" placeholder="Confirm Password" name="psw-repeat" required>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="signupbtn">Sign Up</button>
        </div>
        <p style=" color:white">
            Already a member? <a href="signin.php" style=";color:white">Sign in</a>
        </p>
    </form>
</body>

</html>