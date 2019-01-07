<?php
include("../../config.php");

if (!isset($_POST['username'])) {
    echo "ERROR: Could not set username!";
    exit();
}

if (!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2'])) {
    echo "Not all passwords have been set.";
    exit();
}

if (empty($_POST['oldPassword']) || empty($_POST['newPassword1']) || empty($_POST['newPassword2'])) {
    echo "Please fill in all fields.";
    exit();
}

$username = $_POST['username'];
$oldPassword = $_POST['oldPassword'];
$newPassword1 = $_POST['newPassword1'];
$newPassword2 = $_POST['newPassword2'];

$stmt = $conn->prepare("SELECT * FROM users WHERE username=:username");
$stmt->bindParam('username', $username);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User was not found.";
    exit();
}

$validPassword = password_verify($oldPassword, $user['password']);

if (!$validPassword) {
    echo "Password is incorrect";
    exit();
}

if ($newPassword1 !== $newPassword2) {
    echo "Your new passwords do not match";
    exit();
}

if (strlen($newPassword1) > 30 || strlen($newPassword1) < 5) {
    echo "Your password must be between 5 or 30 characters";
    exit();
}

updatePassword($newPassword1, $conn, $username);


function updatePassword($newPassword, $conn, $username) {
    $stmt = $conn->prepare("UPDATE users SET password=:password WHERE username=:username");

    $newPasswd = password_hash($newPassword, PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $newPasswd);
    $stmt->bindParam('username', $username);

    $stmt->execute();
    echo "Password was successfully updated.";
}
?>

