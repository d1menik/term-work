<?php
include ("../../config.php");

if (isset($_POST['name']) && isset($_POST['userId']))
{
    $stmt = $conn->prepare("INSERT INTO playlists (name, user_id, dateCreated) VALUES (:name, :user_id, CURRENT_TIMESTAMP)");

    $stmt->bindParam(':user_id', $_POST["userId"]);
    $stmt->bindParam(':name', $_POST["name"]);

    $stmt->execute();

} else {
    echo "Name or username parameters not passed into file.";
}

?>