<?php
include("header.php");

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

<?
include("footer.php");