<?php
include("config.php");
include("includes/classes/Connection.php");
include("includes/classes/Random.php");

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
                    $random = new Random(Connection::getPdoInstance());

                    $randAlbums = $random->getSomeAlbums();

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
        $randSongs = $random->getSomeSongs();
        $resultArr = array();

        foreach ($randSongs as $row) {
            array_push($resultArr, $row);
        }

        $jsonArr = json_encode($resultArr);

        ?>

        <script>
            $(document).ready(function () {
                let newPlaylist = <?php echo $jsonArr ?>;
                audioElement = new Audio();

                console.log(newPlaylist[0].path);
                audioElement.setSrc(newPlaylist[0]);
                audioElement.play();
                audioElement.pause();
            })
        </script>

        <div id="playingBar">
            <div id="playingLeft">
                <div class="content">
                    <span class="albumLink">
                        <img class="albumArtWork" src="assets/vendors/images/logoPath/summer-jaz.png" alt="">
                    </span>
                    <div class="trackInfo">
                        <span class="trackName">Venom</span>
                        <span class="artistName">Eminem</span>
                    </div>
                </div>
            </div>
            <div id="playingCenter">
                <div class="playerControls">
                    <div class="buttons">
                        <button class="controlButton previous" title="Previous button">
                            <img src="assets/vendors/icons/previous.png" alt="Previous">
                        </button>
                        <button class="controlButton play" title="Play button">
                            <img src="assets/vendors/icons/play.png" alt="Play">
                        </button>
                        <button class="controlButton pause" title="Pause button" style="display: none">
                            <img src="assets/vendors/icons/pause.png" alt="Pause">
                        </button>
                        <button class="controlButton next" title="Next button">
                            <img src="assets/vendors/icons/next.png" alt="Next">
                        </button>
                    </div>
                </div>
            </div>
            <div id="playingRight">
                <div class="volumeBar">
                    <button class="controlButton volume" title="Volume button">
                        <img src="assets/vendors/icons/volume.png" alt="Volume">
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>