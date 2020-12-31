<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../view/signin.php');
}

$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');

if (isset($_POST['editbtn'])) {
    if (empty($_POST['oldpassword']) && $_POST['newpassword'] !== $_POST['psw-repeat']) {
        $error = 'Password required';
        echo '<script>alert("password should not be empty")</script>';
    }
    $newpassword = $_POST['newpassword'];
    $uppercase = preg_match('@[A-Z]@', $newpassword);
    $lowercase = preg_match('@[a-z]@', $newpassword);
    $number    = preg_match('@[0-9]@', $newpassword);
    if (!$uppercase || !$lowercase || !$number || strlen($newpassword) < 8) {
        $error = 'password should be 8 characters long, a number, lower and uppercase characters';
        echo '<script>alert("password should be 8 characters long, a number, lower and uppercase characters")</script>';
    } else {
        $username = $_SESSION['username'];
        $oldpassword = $_POST['oldpassword'];
        $newpassword = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
        if (empty($error)) {

            $sql = "SELECT * FROM users WHERE username=? LIMIT 1";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute([$username])) {

                $user = $stmt->fetch();
                if (password_verify($oldpassword, $user['password'])) {

                    $sql = "UPDATE users SET password=? WHERE username=? LIMIT 1";
                    $stmt = $conn->prepare($sql);
                    if ($stmt->execute([$newpassword, $username])) {
                        unset($_SESSION['username']);
                        session_destroy();
                        header("location: signin.php");
                    }
                } else {
                    echo '<script>alert("old password is incorrect")</script>';
                }
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile Update</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="bgImg">
    <div class="topnavi" id="">
        <a href="gallery.php">
            <h3 style="margin:0; color:white">Camagru</h3>
        </a>
        <div style="float:right">
            <a href="gallery.php">Gallery</a>
        <a href="profile.php" class="active">Profile</a>
        <a href="camera.php">Camera</a>
        <a class="nav-link" href="../controller/logout.php">
            Logout
        </a>
        </div>
    </div>

    </div>
    
    
    <form method="post">
        <h2 style="color:white">Edit Password</h2>
        <div class="input-group">
            <input type="password" placeholder="Old Password" name="oldpassword" required>
        </div>
        <div class="input-group">
            <input type="password" placeholder="New Password" name="newpassword" required>
        </div>
         <div class="input-group">
            <input type="password" placeholder="Re-Enter Password" name="psw-repeat" required>
        </div>
         <div class="input-group">
           <button type="submit" class="btn" name="editbtn">Submit</button>
        </div>

    </form>
    <div class="footer">
        <p>juboyer &copy camagru 2019 </p>
    </div>
</body>

</html>