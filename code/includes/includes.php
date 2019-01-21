<?php
// if request was send via ajax
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    include("config.php");
    include("classes/Artist.php");
    include("classes/Album.php");
    include("classes/Song.php");
    include("classes/User.php");
    include("classes/Playlist.php");
    include ("classes/DataTable.php");
    include ("classes/UserRepository.php");

    if (isset($_GET['userLoggedIn'])) {
        $userLoggedIn = new User($conn, $_GET['userLoggedIn']);
    } else {
        echo "Username variable was not passed into page. Check the open JS function.";
        exit();
    }

} else {
    include('header.php');
    include('footer.php');

    $url = $_SERVER['REQUEST_URI'];
    echo "<script> openPage('$url') </script>";
    exit();
}