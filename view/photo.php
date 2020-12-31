<?php
session_start();
// $username = $_SESSION['username'];
$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');

if (isset($_GET['imageid'])) {
    $imageid = $_GET['imageid'];
    $sql = "SELECT imageName FROM images WHERE id=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$imageid]);
    $user = $stmt->fetch();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Comments</title>
</head>

<body class="bgImg">
    <div class="topnavi">
        <a href="gallery.php">
            <h3 style="margin:0; color:white">Camagru</h3>
        </a>
        <div style="float:right; padding: 5px">
            <a href="gallery.php" class="active">Gallery</a>
            <a href="profile.php">Profile</a>
            <a href="camera.php">Camera</a>
            <?php if (isset($_SESSION['username'])) { ?>
                <a href="../controller/logout.php">
                    Logout
                </a>
            <?php } else { ?>
                <a href="signin.php">
                    login
                </a>
            <?php } ?>
        </div>
    </div>


    <div class="container">
        <div style="display: flex;">
            <div style="flex: 48.33%;padding: 5px; margin-top:10%">
                <img src="../images/<?php echo $user['imageName'] ?>" width="400" height="300">
                <?php if (!empty($_SESSION['username'])) { ?>
                    <form method="POST" id="comment_form" style="padding: 0;margin: 0;margin-top: 10px">
                        <input type="hidden" name="comment_name" id="comment_name" value="<?php echo $_SESSION['username'] ?>" />
                        <div class="form-group">
                            <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5" style="height:29px; width :399px;"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="comment_id" id="comment_id" value="0" />
                            <input type="hidden" name="image_id" id="image_id" value="<?php echo $imageid ?>" />
                            <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
                        </div>
                    </form>
                <?php } ?>
            </div>
            <div style="flex: 33.33%;padding: 5px;margin-top:10%">
                <span id="comment_message"></span>
                <br />
                <div id="display_comment"></div>
            </div>
        </div>

    </div>

</body>


<script>
    $(document).ready(function() {

        $('#comment_form').on('submit', function(event) {
            event.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url: "addComment.php?imageid=<?php echo $imageid ?>&notif=1",
                method: "POST",
                data: form_data,
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        load_comment();
                    }
                }
            })
        });
        load_comment();

        function load_comment() {
            $.ajax({
                url: "fetchComment.php?imageid=<?php echo $imageid ?>",
                method: "POST",
                success: function(data) {
                    $('#display_comment').html(data);
                }
            })
        }
        $(document).on('click', '.reply', function() {
            var comment_id = $(this).attr("id");
            $('#comment_id').val(comment_id);
            $('#comment_name').focus();
        });

    });
</script>

</html>