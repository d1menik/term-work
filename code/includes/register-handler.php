<?php
if (isset($_POST['registerBtn'])) {
    $un = $_POST['username'];
    $em = $_POST['email'];
    $pw = $_POST['passwd'];
    $pw2 = $_POST['passwd2'];

    $wasSuccessful = $account->validateUser($un, $em, $pw, $pw2);

    if($wasSuccessful) {
        registerUser(Connection::getPdoInstance());
        $_SESSION['userLoggedIn'] = $un;
        header("Location: index.php");
    }
}

function registerUser ($conn) {
    try {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, created) VALUES (:username, :email, :passwd, CURRENT_TIMESTAMP)");

        $stmt->bindParam(':username', $_POST["username"]);
        $stmt->bindParam(':email', $_POST["email"]);

        $password = password_hash($_POST["passwd"], PASSWORD_BCRYPT);
        $stmt->bindParam(':passwd', $password);

        $stmt->execute();
    }
    catch (PDOException $e) {
        echo "Something went wrong, please try again." . $e;
    }
}