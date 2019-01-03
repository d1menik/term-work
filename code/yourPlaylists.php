<?php
include("header.php");

?>

    <div class="playlistContainer">
        <div class="gridViewContainer">
            <h2>Playlist</h2>

            <div class="buttonItems">
                <button class="button" onclick="createPlaylist()">New playlist</button>
            </div>

            <?php

            $stmt = $conn->prepare("SELECT * FROM playlists WHERE user_id=:userId");
            $stmt->bindParam('userId', $userId);
            $stmt->execute();

            $playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($playlists)) {
                echo "<span class='noResults'>You dont have any playlist yet. </span>";
            } else {

                foreach ($playlists as $play) {
                    echo "<div class ='gridItem' role='link' tabindex='0' onclick='window.open(\"playlist.php?id=" . $play['playlist_id'] . "\", \"_self\");'> 
                <div class='playlistImage'>
                    <img src='assets/vendors/icons/playlist.png' alt=''>
                </div>    
                
                <div class='gridInfo'>" . $play['name'] . " </div>

                </div>";
                }
            }
            ?>

        </div>
    </div>

<?
include("footer.php");