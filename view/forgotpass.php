<?php

session_start();

$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');

if (isset($_POST['newpswd-btn'])) {
    echo "heya";
    if (isset($_POST['npassword']) === isset($_POST['npassword1'])) {
        echo "heya";

        $password = password_hash($_POST['npassword'], PASSWORD_DEFAULT);
        $token = $_GET['token'];
        $sql = "UPDATE users set password=? WHERE token=? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$password, $token]);

        if ($stmt->execute([$password, $token])) {
            echo "heya";
            $user = $stmt->fetch();
            $_SESSION['message'] = "Your password has been successfully changed";
            header('location: signin.php');
        }
    } else {
        echo "passwords dont match!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Reset Password</title>
</head>

<body class="bgImg">
    <div class=" header" style="background-color: transparent; color:white">
        <h1>Password Reset</h1>
        <p>Please fill in this form to reset password.</p>
    </div>
    <form method="post" style="    margin-top: -30px;">
        <div class="input-group">
            <label for="password" style="color: white;"><b>New Password</b></label>
            <input type="password" placeholder="Enter Password" name="npassword" style="margin-top: 5px;" required><br><br>

            <label for="psw-repeat" style="color: white;"><b>Confirm Password</b></label>
            <input type="password" placeholder="Repeat Password" style="margin-top: 5px;" name="npassword1" required>
            <br><br>
            <div class="clearfix">
                <button type="submit" class="btn" name="newpswd-btn">Submit</button>
            </div>
            <br>
            <a href="signin.php">Login?</a>
        </div>
    </form>

</body>

</html>