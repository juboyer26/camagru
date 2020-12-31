<?php
require_once 'config/setup.php';
session_start();

$session = !empty($_SESSION['username']);
$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');
$sql = "SELECT * from users WHERE username=? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute([$session]);
$user = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Home</title>
</head>

<body class="bgImg">
    <div class="container" style="border:white">
        <br>
        <?php if (empty($session)) : ?>
            <div class="" style="margin: 0 auto; width: 50%; background-color: white; padding:5px; text-align: center;">
                <h2>Welcome to Camagru</h2>
                <p>Already a member? <a href="view/signin.php">Sign in</a></p>
                <p>New member? <a href="view/register.php">Sign up</a></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['username'])) : ?>
            <?php if ((!empty($user['verification'])) != 1) : ?>
                <div style="color:black;" class="alert alert-warning alert-dismissible fade show" role="alert">
                    You need to verify your email address!
                    Sign into your email account and click
                    on the verification link we just emailed you
                    at
                    <strong><?php echo $_SESSION['email']; ?></strong>
                </div>
                <p><a style="color: white; font-size: 20px" href="view/signin.php">Sign in</a></p>
            <?php else : ?>

                <div class="" style="margin: 0 auto; width: 50%; background-color: white; padding:5px">
                    <h2>Welcome to Camagru</h2>
                    <p>Already a member? <a href="view/signin.php">Sign in</a></p>
                    <p>New member? <a href="view/register.php">Sign up</a></p>
                </div>


            <?php endif; ?>
        <?php endif; ?>



        <div class="footer">
            <p> juboyer &copy camagru 2019 </p>
        </div>
    </div>
</body>

</html>