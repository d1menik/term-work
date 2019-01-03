let userId;

function createPlaylist() {
    let popup = prompt("Please enter the name of your new playlist.");

    if (popup !== null) {

        $.post("includes/ajax/createPlaylist.php", {name: popup, userId: userId}).done(function (err) {

            if (err !== "") {
                alert(err);
                return;
            }

            window.open("yourPlaylists.php" , "_self");
        });
    }
}
function deletePlaylist(playlistId) {
    let popup = confirm("Are you sure want to delete this playlist?");

    if (popup) {
        $.post("includes/ajax/deletePlaylist.php", {playlistId: playlistId}).done(function (err) {

            if (err !== "") {
                alert(err);
                return;
            }

            window.open("yourPlaylists.php" , "_self");
        });
    }
}