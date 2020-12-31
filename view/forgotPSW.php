<?php
include  '../controller/connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Password reset</title>
</head>

<body class="bgImg">
    <form action="" style="color:white" method="post">
        <h1>Reset Password</h1>
        <h5>An email will be sent to you with instructions on how to reset your password.</h5>
        <div class="input-group">
            <!-- <label for="email"><b>Email </b></label> -->
            <input type="text" placeholder="Email" name="username" required><br><br>
            <div class="clearfix">
                <button type="submit" class="btn" name="resetpswd">Submit</button>
            </div>
        </div>
    </form>
</body>

</html>