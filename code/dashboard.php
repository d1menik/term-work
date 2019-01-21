<?php
include("includes/includes.php");

if (isset($_GET['term'])) {
    $term = urldecode($_GET['term']);

} else {
    $term = "";
}

?>

    <div class="dashboardContainer">
        <div class="topOverview">
            <h2>Dashboard</h2>
        </div>
        <div class="mainOverview">
            <div class="leftOverview">
                <div class="mainOverview">
                    <span>Total registered users: <?
                        echo getNumberOfUsers($conn) ?></span>
                    <span>Total premium users: <?
                        echo totalPremiumUsers($conn) ?></span>
                    <span>Total songs: <?
                        echo getTotalNumberOfSongs($conn) ?></span>
                    <span>Total artists: <?
                        echo getNumberOfArtists($conn) ?></span>
                    <span>Total genres: <?
                        echo getNumberOfGenres($conn) ?></span>
                    <span>Total albums: <?
                        echo getNumberOfAlbums($conn) ?></span>
                </div>

                <div class="searchByEmail">
                    <h2 class="searchEmail">Search user by email</h2>
                    <form method="post">
                        <input type="text" name="email" placeholder="insert email address" class="emailInput"
                               onfocus="let val = this.value; this.value=''; this.value = val;">
                    </form>
                </div>
            </div>

            <div class="rightOverview">
                <div class="users">
                    <? renderUsersTable($conn, "Table of all users"); ?>
                </div>
                <div class="users premiumUsers">
                    <? renderPremiumUsers($conn, "Table of premium users"); ?>
                </div>
            </div>
        </div>
    </div>

<?
function getNumberOfUsers($conn)
{
    $stmt = $conn->prepare("SELECT user_id FROM users");
    $stmt->execute();

    $numberOfSongs = $stmt->rowCount();
    return $numberOfSongs;

}

function totalPremiumUsers($conn)
{
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE isPremium is true");
    $stmt->execute();

    $numberOfSongs = $stmt->rowCount();
    return $numberOfSongs;
}

function getTotalNumberOfSongs($conn)
{
    $stmt = $conn->prepare("SELECT song_id FROM songs");
    $stmt->execute();

    $numberOfSongs = $stmt->rowCount();
    return $numberOfSongs;
}

function getNumberOfArtists($conn)
{
    $stmt = $conn->prepare("SELECT artist_id FROM artists");
    $stmt->execute();

    $numberOfArtist = $stmt->rowCount();
    return $numberOfArtist;
}

function getNumberOfGenres($conn)
{
    $stmt = $conn->prepare("SELECT genre_id FROM genres");
    $stmt->execute();

    $numberOfGenres = $stmt->rowCount();
    return $numberOfGenres;
}

function getNumberOfAlbums($conn)
{
    $stmt = $conn->prepare("SELECT album_id FROM albums");
    $stmt->execute();

    $numberOfGenres = $stmt->rowCount();
    return $numberOfGenres;
}

function renderUsersTable($conn, $string)
{
    $userRepo = new UserRepository($conn);
    $allUsersResult = $userRepo->getAllUsers();

    $datatable = new DataTable($allUsersResult, $string);
    $datatable->addColumn("user_id", "ID");
    $datatable->addColumn("email", "Email");
    $datatable->addColumn("created", "Created");
    $datatable->render();
}

function renderPremiumUsers($conn, $string)
{
    $userRepo = new UserRepository($conn);
    $allUsersResult = $userRepo->getAllPremiumUsers();
    $datatable = new DataTable($allUsersResult, $string);
    $datatable->addColumn("user_id", "ID");
    $datatable->addColumn("email", "Email");
    $datatable->addColumn("created", "Created");
    $datatable->render();
}


?>
    <script>
        $(".searchInput").focus();

        $(function () {
            let timer;

            $(".emailInput").keyup(function () {
                clearTimeout(timer);

                timer = setTimeout(function () {
                    let val = $(".emailInput").val();
                    openPage(`dashboard.php?term=${val}`);
                }, 1500)
            })
        })
    </script>
<?php

if ($term == "") {
    exit();
}
    $userRepo1 = new UserRepository($conn);
    $usersByEmail1 = $userRepo1->getByEmail($term);
    $datatable1 = new DataTable($usersByEmail1, '');
    $datatable1->addColumn("user_id", "ID");
    $datatable1->addColumn("email", "Email");
    $datatable1->addColumn("created", "Created");

    ?>
    <div class="emailTable">
        <? $datatable1->render(); ?>
    </div>
