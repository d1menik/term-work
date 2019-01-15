<?php
include("includes/includes.php");

if (isset($_GET['id'])) {
    $playlistId = ($_GET['id']);
} else {
    header("Location: index.php");
}

$playlist = new Playlist($conn, $playlistId);

?>

    <div class="albumInfo">
        <div class="leftSection">
            <img alt="logo" src="assets/vendors/icons/playlist.png">
        </div>

        <div class="rightSection">
            <h2><? echo $playlist->getName(); ?></h2>
            <p>Owner <? echo $userLoggedIn->getUsername(); ?></p>
            <p> <? echo $playlist->getNumberOfSongs(); ?> songs</p>
            <button class="button" onclick="deletePlaylist('<?php echo $playlistId; ?>')">Delete Playlist</button>
        </div>
    </div>

    <div class="trackContainer">
        <ul class="trackList">
            <?php
            $userId = $userLoggedIn->getUserId();

            $stmt = $conn->prepare("SELECT * FROM playlists WHERE user_id=:userId");
            $stmt->bindParam('userId', $userId);
            $stmt->execute();

            $playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);


            $songsIdArray = $playlist->getSongIds();

            $i = 1;

            foreach ($songsIdArray as $song_id) {

                $playlistSong = new Song($conn, $song_id);

                echo "<li class='trackListRow'>
                         <div class='trackCount'>
                            <img src='assets/vendors/icons/play-white.png' alt='Play button' class='play' onclick='setTrack(\"" . $playlistSong->getId() . "\", tempPlaylist, true)'>
                            <span class='trackNumber'>$i</span>
                         </div>

                         <div class='trackTitle'>
                            <span>" . $playlistSong->getTitle() . "</span>
                          </div>

                          <div class='trackOption'>
                            <img src='assets/vendors/icons/more.png' alt='More Button' class='optionBtn'>
                             <div class='dropdown-content'> ";
                                foreach ($playlists as $play) {
                                    $name = $play['name'];
                                    echo "<span role='link'>$name</span>";
                                }
                            echo "
                            </div>
                          </div>

                          <div class='trackDuration'>
                            <span class='duration'>" . $playlistSong->getDuration() . " </span>
                          </div>

                      </li>";
                $i++;
            }
            ?>

            <script>
                tempSongIds = '<?php echo json_encode($songsIdArray); ?>';
                tempPlaylist = JSON.parse(tempSongIds);
            </script>

        </ul>
    </div>

<?
