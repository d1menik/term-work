<?php
if (isset($_POST['registerBtn'])) {
    $un = $_POST['username'];
    $em = $_POST['email'];
    $pw = $_POST['passwd'];
    $pw2 = $_POST['passwd2'];

    $wasSuccessful = $account->validateUser($un, $em, $pw, $pw2);

    if($wasSuccessful) {
        registerUser();
    }
}

function registerUser () {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :passwd)");

    $stmt->bindParam(':username', $_POST["username"]);
    $stmt->bindParam(':email', $_POST["email"]);

    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bindParam(':passwd', $password);

    $stmt->execute();
    echo "You were successfully registered";
}