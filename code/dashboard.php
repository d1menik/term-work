<?php
include("includes/includes.php");
?>

    <div class="dashboardContainer">
        <div class="topContainer">
            <h2>Dashboard</h2>
        </div>
        <div class="mainSection">
            <div class="leftSection">
                <div class="mainOverview">
                    <span>Total registered users: <?echo getNumberOfUsers($conn)?></span>
                    <span>Total premium users: <?echo totalPremiumUsers($conn)?></span>
                </div>
            </div>
            <div class="rightSection">
                <div class="users">

                </div>
                <div class="premiumUsers">

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

function totalPremiumUsers($conn) {
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE isPremium is true");
    $stmt->execute();

    $numberOfSongs = $stmt->rowCount();
    return $numberOfSongs;
}


