<?php
//add_comment.php
$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', '');
$error = '';
$comment_name = '';
$comment_content = '';

if (isset($_GET['imageid']) && $_GET['imageid'] !== '') {
    $imageid = $_GET['imageid'];
    if (empty($_POST["comment_name"])) {
        $error .= '<p class="text-danger">Name is required</p>';
    } else {
        $comment_name = $_POST["comment_name"];
    }
    if (empty($_POST["comment_content"])) {
        $error .= '<p class="text-danger">Comment is required</p>';
    } else {
        $comment_content = strip_tags($_POST["comment_content"]);
    }
    $commentl = strlen($comment_content);
    if ($commentl > 100) {
        $error .= '<p class="text-danger">Comment is too long</p>';
    }
    $comment_id = $_POST["comment_id"];
    if ($error == '') {
        $sql = "INSERT INTO comment (parent_comment_id, comment, comment_sender_name, imageid) 
                VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$comment_id, $comment_content, $comment_name, $imageid])) {
            $error = '<label class="text-success">Comment Added</label>';
        }
    }
    $data = array(
        'error'  => $error
    );
    echo json_encode($data);
    //sendNotification($imageid);
}
