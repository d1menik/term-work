<?php
include("header.php");

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
                    window.open(`search.php?term=${val}`, "_self");
                }, 1500)
            })
        })
    </script>

<?
if ($term == "") {
    include("footer.php");
    exit();
}

?>

    <div class="trackContainer">
        <h2>Songs</h2>
        <ul class="trackList">
            <?php

            $stmt = $conn->prepare("SELECT song_id FROM songs WHERE title LIKE '$term%' LIMIT 10");
            $stmt->execute();

            $songIds = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($songIds)) {
                echo "<span class='noResults'>No songs found matching " . $term . "</span>";
            } else {
                $i = 1;

                foreach ($songIds as $song) {
                    $albumSong = new Song($conn, $song["song_id"]);

                    echo "<li class='trackListRow borderBottom'>
                         <div class='trackCount'>
                            <img src='assets/vendors/icons/play-white.png' alt='Play button' class='play'>
                            <span class='trackNumber'>$i</span>
                         </div>

                         <div class='trackTitle'>
                            <span>" . $albumSong->getTitle() . "</span>
                          </div>

                          <div class='trackOption'>
                            <img src='assets/vendors/icons/more.png' alt='More Button' class='optionBtn'>
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
include("footer.php");
