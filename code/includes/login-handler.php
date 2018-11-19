<?php
if (isset($_POST['loginBtn'])) {
    $username = $_POST['loginUsername'];
    $passwd = $_POST['loginPasswd'];

    $result = $account->login($username, $passwd);
    if($result) {
        $_SESSION['userLoggedIn'] = $username;
        header("Location: index.php");
    }
}