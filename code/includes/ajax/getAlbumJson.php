<?php
include ("../../config.php");

if (isset($_POST['album_id'])) {
    $album_id = $_POST['album_id'];

    $stmt = $conn->prepare("SELECT * FROM albums WHERE album_id=:album_id");
    $stmt->execute(array(':album_id' => $album_id));
    $result = $stmt->fetchAll();

    echo json_encode($result);
}