<?php
include ("../../config.php");

if (isset($_POST['playlistId'])) {
    $playlistId = $_POST['playlistId'];

    $stmt = $conn->prepare( "DELETE from playlists WHERE playlist_id=:playlistId");
//    $stmt = $conn->prepare( "DELETE from playlistSongs WHERE playlist_id=:playlistId");
    $stmt->bindParam(':playlistId', $_POST["playlistId"]);
    $stmt->execute();
}else {
    echo "PlaylistId was not passed into deletePlaylist.php";
}

?>