<?php
include ("../../config.php");

if (isset($_POST['playlistId']) && isset($_POST['songId'])) {
    $playlist_id = $_POST['playlistId'];
    $song_id = $_POST['songId'];

    $stmt = $conn->prepare("SELECT MAX(playlistOrder) as playlistOrder FROM listSong WHERE playlist_id=:playlist_id");
    $stmt->execute(array(':playlist_id' => $playlist_id));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $order = $result['playlistOrder']  + 1;

    $stmt1 = $conn->prepare("INSERT INTO listSong (song_id, playlist_id, playlistOrder) VALUES (:song_id, :playlist_id, :playlistOrder)");
    $stmt1->bindParam(':song_id', $song_id, PDO::PARAM_STR);
    $stmt1->bindParam(':playlist_id', $playlist_id, PDO::PARAM_STR);
    $stmt1->bindParam(':playlistOrder', $order, PDO::PARAM_STR);
    $stmt1->execute();

    $count = $stmt1->rowCount();

    if ($count !== 0) {
        echo "Song was successfully added to the playlist.";
        exit();
    }
}