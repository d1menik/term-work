<?php
include("../../config.php");

if (isset($_POST['playlistId']) && isset($_POST['songId'])) {
    $playlist_id = $_POST['playlistId'];
    $song_id = $_POST['songId'];


    $stmt = $conn->prepare("DELETE from listSongs WHERE song_id=:song_id AND playlist_id=:playlist_id");
    $stmt->bindParam(':song_id', $song_id, PDO::PARAM_STR);
    $stmt->bindParam(':playlist_id', $playlist_id, PDO::PARAM_STR);

    $stmt->execute();
    $count = $stmt->rowCount();

    if ($count !== 0) {
        echo "Song was successfully deleted from the playlist.";
        exit();
    }
}