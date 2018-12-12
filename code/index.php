<?php
include("config.php");

if (isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = $_SESSION['userLoggedIn'];
} else {
    header("Location: register.php");
}

?>

<html>
<head>
    <title>Welcome to Playbox</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/Audio.js"></script>
</head>
<body>
<div id="mainContainer">
    <div id="topContainer">
        <div id="navBarContainer">
            <nav class="navBar">
                <a href="index.php" class="logo">
                    <img src="assets/vendors/icons/logo.png" alt="logo">
                </a>
                <div class="group">
                    <div class="navItem searchContainer">
                        <a href="#" class="navItemLink">Search
                            <img src="assets/vendors/icons/search.png" class="searchIcon" alt="Search">
                        </a>
                    </div>
                </div>
                <div class="group">
                    <div class="navItem">
                        <a href="#" class="navItemLink">Browse</a>
                    </div>
                    <div class="navItem">
                        <a href="#" class="navItemLink">Your Music</a>
                    </div>
                    <div class="navItem">
                        <a href="#" class="navItemLink">Settings</a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="viewContainer">
            <div id="mainContent">
                <h1>Discover For You</h1>

                <div class="gridContainer">

                    <?php
                    $stmt = $conn->prepare("SELECT * FROM albums ORDER BY RAND() LIMIT 10");
                    $stmt->execute();
                    $randAlbums = $stmt->fetchAll();

                    foreach ($randAlbums as $row) {
                        $logoPath = $row['logoPath'];
                        $title = $row['title'];
                        $id = $row['album_id'];

                        echo "<div class ='gridItem'>
                              <a href='album.php?id=$id'>
                              <img src=$logoPath alt='logo'>
                              <div class='gridInfo'>$title</div>
                              </a>
                              </div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div id="playingBarContainer">
        <?php

        $stmt = $conn->prepare("SELECT * FROM songs ORDER BY RAND() LIMIT 10");
        $stmt->execute();
        $randSongs = $stmt->fetchAll();

        $resultArr = array();

        foreach ($randSongs as $row) {
            array_push($resultArr, $row['song_id']);
        }

        $jsonArr = json_encode($resultArr);

        ?>

        <script>
            $(document).ready(function () {
                let newPlaylist = <?php echo $jsonArr ?>;
                audioElement = new Audio();
                setTrack(newPlaylist[0], newPlaylist, false);
            });

            function prevSong() {
                if (audioElement.audio.currentTime >= 3 || currentIndex === 0) {
                    audioElement.setTime(0);
                } else {
                    currentIndex--;
                    setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
                }
            }

            function nextSong() {
                if (currentIndex === currentPlaylist.length - 1) {
                    currentIndex = 0;
                } else {
                    currentIndex++;
                }
                setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
            }

            function setTrack(trackId, newPlaylist, play) {

                if (newPlaylist !== currentPlaylist) {
                    currentPlaylist = newPlaylist;
                    currentIndex = currentPlaylist.indexOf(trackId);
                }

                $.post("includes/ajax/getSongJson.php", {song_id: trackId}, function (data) {

                    let track = JSON.parse(data);
                    $(".trackName").text(track[0].title);

                    $.post("includes/ajax/getArtistJson.php", {artist_id: track[0].artist_id}, function (data) {
                        let artist = JSON.parse(data);
                        $(".artistName").text(artist[0].name)
                    });

                    $.post("includes/ajax/getAlbumJson.php", {album_id: track[0].album_id}, function (data) {
                        let album = JSON.parse(data);
                        $(".albumArtWork").attr("src", album[0].logoPath)
                    });

                    audioElement.setSrc(track[0]);
                    if (play) {
                        playSong();
                    }
                });
            }

            function playSong() {
                if (audioElement.audio.currentTime === 0) {
                    $.post('includes/ajax/increasePlays.php', {song_id: audioElement.currentlyPlaying.song_id});
                }

                $(".controlButton.play").hide();
                $(".controlButton.pause").show();
                audioElement.play();
            }

            function pauseSong() {
                audioElement.pause();
                $(".controlButton.play").show();
                $(".controlButton.pause").hide();
            }

            function volumeOff() {
                audioElement.audio.volume = 0;

                $(".controlButton.mute").show();
                $(".controlButton.volume").hide();
            }

            function volumeOn() {
                audioElement.audio.volume = 1;

                $(".controlButton.mute").hide();
                $(".controlButton.volume").show();
            }
        </script>

        <div id="playingBar">
            <div id="playingLeft">
                <div class="content">
                    <span class="albumLink">
                        <img class="albumArtWork" src="" alt="">
                    </span>
                    <div class="trackInfo">
                        <span class="trackName"></span>
                        <span class="artistName"></span>
                    </div>
                </div>
            </div>
            <div id="playingCenter">
                <div class="playerControls">
                    <div class="buttons">
                        <button class="controlButton previous" title="Previous button">
                            <img src="assets/vendors/icons/previous.png" alt="Previous" onclick="prevSong()">
                        </button>
                        <button class="controlButton play" title="Play button" onclick="playSong();">
                            <img src="assets/vendors/icons/play.png" alt="Play">
                        </button>
                        <button class="controlButton pause" title="Pause button" style="display: none"
                                onclick="pauseSong();">
                            <img src="assets/vendors/icons/pause.png" alt="Pause">
                        </button>
                        <button class="controlButton next" title="Next button">
                            <img src="assets/vendors/icons/next.png" alt="Next" onclick="nextSong();">
                        </button>
                    </div>
                </div>
            </div>
            <div id="playingRight">
                <div class="volumeBar">
                    <button class="controlButton volume" title="Volume button" onclick="volumeOff();">
                        <img src="assets/vendors/icons/volume.png" alt="Volume">
                    </button>
                    <button class="controlButton mute" title="Mute button" onclick="volumeOn();" style="display: none;">
                        <img src="assets/vendors/icons/volume-mute.png" alt="Volume">
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>