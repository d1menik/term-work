<?php
include ("../../config.php");

if (isset($_POST['song_id'])) {
    $song_id = $_POST['song_id'];

    $stmt = $conn->prepare("SELECT * FROM songs WHERE song_id=:song_id");
    $stmt->execute(array(':song_id' => $song_id));
    $result = $stmt->fetchAll();

    echo json_encode($result);
}