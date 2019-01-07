let userId;

function createPlaylist() {
    let popup = prompt("Please enter the name of your new playlist.");

    if (popup !== null) {

        $.post("includes/ajax/createPlaylist.php", {name: popup, userId: userId}).done(function (err) {

            if (err !== "") {
                alert(err);
                return;
            }

            window.open("yourPlaylists.php", "_self");
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

            window.open("yourPlaylists.php", "_self");
        });
    }
}

function logout() {
    $.post("includes/ajax/logout.php", function () {
        location.reload();
    })
}

function updateEmail(email) {
    $.post("includes/ajax/updateEmail.php", {email: email, username: userLoggedIn}).done(function (err) {
        if (err !== "") {
            alert(err);
        }
    });
}

function updatePasswd(odlPasswordClass, newPasswordClass1, newPasswordClass2) {
    let oldPasswordValue = $("." + odlPasswordClass).val();
    let newPasswordValue1 = $("." + newPasswordClass1).val();
    let newPasswordValue2 = $("." + newPasswordClass2).val();

    $.post("includes/ajax/updatePassword.php", {
        oldPassword: oldPasswordValue,
        newPassword1: newPasswordValue1,
        newPassword2: newPasswordValue2,
        username: userLoggedIn
    }).done(function (err) {
            if (err !== "") {
                alert(err);
            }
        })
}