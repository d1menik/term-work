<?php
include("config.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");
include("includes/classes/User.php");
include("includes/classes/Playlist.php");

if (isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = new User($conn, $_SESSION['userLoggedIn']);
    $userId = $userLoggedIn->getUserId();
    $username = $userLoggedIn->getUsername();
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
    <script> userId = '<?php echo $userId ;?>';</script>
    <script> userLoggedIn = '<?php echo $username ;?>';</script>
</head>
<body>
<div id="mainContainer">
    <div id="topContainer">
        <div id="navBarContainer">
            <nav class="navBar">
                <span onclick="openPage('index.php')" class="logo">
                    <img src="assets/vendors/icons/logo.png" alt="logo">
                </span>
                <div class="group">
                    <div class="navItem searchContainer">
                        <span onclick="openPage('search.php')" class="navItemLink">Search
                            <img src="assets/vendors/icons/search.png" class="searchIcon" alt="Search">
                        </span>
                    </div>
                </div>
                <div class="group">
                    <div class="navItem">
                        <span role="link" onclick="openPage('yourPlaylists.php')" class="navItemLink">Your Music</span>
                    </div>
                    <div class="navItem">
                        <span onclick="openPage('settings.php')" class="navItemLink">Settings</span>
                    </div>
                </div>
            </nav>
        </div>
        <div id="viewContainer">
            <div id="mainContent">