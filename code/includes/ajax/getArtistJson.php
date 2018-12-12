<?php
include("../../config.php");

if (isset($_POST['artist_id'])) {
    $artist_id = $_POST['artist_id'];

    $stmt = $conn->prepare("SELECT * FROM artists WHERE artist_id=:artist_id");
    $stmt->execute(array(':artist_id' => $artist_id));
    $result = $stmt->fetchAll();

    echo json_encode($result);
}