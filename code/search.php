<?php
include("includes/includes.php");

if (isset($_GET['term'])) {
    $term = urldecode($_GET['term']);

} else {
    $term = "";
}
?>
    <div class="search">
        <h4>Search for any Song or Album.</h4>
        <input type="text" class="searchInput" value="<?php echo $term ?>" placeholder="Search..."
               onfocus="let val = this.value; this.value=''; this.value = val;">
    </div>

    <script>
        $(".searchInput").focus();

        $(function () {
            let timer;

            $(".searchInput").keyup(function () {
                clearTimeout(timer);

                timer = setTimeout(function () {
                    let val = $(".searchInput").val();
                    openPage(`search.php?term=${val}`, "_self");
                }, 1500)
            })
        })
    </script>

<?
if ($term == "") {
    exit();
}

?>

    <div class="trackContainer">
        <h2>Songs</h2>
        <ul class="trackList">
            <?php
            $userId = $userLoggedIn->getUserId();

            $stmt = $conn->prepare("SELECT * FROM playlists WHERE user_id=:userId");
            $stmt->bindParam('userId', $userId);
            $stmt->execute();

            $playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $conn->prepare("SELECT song_id FROM songs WHERE title LIKE '$term%' LIMIT 10");
            $stmt->execute();

            $songIds = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($songIds)) {
                echo "<span class='noResults'>No songs found matching " . $term . "</span>";
            } else {
                $i = 1;

                foreach ($songIds as $song) {
                    $albumSong = new Song($conn, $song["song_id"]);

                    $songId = $albumSong->getId();

                    echo "<li class='trackListRow borderBottom'>
                         <div class='trackCount'>
                            <img src='assets/vendors/icons/play-white.png' alt='Play button' class='play' onclick='setTrack(\"" . $albumSong->getId() . "\", false, true)'>
                            <span class='trackNumber'>$i</span>
                         </div>

                         <div class='trackTitle'>
                            <span>" . $albumSong->getTitle() . "</span>
                          </div>

                          <div class='trackOption'>
                            <img src='assets/vendors/icons/more.png' alt='More Button' class='optionBtn'>
                            <div class='dropdown-content'> ";
                                foreach ($playlists as $play) {
                                    $name = $play['name'];
                                    $playlistId = $play['playlist_id'];
                                    echo "<span class='addToPlaylist' onclick='toPlaylist($playlistId, $songId)'>$name</span>";
                                }
                            echo "
                            </div>
                          </div>

                          <div class='trackDuration'>
                            <span class='duration'>" . $albumSong->getDuration() . " </span>
                          </div>

                      </li>";
                    $i++;
                }
            }
            ?>
        </ul>
    </div>
    <div class="gridContainer">
        <h2>Albums</h2>
        <?php
        $stmt = $conn->prepare("SELECT * FROM albums WHERE title LIKE '$term%' LIMIT 10");
        $stmt->execute();

        $albumsArr = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($albumsArr)) {
            echo "<span class='noResults'>No albums found matching " . $term . "</span>";
        } else {
            foreach ($albumsArr as $albums) {
                $logoPath = $albums['logoPath'];
                $title = $albums['title'];
                $id = $albums['album_id'];

                echo "<div class ='gridItem'>
                 <a href='album.php?id=$id'>
                <img src=$logoPath alt='logo'>
                <div class='gridInfo'>$title</div>
              </div>";
            }
        }
        ?>

    </div>
<?