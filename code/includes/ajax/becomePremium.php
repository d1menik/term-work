<?php
include ("../../config.php");

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    $stmt = $conn->prepare("UPDATE users SET isPremium = TRUE, premiumExpire = DATE_ADD(NOW(), INTERVAL 1 month) WHERE username=:username");
    $stmt->bindParam('username', $username);
    $stmt->execute();

    $count = $stmt->rowCount();

    if ($count !== 0) {
        echo "Your subscription was successfully updated.";
        exit();
    }
}

//AND