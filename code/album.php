<?php
include("config.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");


if (isset($_GET['id'])) {
    $albumId = ($_GET['id']);
} else {
    header("Location: index.php");
}

$album = new Album($conn, $albumId);
$artist = $album->getArtist();
?>

<div class="albumInfo">
    <div class="leftSection">
        <img alt="logo" src="<?php echo $album->logoPath(); ?>">
    </div>

    <div class="rightSection">
        <h2><? echo $album->getTitle(); ?></h2>
        <p>By <? echo $artist->getName(); ?></p>
    </div>
</div>

    <div class="trackContainer">
        <ul class="trackList">
            <?php
            $songsIdArray = $album->getSongIds();

            $i = 1;

            foreach ($songsIdArray as $song_id) {

                $albumSong = new Song($conn, $song_id);
                $albumArtist = $albumSong->getArtist();

                echo "<li class='trackListRow'>
                         <div class='trackCount'>
                            <img src='assets/vendors/icons/play-white.png' alt='Play button' class='play'>
                            <span class='trackNumber'>$i</span>
                         </div>

                         <div class='trackInfo'>
                            <span class='trackName'>" . $albumSong->getTitle() . "</span>
                            <span class='artistName'>" . $albumArtist->getName() . "</span>
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
            ?>

        </ul>
    </div>

<?