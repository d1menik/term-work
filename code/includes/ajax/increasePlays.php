<?php
include ("../../config.php");

if (isset($_POST['song_id'])) {
    $song_id = $_POST['song_id'];

    $stmt = $conn->prepare("UPDATE songs SET plays = plays + 1 WHERE song_id=:song_id");
    $stmt->execute(array(':song_id' => $song_id));
}